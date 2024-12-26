<?php

namespace App\Policies;

use App\Models\Podcast;
use Illuminate\Foundation\Auth\User as Authenticatable;

class PodcastPolicy extends AbstractPolicy
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
    public function view(Authenticatable $user, Podcast $podcast): bool
    {
        return $this->isAdmin($user) || $podcast->admin_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Authenticatable $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Authenticatable $user, Podcast $podcast): bool
    {
        return $this->isAdmin($user) || $podcast->admin_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Authenticatable $user, Podcast $podcast): bool
    {
        return $this->isAdmin($user) || $podcast->admin_id === $user->id;
    }
}
