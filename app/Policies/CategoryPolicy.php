<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $authUser): bool
    {
        return $authUser->can('ViewAny:Category');
    }

    public function view(User $authUser, Category $category): bool
    {
        return $authUser->can('View:Category');
    }

    public function create(User $authUser): bool
    {
        return $authUser->can('Create:Category');
    }

    public function update(User $authUser, Category $category): bool
    {
        return $authUser->can('Update:Category');
    }

    public function delete(User $authUser, Category $category): bool
    {
        return $authUser->can('Delete:Category');
    }

    public function restore(User $authUser, Category $category): bool
    {
        return $authUser->can('Restore:Category');
    }

    public function forceDelete(User $authUser, Category $category): bool
    {
        return $authUser->can('ForceDelete:Category');
    }

    public function forceDeleteAny(User $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Category');
    }

    public function restoreAny(User $authUser): bool
    {
        return $authUser->can('RestoreAny:Category');
    }

    public function replicate(User $authUser, Category $category): bool
    {
        return $authUser->can('Replicate:Category');
    }

    public function reorder(User $authUser): bool
    {
        return $authUser->can('Reorder:Category');
    }
}
