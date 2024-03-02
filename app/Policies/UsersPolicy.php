<?php

namespace App\Policies;

use App\Models\User;

class UsersPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function change(User $user, User $anotherUser){
        return $user->can('change user') && $user->id !== $anotherUser->id;
    }

    public function delete(User $user, User $anotherUser){
        return $user->can('delete user') && $user->id !== $anotherUser->id;
    }

}
