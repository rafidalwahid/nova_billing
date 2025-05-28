<?php

namespace App\Policies;

use App\Models\Server;
use App\Models\User;

class ServerPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->canViewAny($user, 'infrastructure_management.view', false);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Server $server): bool
    {
        return $this->canView($user, $server, 'infrastructure_management.view', 'id');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->canCreate($user, 'infrastructure_management.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Server $server): bool
    {
        return $this->canUpdate($user, $server, 'infrastructure_management.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Server $server): bool
    {
        return $this->canDelete($user, 'infrastructure_management.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Server $server): bool
    {
        return $this->canRestore($user, 'infrastructure_management.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Server $server): bool
    {
        return $this->canForceDelete($user, 'infrastructure_management.force_delete');
    }

    /**
     * Determine whether the user can manage server monitoring.
     */
    public function manageMonitoring(User $user, Server $server): bool
    {
        return $this->hasPermission($user, 'infrastructure_management.monitor');
    }

    /**
     * Determine whether the user can access server credentials.
     */
    public function viewCredentials(User $user, Server $server): bool
    {
        return $this->hasPermission($user, 'infrastructure_management.view_credentials');
    }
}
