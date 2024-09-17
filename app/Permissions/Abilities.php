<?php

namespace App\Permissions;

use App\Models\User;

final class Abilities
{
    // TICKETS

    public const CREATE_TICKET = 'ticket:create';

    public const UPDATE_TICKET = 'ticket:update';

    public const REPLACE_TICKET = 'ticket:replace';

    public const DELETE_TICKET = 'ticket:delete';

    // OWN TICKETS

    public const CREATE_OWN_TICKET = 'ticket:own:create';

    public const UPDATE_OWN_TICKET = 'ticket:own:update';

    public const REPLACE_OWN_TICKET = 'ticket:own:replace';

    public const DELETE_OWN_TICKET = 'ticket:own:delete';

    // USERS

    public const CREATE_USER = 'user:create';

    public const UPDATE_USER = 'user:update';

    public const REPLACE_USER = 'user:replace';

    public const DELETE_USER = 'user:delete';

    /**
     * Get abilities for the given user.
     *
     * @return array
     */
    public static function getAbilities(User $user)
    {
        if ($user->is_manager) {
            return [
                self::CREATE_TICKET,
                self::UPDATE_TICKET,
                self::REPLACE_TICKET,
                self::DELETE_TICKET,
                self::CREATE_USER,
                self::UPDATE_USER,
                self::REPLACE_USER,
                self::DELETE_USER,
            ];
        }

        return [
            self::CREATE_OWN_TICKET,
            self::UPDATE_OWN_TICKET,
            self::DELETE_OWN_TICKET,
        ];
    }
}
