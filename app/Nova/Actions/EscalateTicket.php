<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\Ticket;
use App\Models\AdminUser;
use App\Models\Role;

class EscalateTicket extends Action
{
    use InteractsWithQueue;
    use Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Escalate Ticket';

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $ticketService = app(\App\Services\TicketService::class);
        $escalationReason = $fields->escalation_reason;
        $escalatedCount = 0;
        $errors = [];

        foreach ($models as $ticket) {
            if ($ticket instanceof Ticket) {
                try {
                    // Use service for consistent business logic
                    $success = $ticketService->escalateTicket($ticket, $escalationReason);
                    if ($success) {
                        $escalatedCount++;
                    }
                } catch (\Exception $e) {
                    $errors[] = "Ticket #{$ticket->ticket_number}: " . $e->getMessage();
                }
            }
        }

        if (!empty($errors)) {
            return Action::danger('Some escalations failed: ' . implode('; ', $errors));
        }

        return Action::message("Successfully escalated {$escalatedCount} ticket(s).");
    }

    /**
     * Find an available manager for escalation.
     *
     * @param int|null $departmentId
     * @return \App\Models\AdminUser|null
     */
    protected function findAvailableManager($departmentId = null)
    {
        // Look for managers or senior roles in the same department first
        $managerRoles = Role::whereIn('name', [
            'System Administrator',
            'Billing Manager',
            'Customer Support Manager',
            'IT Manager'
        ])->pluck('id');

        $query = AdminUser::whereIn('role_id', $managerRoles)
                          ->where('status', true);

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        return $query->first();
    }

    /**
     * Get the fields available on the action.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Textarea::make('Escalation Reason', 'escalation_reason')
                ->rules('required')
                ->rows(3)
                ->help('Explain why this ticket needs to be escalated'),
        ];
    }

    /**
     * Determine if the action is executable for the given request.
     */
    public function authorizedToSee(\Illuminate\Http\Request $request)
    {
        // Only show to authenticated staff members
        $user = $request->user();
        if (!$user) {
            return false;
        }

        return AdminUser::whereHas('user', function ($query) use ($user) {
            $query->where('id', $user->id);
        })->exists();
    }
}
