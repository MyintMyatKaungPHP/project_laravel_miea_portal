<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $authUser): bool
    {
        return $authUser->can('ViewAny:Permission');
    }

    public function view(User $authUser, Permission $permission): bool
    {
        return $authUser->can('View:Permission');
    }

    public function create(User $authUser): bool
    {
        return $authUser->can('Create:Permission');
    }

    public function update(User $authUser, Permission $permission): bool
    {
        return $authUser->can('Update:Permission');
    }

    public function delete(User $authUser, Permission $permission): bool
    {
        return $authUser->can('Delete:Permission');
    }

    public function restore(User $authUser, Permission $permission): bool
    {
        return $authUser->can('Restore:Permission');
    }

    public function forceDelete(User $authUser, Permission $permission): bool
    {
        return $authUser->can('ForceDelete:Permission');
    }

    public function forceDeleteAny(User $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Permission');
    }

    public function restoreAny(User $authUser): bool
    {
        return $authUser->can('RestoreAny:Permission');
    }

    public function replicate(User $authUser, Permission $permission): bool
    {
        return $authUser->can('Replicate:Permission');
    }

    public function reorder(User $authUser): bool
    {
        return $authUser->can('Reorder:Permission');
    }
}
