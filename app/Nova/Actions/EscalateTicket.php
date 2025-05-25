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
        $newPriority = $fields->priority;
        $escalationReason = $fields->escalation_reason;
        $escalatedCount = 0;

        foreach ($models as $ticket) {
            if ($ticket instanceof Ticket) {
                $updateData = [
                    'priority' => $newPriority,
                ];

                // Update SLA due date based on new priority
                $updateData['sla_due_at'] = Ticket::calculateSLADueDate($newPriority);

                // Add escalation note to internal notes
                $existingNotes = $ticket->internal_notes ?? '';
                $timestamp = now()->format('Y-m-d H:i:s');
                $user = auth()->user();
                $userName = $user->name ?? 'System';
                
                $escalationNote = "[{$timestamp}] {$userName}: Ticket escalated to " . ucfirst($newPriority) . " priority";
                if ($escalationReason) {
                    $escalationNote .= " - Reason: {$escalationReason}";
                }
                
                $updateData['internal_notes'] = $existingNotes ? $existingNotes . "\n\n" . $escalationNote : $escalationNote;

                // If escalating to urgent, try to assign to a manager
                if ($newPriority === Ticket::PRIORITY_URGENT && empty($ticket->assigned_to)) {
                    $manager = $this->findAvailableManager($ticket->department_id);
                    if ($manager) {
                        $updateData['assigned_to'] = $manager->id;
                    }
                }

                $ticket->update($updateData);
                $escalatedCount++;
            }
        }

        return Action::message("Successfully escalated {$escalatedCount} ticket(s) to {$newPriority} priority.");
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
            Select::make('New Priority', 'priority')
                ->options([
                    Ticket::PRIORITY_HIGH => 'High',
                    Ticket::PRIORITY_URGENT => 'Urgent',
                ])
                ->rules('required')
                ->default(Ticket::PRIORITY_HIGH)
                ->help('Select the escalated priority level'),

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
