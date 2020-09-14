<?php

namespace App\Policies\Admin;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UpdatePolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     *
     * @return bool
     */
    public function checkVersion(User $user): bool
    {
        return $user->hasFlag('view-new-version');
    }

    public function updateApp(User $user): bool
    {
        return $user->hasFlag('update-app-version');
    }
}
