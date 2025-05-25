<?php

namespace App\Nova;

use App\Models\TicketResponse as TicketResponseModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;

class TicketResponse extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\TicketResponse>
     */
    public static $model = \App\Models\TicketResponse::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Support Management';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'message',
    ];

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Ticket Responses';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return 'Ticket Response';
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

            BelongsTo::make('Ticket')
                ->sortable()
                ->searchable(),

            Badge::make('Type')
                ->map([
                    TicketResponseModel::TYPE_CUSTOMER => 'info',
                    TicketResponseModel::TYPE_STAFF => 'success',
                    TicketResponseModel::TYPE_INTERNAL => 'warning',
                ])
                ->labels([
                    TicketResponseModel::TYPE_CUSTOMER => 'Customer',
                    TicketResponseModel::TYPE_STAFF => 'Staff',
                    TicketResponseModel::TYPE_INTERNAL => 'Internal',
                ])
                ->sortable(),

            Select::make('Type')
                ->options([
                    TicketResponseModel::TYPE_CUSTOMER => 'Customer',
                    TicketResponseModel::TYPE_STAFF => 'Staff',
                    TicketResponseModel::TYPE_INTERNAL => 'Internal',
                ])
                ->default(TicketResponseModel::TYPE_STAFF)
                ->rules('required')
                ->hideFromIndex(),

            Text::make('Author', function () {
                return $this->author_name;
            })
                ->onlyOnIndex(),

            BelongsTo::make('Customer User', 'user', User::class)
                ->nullable()
                ->hideFromIndex()
                ->searchable(),

            BelongsTo::make('Staff Member', 'adminUser', AdminUser::class)
                ->nullable()
                ->hideFromIndex()
                ->searchable(),

            Textarea::make('Message')
                ->rules('required')
                ->rows(4),

            Boolean::make('Internal Note', 'is_internal')
                ->help('Internal notes are only visible to staff members'),

            Number::make('Response Time (Minutes)', 'response_time_minutes')
                ->nullable()
                ->hideFromIndex()
                ->help('Time taken to respond in minutes'),

            DateTime::make('Created At')
                ->sortable()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            DateTime::make('Updated At')
                ->onlyOnDetail()
                ->hideWhenCreating()
                ->hideWhenUpdating(),
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
}
