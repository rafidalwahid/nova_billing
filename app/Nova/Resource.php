<?php

namespace App\Nova;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource as NovaResource;
use Laravel\Scout\Builder as ScoutBuilder;

abstract class Resource extends NovaResource
{
    /**
     * Build an "index" query for the given resource.
     */
    public static function indexQuery(NovaRequest $request, Builder $query): Builder
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
    public static function detailQuery(NovaRequest $request, Builder $query): Builder
    {
        return parent::detailQuery($request, $query);
    }

    /**
     * Build a "relatable" query for the given resource.
     *
     * This query determines which instances of the model may be attached to other resources.
     */
    public static function relatableQuery(NovaRequest $request, Builder $query): Builder
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

        // Customers cannot access admin resources (except Customer resource)
        if ($user->isCustomer() && static::class !== \App\Nova\Customer::class) {
            return false;
        }

        // Staff users have access based on permissions
        return true;
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
