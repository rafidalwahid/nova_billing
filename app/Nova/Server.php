<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Http\Requests\NovaRequest;

class Server extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Server>
     */
    public static $model = \App\Models\Server::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Infrastructure Management';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'hostname', 'ip_address',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            // Basic Information
            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255')
                ->displayUsing(function ($name) {
                    return $name . ' (' . $this->type_display . ')';
                })
                ->onlyOnIndex(),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255')
                ->hideFromIndex(),

            Text::make('Hostname')
                ->sortable()
                ->rules('required', 'max:255')
                ->help('Server hostname or FQDN'),

            Text::make('IP Address')
                ->sortable()
                ->rules('required', 'ip')
                ->help('Server IP address'),

            Number::make('Port')
                ->default(22)
                ->rules('required', 'integer', 'min:1', 'max:65535')
                ->help('SSH/Connection port (default: 22)'),

            // Server Group Relationship
            BelongsTo::make('Server Group')
                ->sortable()
                ->rules('required')
                ->help('Assign server to a server group'),

            // Server Configuration
            Select::make('Type')
                ->options([
                    'shared' => 'Shared Hosting',
                    'vps' => 'VPS Server',
                    'dedicated' => 'Dedicated Server',
                    'cloud' => 'Cloud Server',
                ])
                ->displayUsingLabels()
                ->sortable()
                ->rules('required', 'in:shared,vps,dedicated,cloud')
                ->filterable(),

            Select::make('OS', 'os')
                ->options([
                    'linux' => 'Linux',
                    'windows' => 'Windows Server',
                    'freebsd' => 'FreeBSD',
                ])
                ->displayUsingLabels()
                ->sortable()
                ->rules('required', 'in:linux,windows,freebsd')
                ->filterable(),

            Text::make('Control Panel')
                ->nullable()
                ->help('e.g., cPanel, Plesk, DirectAdmin')
                ->hideFromIndex(),

            // Connection Details
            Text::make('Username')
                ->nullable()
                ->help('SSH/Admin username')
                ->hideFromIndex(),

            Password::make('Password')
                ->nullable()
                ->help('SSH/Admin password (encrypted)')
                ->hideFromIndex()
                ->hideFromDetail(),

            Textarea::make('SSH Key')
                ->nullable()
                ->help('SSH private key (encrypted)')
                ->hideFromIndex()
                ->hideFromDetail()
                ->rows(3),

            // Status and Monitoring
            Badge::make('Status')->map([
                'active' => 'success',
                'inactive' => 'danger',
                'maintenance' => 'warning',
                'suspended' => 'danger',
            ])->sortable()
            ->displayUsing(function ($status) {
                return match($status) {
                    'active' => '🟢 Active',
                    'inactive' => '🔴 Inactive',
                    'maintenance' => '🟡 Maintenance',
                    'suspended' => '🔴 Suspended',
                    default => ucfirst($status),
                };
            }),

            Boolean::make('Is Monitored')
                ->default(true)
                ->help('Enable server monitoring'),

            DateTime::make('Last Ping')
                ->nullable()
                ->displayUsing(function ($value) {
                    if (!$value) return 'Never';
                    $diff = $value->diffForHumans();
                    $isOnline = $value->diffInMinutes(now()) <= 5;
                    return $isOnline ? "🟢 {$diff}" : "🔴 {$diff}";
                })
                ->sortable()
                ->hideFromIndex(),

            // Resource Usage (read-only on forms)
            Number::make('CPU Usage (%)')
                ->nullable()
                ->step(0.01)
                ->displayUsing(function ($value) {
                    if (!$value) return 'N/A';
                    $color = $value >= 90 ? '🔴' : ($value >= 75 ? '🟡' : '🟢');
                    return "{$color} {$value}%";
                })
                ->exceptOnForms(),

            Number::make('Memory Usage (%)')
                ->nullable()
                ->step(0.01)
                ->displayUsing(function ($value) {
                    if (!$value) return 'N/A';
                    $color = $value >= 90 ? '🔴' : ($value >= 75 ? '🟡' : '🟢');
                    return "{$color} {$value}%";
                })
                ->exceptOnForms(),

            Number::make('Disk Usage (%)')
                ->nullable()
                ->step(0.01)
                ->displayUsing(function ($value) {
                    if (!$value) return 'N/A';
                    $color = $value >= 90 ? '🔴' : ($value >= 75 ? '🟡' : '🟢');
                    return "{$color} {$value}%";
                })
                ->exceptOnForms(),

            Text::make('Uptime')
                ->displayUsing(function () {
                    return $this->uptime_display ?? 'Unknown';
                })
                ->exceptOnForms(),

            // Capacity Management
            Number::make('Max Accounts')
                ->default(100)
                ->rules('required', 'integer', 'min:1')
                ->help('Maximum hosting accounts this server can handle'),

            Number::make('Current Accounts')
                ->default(0)
                ->rules('required', 'integer', 'min:0')
                ->displayUsing(function ($value) {
                    $max = $this->max_accounts;
                    $percentage = $max > 0 ? round(($value / $max) * 100, 1) : 0;
                    $color = $percentage >= 90 ? '🔴' : ($percentage >= 75 ? '🟡' : '🟢');
                    return "{$color} {$value}/{$max} ({$percentage}%)";
                }),

            Number::make('Monthly Bandwidth (GB)')
                ->nullable()
                ->step(0.01)
                ->help('Monthly bandwidth allocation in GB')
                ->hideFromIndex(),

            Number::make('Disk Space (GB)')
                ->nullable()
                ->step(0.01)
                ->help('Total disk space in GB')
                ->hideFromIndex(),

            // API Configuration
            Code::make('API Config')
                ->json()
                ->nullable()
                ->help('API endpoints, keys, and configuration (JSON format)')
                ->hideFromIndex()
                ->hideFromDetail(),

            // Notes
            Textarea::make('Notes')
                ->nullable()
                ->help('Internal notes about this server')
                ->hideFromIndex()
                ->rows(3),

            // Relationships
            HasMany::make('Hosting Accounts'),
        ];
    }

    /**
     * Get the cards available for the resource.
     *
     * @return array<int, \Laravel\Nova\Card>
     */
    public function cards(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array<int, \Laravel\Nova\Filters\Filter>
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array<int, \Laravel\Nova\Lenses\Lens>
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array<int, \Laravel\Nova\Actions\Action>
     */
    public function actions(NovaRequest $request): array
    {
        return [];
    }
}
