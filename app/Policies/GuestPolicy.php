<?php

namespace App\Policies;

use App\Models\Guest;
use Illuminate\Foundation\Auth\User as Authenticatable;

class GuestPolicy extends AbstractPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Authenticatable $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Authenticatable $user, Guest $guest): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Authenticatable $user): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Authenticatable $user, Guest $guest): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Authenticatable $user, Guest $guest): bool
    {
        return $this->isAdmin($user);
    }
}
