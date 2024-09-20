<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Filters\v1\TicketFilter;
use App\Http\Requests\Api\v1\Ticket\ReplaceTicketRequest;
use App\Http\Requests\Api\v1\Ticket\StoreTicketRequest;
use App\Http\Resources\v1\TicketResource;
use App\Models\Ticket;
use Illuminate\Auth\Access\AuthorizationException;
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
    public function store(StoreTicketRequest $request, $authorId)
    {
        try {
            $this->authorize('store', Ticket::class);

            return new TicketResource(Ticket::create($request->mappedAttributes([
                'author_id' => 'user_id',
            ])));
        } catch (AuthorizationException $e) {
            return $this->error('This action is unauthorized.', 403);
        }

        return new TicketResource(Ticket::create($request->mappedAttributes()));
    }

    /**
     * Display the specified resource.
     */
    public function destroy($authorId, $ticketId): JsonResponse
    {
        $ticket = Ticket::where('id', $ticketId)
            ->where('user_id', $authorId)
            ->firstOrFail();
        $this->authorize('delete', $ticket);
        $ticket->delete();

        return $this->ok('Ticket successfully deleted', [
            'message' => 'Ticket successfully deleted',
        ]);
    }

    public function replace(ReplaceTicketRequest $request, $authorId, $ticketId)
    {
        // PUT
        $ticket = Ticket::where('id', $ticketId)
            ->where('user_id', $authorId)
            ->firstOrFail();

        $this->authorize('update', $ticket);
        $ticket->update($request->mappedAttributes());

        return new TicketResource($ticket);
    }

    public function update(ReplaceTicketRequest $request, $authorId, $ticketId)
    {
        // PUT
        $ticket = Ticket::where('id', $ticketId)
            ->where('user_id', $authorId)
            ->firstOrFail();

        $this->authorize('update', $ticket);
        $ticket->update($request->mappedAttributes());

        return new TicketResource($ticket);
    }
}
