<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TeachingFactory;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeachingFactoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_teaching::factory');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TeachingFactory $teachingFactory): bool
    {
        return $user->can('view_teaching::factory') || $user->can('view_teaching::factory') && $teachingFactory->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_teaching::factory');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TeachingFactory $teachingFactory): bool
    {
        return $user->can('update_teaching::factory') || $user->can('update_teaching::factory') && $teachingFactory->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TeachingFactory $teachingFactory): bool
    {
        return $user->can('delete_teaching::factory') || $user->can('delete_teaching::factory') && $teachingFactory->user_id === $user->id;
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_teaching::factory');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, TeachingFactory $teachingFactory): bool
    {
        return $user->can('{{ ForceDelete }}');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('{{ ForceDeleteAny }}');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, TeachingFactory $teachingFactory): bool
    {
        return $user->can('{{ Restore }}');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('{{ RestoreAny }}');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, TeachingFactory $teachingFactory): bool
    {
        return $user->can('{{ Replicate }}');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('{{ Reorder }}');
    }
}
