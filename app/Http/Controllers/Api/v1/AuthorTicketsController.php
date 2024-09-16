<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Filters\v1\TicketFilter;
use App\Http\Requests\Api\v1\Ticket\ReplaceTicketRequest;
use App\Http\Requests\Api\v1\Ticket\StoreTicketRequest;
use App\Http\Resources\v1\TicketResource;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class AuthorTicketsController extends ApiController
{
    public function index($authorId, TicketFilter $filters)
    {
        return TicketResource::collection(
            Ticket::where('user_id', $authorId)
                ->filter($filters)
                ->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($authorId, StoreTicketRequest $request)
    {
        return new TicketResource(
            Ticket::create($request->mappedAttributes())
        );
    }

    /**
     * Display the specified resource.
     */
    public function destroy($authorId, $ticketId): JsonResponse
    {
        try {
            $ticket = Ticket::where('user_id', $authorId)->findOrFail($ticketId);
        } catch (ModelNotFoundException $e) {
            return $this->error('Ticket not found', 404);
        }
        $ticket->delete();

        return $this->ok('Ticket successfully deleted', [
            'message' => 'Ticket successfully deleted',
        ]);
    }

    public function replace(ReplaceTicketRequest $request, $authorId, $ticketId)
    {
        // PUT
        try {
            $ticket = Ticket::where('user_id', $authorId)->findOrFail($ticketId);
            $ticket->update($request->mappedAttributes());
        } catch (ModelNotFoundException $e) {
            return $this->error('Ticket not found', 404);
        }

        return new TicketResource($ticket);
    }
}
