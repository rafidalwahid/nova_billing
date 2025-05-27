<?php

namespace Billing\CustomerSupport;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class CustomerSupport extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     */
    public function boot(): void
    {
        Nova::mix('customer-support', __DIR__.'/../dist/mix-manifest.json');
    }

    /**
     * Build the menu that renders the navigation links for the tool.
     */
    public function menu(Request $request): MenuSection
    {
        \Log::info('CustomerSupport Tool Menu Called', [
            'user_id' => $request->user()?->id,
            'user_email' => $request->user()?->email,
        ]);

        return MenuSection::make('Customer Support')
            ->path('/customer-support')
            ->icon('support');
    }

    /**
     * Determine if the tool should be displayed for the given request.
     */
    public function authorize(Request $request): bool
    {
        $user = $request->user();
        $isCustomer = $user && $user->isCustomer();

        // Debug logging
        \Log::info('CustomerSupport Tool Authorization', [
            'user_exists' => $user ? true : false,
            'user_id' => $user?->id,
            'user_email' => $user?->email,
            'userable_type' => $user?->userable_type,
            'userable_id' => $user?->userable_id,
            'is_customer' => $isCustomer,
            'authorized' => $isCustomer,
        ]);

        return $isCustomer;
    }
}
