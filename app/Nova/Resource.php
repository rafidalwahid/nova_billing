<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource as NovaResource;
use Laravel\Scout\Builder as ScoutBuilder;

abstract class Resource extends NovaResource
{
    /**
     * Build an "index" query for the given resource.
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    /**
     * Build a Scout search query for the given resource.
     */
    public static function scoutQuery(NovaRequest $request, ScoutBuilder $query): ScoutBuilder
    {
        return $query;
    }

    /**
     * Build a "detail" query for the given resource.
     */
    public static function detailQuery(NovaRequest $request, $query)
    {
        return parent::detailQuery($request, $query);
    }

    /**
     * Build a "relatable" query for the given resource.
     *
     * This query determines which instances of the model may be attached to other resources.
     */
    public static function relatableQuery(NovaRequest $request, $query)
    {
        return parent::relatableQuery($request, $query);
    }

    /**
     * Determine if the current user can view any resources.
     * By default, customers cannot access admin resources.
     */
    public static function authorizedToViewAny(Request $request): bool
    {
        $user = $request->user();

        // If no user, deny access
        if (!$user) {
            return false;
        }

        // Additional security: Check if user account is active
        if (!static::isUserAccountActive($user)) {
            return false;
        }

        // Customers can only access specific customer-facing resources
        if ($user->isCustomer()) {
            $allowedCustomerResources = [
                \App\Nova\Customer::class,
                \App\Nova\CustomerOrder::class,
                \App\Nova\CustomerOrderItem::class,
                \App\Nova\CustomerInvoice::class,
                \App\Nova\CustomerInvoiceLine::class,
                \App\Nova\CustomerTicket::class,
                \App\Nova\CustomerPayment::class,
                \App\Nova\CustomerSubscriptionItem::class,
                \App\Nova\Ticket::class, // For backward compatibility
            ];

            if (!in_array(static::class, $allowedCustomerResources)) {
                return false;
            }
        }

        // Staff users have access based on permissions
        return true;
    }

    /**
     * Check if user account is active and valid.
     */
    protected static function isUserAccountActive(User $user): bool
    {
        // Check if the polymorphic relationship exists
        if (!$user->userable) {
            return false;
        }

        // Check if the related account (Customer or AdminUser) is active
        if (method_exists($user->userable, 'getAttribute') &&
            $user->userable->getAttribute('status') !== null) {
            return (bool) $user->userable->status;
        }

        return true;
    }

    /**
     * Apply customer data isolation filter.
     * This ensures customers can only see their own data.
     */
    protected static function applyCustomerDataIsolation(Request $request, $query, string $customerIdField = 'customer_id')
    {
        $user = $request->user();

        if ($user && $user->isCustomer()) {
            // Double-check: ensure customer can only access their own data
            $query->where($customerIdField, $user->userable_id);
        }

        return $query;
    }

    /**
     * Determine if the current user can view the resource.
     */
    public function authorizedToView(Request $request): bool
    {
        return static::authorizedToViewAny($request);
    }

    /**
     * Determine if the current user can create new resources.
     */
    public static function authorizedToCreate(Request $request): bool
    {
        return static::authorizedToViewAny($request);
    }

    /**
     * Determine if the current user can update the resource.
     */
    public function authorizedToUpdate(Request $request): bool
    {
        return static::authorizedToViewAny($request);
    }

    /**
     * Determine if the current user can delete the resource.
     */
    public function authorizedToDelete(Request $request): bool
    {
        return static::authorizedToViewAny($request);
    }
}
