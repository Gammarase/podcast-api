<?php

namespace App\Policies;

use App\Models\Episode;
use Illuminate\Foundation\Auth\User as Authenticatable;

class EpisodePolicy extends AbstractPolicy
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
    public function view(Authenticatable $user, Episode $episode): bool
    {
        return $this->isAdmin($user) || $episode->podcast->admin_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Authenticatable $user): bool
    {
        return $this->authorizedAuthor($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Authenticatable $user, Episode $episode): bool
    {
        return $this->isAdmin($user) || $episode->podcast->admin_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Authenticatable $user, Episode $episode): bool
    {
        return $this->isAdmin($user) || $episode->podcast->admin_id === $user->id;
    }
}
