<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Filters\v1\TicketFilter;
use App\Http\Resources\v1\TicketResource;
use App\Models\Ticket;

class AuthorTicketsController extends Controller
{
    public function index($authorId, TicketFilter $filters)
    {
        return TicketResource::collection(
            Ticket::where('user_id', $authorId)
                ->filter($filters)
                ->paginate()
        );
    }
}
