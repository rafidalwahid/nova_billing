<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Customer extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Customer>
     */
    public static $model = \App\Models\Customer::class;

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Customers';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return 'Customer';
    }

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Customer Management';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'full_name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'first_name', 'last_name', 'company_name',
    ];

    /**
     * Build an "index" query for the given resource.
     */
    public static function indexQuery(NovaRequest $request, Builder $query): Builder
    {
        return $query->with([
            'user',
            'orders',
            'subscriptions',
            'hostingAccounts',
            'domainRegistrations',
            'invoices',
            'payments',
            'transactions',
            'tickets'
        ]);
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Avatar::make('Profile Image')
                ->disk('public')
                ->path('avatars')
                ->prunable()
                ->maxWidth(50),

            Text::make('First Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Last Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Full Name', function () {
                return $this->first_name . ' ' . $this->last_name;
            })
                ->onlyOnIndex()
                ->sortable(),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->displayUsing(function () {
                    return $this->user ? $this->user->email : 'No email';
                })
                ->resolveUsing(function () {
                    return $this->user ? $this->user->email : '';
                }),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),

            Text::make('Phone')
                ->sortable()
                ->rules('nullable', 'max:20'),

            Text::make('Address')
                ->hideFromIndex()
                ->rules('nullable', 'max:255'),

            Text::make('City')
                ->hideFromIndex()
                ->rules('nullable', 'max:100'),

            Text::make('State')
                ->hideFromIndex()
                ->rules('nullable', 'max:100'),

            Text::make('Country')
                ->hideFromIndex()
                ->rules('nullable', 'max:100'),

            Text::make('Postal Code')
                ->hideFromIndex()
                ->rules('nullable', 'max:20'),

            Text::make('Company Name')
                ->nullable()
                ->sortable()
                ->rules('nullable', 'max:255'),

            Badge::make('Status')
                ->map([
                    true => 'success',
                    false => 'danger',
                ])
                ->labels([
                    true => 'Active',
                    false => 'Inactive',
                ])
                ->sortable(),

            DateTime::make('Creation Date', 'created_at')
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            DateTime::make('Last Login')
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            // Customer Summary Metrics (Detail View Only)
            Text::make('Total Orders', function () {
                return $this->orders()->count() . ' orders';
            })
                ->onlyOnDetail(),

            Text::make('Active Subscriptions', function () {
                return $this->subscriptions()->where('status', 'active')->count() . ' active';
            })
                ->onlyOnDetail(),

            Text::make('Total Spent', function () {
                $total = $this->payments()->sum('amount');
                return '$' . number_format($total, 2);
            })
                ->onlyOnDetail(),

            Text::make('Outstanding Balance', function () {
                $outstanding = $this->invoices()->where('status', '!=', 'paid')->sum('total');
                return '$' . number_format($outstanding, 2);
            })
                ->onlyOnDetail(),

            // Business Relationships - Core Services
            HasMany::make('Orders', 'orders', Order::class)
                ->sortable(),

            HasMany::make('Subscriptions', 'subscriptions', Subscription::class)
                ->sortable(),

            HasMany::make('Hosting Accounts', 'hostingAccounts', HostingAccount::class)
                ->sortable(),

            HasMany::make('Domain Registrations', 'domainRegistrations', DomainRegistration::class)
                ->sortable(),

            // Financial Relationships
            HasMany::make('Invoices', 'invoices', Invoice::class)
                ->sortable(),

            HasMany::make('Payments', 'payments', Payment::class)
                ->sortable(),

            HasMany::make('Transactions', 'transactions', Transaction::class)
                ->sortable(),

            // Support Relationship
            HasMany::make('Support Tickets', 'tickets', Ticket::class)
                ->sortable(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }

    /**
     * Determine if the current user can view any resources.
     */
    public static function authorizedToViewAny(Request $request): bool
    {
        return $request->user()->can('viewAny', \App\Models\Customer::class);
    }

    /**
     * Determine if the current user can view the resource.
     */
    public function authorizedToView(Request $request): bool
    {
        return $request->user()->can('view', $this->resource);
    }

    /**
     * Determine if the current user can create new resources.
     */
    public static function authorizedToCreate(Request $request): bool
    {
        return $request->user()->can('create', \App\Models\Customer::class);
    }

    /**
     * Determine if the current user can update the resource.
     */
    public function authorizedToUpdate(Request $request): bool
    {
        return $request->user()->can('update', $this->resource);
    }

    /**
     * Determine if the current user can delete the resource.
     */
    public function authorizedToDelete(Request $request): bool
    {
        return $request->user()->can('delete', $this->resource);
    }

    /**
     * Handle resource creation.
     */
    public static function afterCreate(NovaRequest $request, $model)
    {
        // Create associated User record for polymorphic relationship
        if ($request->has('password') && $request->password) {
            $user = User::create([
                'name' => $model->first_name . ' ' . $model->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'userable_type' => get_class($model),
                'userable_id' => $model->id,
            ]);
        }
    }

    /**
     * Handle resource updates.
     */
    public static function afterUpdate(NovaRequest $request, $model)
    {
        // Update associated User record
        if ($model->user) {
            $updateData = [
                'name' => $model->first_name . ' ' . $model->last_name,
                'email' => $request->email,
            ];

            // Only update password if provided
            if ($request->has('password') && $request->password) {
                $updateData['password'] = Hash::make($request->password);
            }

            $model->user->update($updateData);
        } elseif ($request->has('password') && $request->password) {
            // Create User record if it doesn't exist and password is provided
            User::create([
                'name' => $model->first_name . ' ' . $model->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'userable_type' => get_class($model),
                'userable_id' => $model->id,
            ]);
        }
    }
}
