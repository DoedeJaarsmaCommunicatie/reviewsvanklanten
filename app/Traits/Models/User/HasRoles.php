<?php

namespace App\Traits\Models\User;

use App\User;
use Illuminate\Support\Arr;

/**
 * Class HasRoles
 * @package App\Traits\Models\User
 *
 * @mixin User
 */
trait HasRoles
{
    /**
     * @param string $role
     *
     * @return bool
     */
    public function hasRole($role = 'user'): bool
    {
        return $this->role === $role;
    }

    /**
     * @param string $flag
     *
     * @return bool
     */
    public function hasFlag($flag): bool
    {
        return in_array($flag, $this->flags?? [], true);
    }

    /**
     * @param string[] $flags
     *
     * @return bool
     */
    public function hasAnyFlag($flags)
    {
        foreach ($flags as $flag) {
            if (in_array($flag, $this->flags, true)) {
                return true;
            }
        }

        return false;
    }
}
