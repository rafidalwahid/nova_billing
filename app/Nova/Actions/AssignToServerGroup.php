<?php

namespace App\Nova\Actions;

use App\Models\Product;
use App\Models\ServerGroup;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class AssignToServerGroup extends Action
{
    use InteractsWithQueue;
    use Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Assign to Server Group';

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $serverGroupId = $fields->server_group_id;
        $updatedCount = 0;
        $skippedCount = 0;

        foreach ($models as $product) {
            if ($product instanceof Product) {
                // Only assign hosting products to server groups
                if ($product->type === 'hosting') {
                    $product->update(['server_group_id' => $serverGroupId]);
                    $updatedCount++;
                } else {
                    $skippedCount++;
                }
            }
        }

        $message = "Successfully assigned {$updatedCount} hosting product(s) to server group.";
        if ($skippedCount > 0) {
            $message .= " Skipped {$skippedCount} non-hosting product(s).";
        }

        return Action::message($message);
    }

    /**
     * Get the fields available on the action.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Select::make('Server Group', 'server_group_id')
                ->options(ServerGroup::active()->pluck('name', 'id'))
                ->rules('required')
                ->help('Select the server group to assign hosting products to'),
        ];
    }

    /**
     * Determine if the action is executable for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function authorizedToSee(\Illuminate\Http\Request $request)
    {
        // For now, allow all authenticated users to see this action
        // In production, you might want to check specific permissions
        return $request->user() !== null;
    }
}
