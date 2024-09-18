<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use App\Permissions\Abilities;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function delete(User $user, Ticket $ticket)
    {
        if ($user->tokenCan(Abilities::DELETE_TICKET)) {
            return true;
        }

        if ($user->tokenCan(Abilities::DELETE_OWN_TICKET)) {
            return $user->id === $ticket->user_id;
        }

        return false;
    }

    public function update(User $user, Ticket $ticket)
    {
        if ($user->tokenCan(Abilities::UPDATE_TICKET)) {
            return true;
        }

        if ($user->tokenCan(Abilities::UPDATE_OWN_TICKET)) {
            return $user->id === $ticket->user_id;
        }

        return false;
    }

    public function replace(User $user)
    {
        return $user->tokenCan(Abilities::REPLACE_TICKET);
    }

    public function store(User $user)
    {
        return $user->tokenCan(Abilities::CREATE_TICKET) || $user->tokenCan(Abilities::CREATE_OWN_TICKET);
    }
}
