<?php

namespace App\Policies;

use App\Enums\AdminRole;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AbstractPolicy
{
    protected function isAdmin(Authenticatable $user): bool
    {
        if ($user instanceof \App\Models\Admin) {
            return $user->role === AdminRole::ADMIN;
        }

        return false;
    }

    protected function authorizedAuthor(Authenticatable $user): bool
    {
        if ($user instanceof \App\Models\Admin) {
            return $user->role !== AdminRole::REQUESTER;
        }

        return false;
    }

    protected function isContentCreator(Authenticatable $user): bool
    {
        if ($user instanceof \App\Models\Admin) {
            return $user->role === AdminRole::CONTENT_CREATOR;
        }

        return false;
    }
}
