<?php

namespace App\Http\Controllers\CustomerPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CustomerServiceController extends Controller
{
    /**
     * Get all customer services overview.
     */
    public function index(Request $request): JsonResponse
    {
        $customer = $request->user()->userable;

        $services = [
            'hosting_accounts' => $customer->hostingAccounts()
                ->with(['server', 'product', 'subscription'])
                ->get(),
            'domain_registrations' => $customer->domainRegistrations()
                ->with(['product', 'subscription'])
                ->get(),
            'subscriptions' => $customer->subscriptions()
                ->with(['product', 'productPricing', 'items'])
                ->where('status', 'active')
                ->get(),
        ];

        return response()->json([
            'data' => $services
        ]);
    }

    /**
     * Get customer hosting accounts.
     */
    public function hostingAccounts(Request $request): JsonResponse
    {
        $customer = $request->user()->userable;

        $hostingAccounts = $customer->hostingAccounts()
            ->with(['server', 'product', 'subscription', 'domainRegistration'])
            ->paginate(10);

        return response()->json([
            'data' => $hostingAccounts->items(),
            'meta' => [
                'current_page' => $hostingAccounts->currentPage(),
                'last_page' => $hostingAccounts->lastPage(),
                'per_page' => $hostingAccounts->perPage(),
                'total' => $hostingAccounts->total(),
            ]
        ]);
    }

    /**
     * Get customer domain registrations.
     */
    public function domains(Request $request): JsonResponse
    {
        $customer = $request->user()->userable;

        $domains = $customer->domainRegistrations()
            ->with(['product', 'subscription', 'hostingAccount'])
            ->paginate(10);

        return response()->json([
            'data' => $domains->items(),
            'meta' => [
                'current_page' => $domains->currentPage(),
                'last_page' => $domains->lastPage(),
                'per_page' => $domains->perPage(),
                'total' => $domains->total(),
            ]
        ]);
    }

    /**
     * Get customer active subscriptions.
     */
    public function subscriptions(Request $request): JsonResponse
    {
        $customer = $request->user()->userable;

        $subscriptions = $customer->subscriptions()
            ->with(['product', 'productPricing', 'items', 'order'])
            ->latest()
            ->paginate(10);

        return response()->json([
            'data' => $subscriptions->items(),
            'meta' => [
                'current_page' => $subscriptions->currentPage(),
                'last_page' => $subscriptions->lastPage(),
                'per_page' => $subscriptions->perPage(),
                'total' => $subscriptions->total(),
            ]
        ]);
    }
}
