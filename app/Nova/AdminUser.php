<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUser extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\AdminUser>
     */
    public static $model = \App\Models\AdminUser::class;

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Staff';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return 'Staff Member';
    }

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Staff Management';

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
        'id', 'first_name', 'last_name',
    ];

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

            BelongsTo::make('Role'),

            BelongsTo::make('Department'),

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

            DateTime::make('Last Login')
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            HasMany::make('Assigned Tickets', 'assignedTickets', Ticket::class),

            HasMany::make('Ticket Responses', 'ticketResponses', TicketResponse::class),
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
