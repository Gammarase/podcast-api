<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminPolicy extends AbstractPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Authenticatable $user): bool
    {
        return $this->authorizedAuthor($user);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Authenticatable $user, Admin $admin): bool
    {
        return $this->isAdmin($user) || $user->id === $admin->id;
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
    public function update(Authenticatable $user, Admin $admin): bool
    {
        return $this->isAdmin($user) || $user->id === $admin->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Authenticatable $user, Admin $admin): bool
    {
        return $this->isAdmin($user);
    }
}
