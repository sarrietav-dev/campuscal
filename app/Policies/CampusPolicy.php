<?php

namespace App\Policies;

use App\Authorization\CampusPermissions;
use App\Models\Campus;
use App\Models\User;

class CampusPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(CampusPermissions::LIST->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Campus $campus): bool
    {
        return $user->can(CampusPermissions::VIEW->value);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(CampusPermissions::CREATE->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Campus $campus): bool
    {
        return $user->can(CampusPermissions::UPDATE->value);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Campus $campus): bool
    {
        return $user->can(CampusPermissions::DELETE->value);
    }
}
