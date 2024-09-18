<?php

namespace App\Policies;

use App\Models\User;
use App\Permissions\Abilities;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function delete(User $user, User $model)
    {
        return $user->tokenCan(Abilities::DELETE_USER);
    }

    public function update(User $user, User $model)
    {
        return $user->tokenCan(Abilities::UPDATE_USER);
    }

    public function replace(User $user, User $model)
    {
        return $user->tokenCan(Abilities::REPLACE_USER);
    }

    public function store(User $user)
    {
        return $user->tokenCan(Abilities::CREATE_USER);
    }
}
