<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerService
{
    /**
     * Create a new customer with associated user account.
     */
    public function createCustomer(array $customerData, array $userData): Customer
    {
        return DB::transaction(function () use ($customerData, $userData) {
            // Validate customer data
            $this->validateCustomerData($customerData);
            
            // Create customer
            $customer = Customer::create($customerData);
            
            // Create associated user account
            $user = User::create([
                'name' => $customer->full_name,
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
                'userable_type' => Customer::class,
                'userable_id' => $customer->id,
            ]);
            
            // Log customer creation
            Log::info('Customer created', [
                'customer_id' => $customer->id,
                'email' => $user->email,
                'name' => $customer->full_name,
            ]);
            
            return $customer->load('user');
        });
    }

    /**
     * Update customer information.
     */
    public function updateCustomer(Customer $customer, array $data): Customer
    {
        return DB::transaction(function () use ($customer, $data) {
            // Separate customer and user data
            $customerData = array_intersect_key($data, array_flip($customer->getFillable()));
            $userData = array_intersect_key($data, array_flip(['name', 'email']));
            
            // Update customer
            $customer->update($customerData);
            
            // Update associated user if data provided
            if (!empty($userData) && $customer->user) {
                if (isset($userData['name'])) {
                    $userData['name'] = $customer->full_name;
                }
                $customer->user->update($userData);
            }
            
            Log::info('Customer updated', [
                'customer_id' => $customer->id,
                'updated_fields' => array_keys($customerData),
            ]);
            
            return $customer->fresh(['user']);
        });
    }

    /**
     * Get paginated customers with filters.
     */
    public function getCustomers(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Customer::with(['user', 'tickets', 'orders'])
            ->orderBy('created_at', 'desc');

        // Apply filters
        if (!empty($filters['status'])) {
            if ($filters['status'] === 'active') {
                $query->active();
            } elseif ($filters['status'] === 'inactive') {
                $query->inactive();
            }
        }

        if (!empty($filters['search'])) {
            $searchTerm = $filters['search'];
            $query->where(function ($q) use ($searchTerm) {
                $q->where('first_name', 'like', "%{$searchTerm}%")
                  ->orWhere('last_name', 'like', "%{$searchTerm}%")
                  ->orWhere('company_name', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                      $userQuery->where('email', 'like', "%{$searchTerm}%");
                  });
            });
        }

        if (!empty($filters['country'])) {
            $query->where('country', $filters['country']);
        }

        if (!empty($filters['recently_active'])) {
            $query->recentlyActive($filters['recently_active']);
        }

        // Limit per page to prevent abuse
        $perPage = min($perPage, 100);

        return $query->paginate($perPage);
    }

    /**
     * Activate a customer account.
     */
    public function activateCustomer(Customer $customer): bool
    {
        if ($customer->isActive()) {
            return true;
        }

        $customer->update([
            'status' => true,
            'last_login' => now(),
        ]);

        Log::info('Customer activated', [
            'customer_id' => $customer->id,
            'email' => $customer->user?->email,
        ]);

        return true;
    }

    /**
     * Deactivate a customer account.
     */
    public function deactivateCustomer(Customer $customer, string $reason = null): bool
    {
        if (!$customer->isActive()) {
            return true;
        }

        $customer->update(['status' => false]);

        Log::warning('Customer deactivated', [
            'customer_id' => $customer->id,
            'email' => $customer->user?->email,
            'reason' => $reason,
        ]);

        return true;
    }

    /**
     * Get customer statistics.
     */
    public function getCustomerStats(Customer $customer): array
    {
        return [
            'total_orders' => $customer->orders()->count(),
            'total_spent' => $customer->orders()->sum('total_amount'),
            'active_subscriptions' => $customer->subscriptions()->where('status', 'active')->count(),
            'open_tickets' => $customer->tickets()->where('status', 'open')->count(),
            'total_tickets' => $customer->tickets()->count(),
            'last_order_date' => $customer->orders()->latest()->first()?->created_at,
            'account_age_days' => $customer->created_at->diffInDays(now()),
            'is_recently_active' => $customer->hasRecentActivity(),
        ];
    }

    /**
     * Validate customer data.
     */
    protected function validateCustomerData(array $data): void
    {
        $validator = validator($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'status' => 'boolean',
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException('Customer validation failed: ' . $validator->errors()->first());
        }
    }

    /**
     * Search customers by various criteria.
     */
    public function searchCustomers(string $query, int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return Customer::with('user')
            ->where(function ($q) use ($query) {
                $q->where('first_name', 'like', "%{$query}%")
                  ->orWhere('last_name', 'like', "%{$query}%")
                  ->orWhere('company_name', 'like', "%{$query}%")
                  ->orWhereHas('user', function ($userQuery) use ($query) {
                      $userQuery->where('email', 'like', "%{$query}%");
                  });
            })
            ->active()
            ->limit($limit)
            ->get();
    }

    /**
     * Get customers requiring attention (inactive, no recent orders, etc.).
     */
    public function getCustomersRequiringAttention(): \Illuminate\Database\Eloquent\Collection
    {
        return Customer::with(['user', 'orders', 'tickets'])
            ->where(function ($query) {
                $query->inactive()
                      ->orWhere('last_login', '<', now()->subDays(90))
                      ->orWhereDoesntHave('orders')
                      ->orWhereHas('tickets', function ($ticketQuery) {
                          $ticketQuery->where('status', 'open')
                                     ->where('priority', 'high');
                      });
            })
            ->orderBy('last_login', 'asc')
            ->limit(50)
            ->get();
    }
}
