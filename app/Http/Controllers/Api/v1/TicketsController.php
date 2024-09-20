<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Filters\v1\TicketFilter;
use App\Http\Requests\Api\v1\Ticket\ReplaceTicketRequest;
use App\Http\Requests\Api\v1\Ticket\StoreTicketRequest;
use App\Http\Requests\Api\v1\Ticket\UpdateTicketRequest;
use App\Http\Resources\v1\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TicketsController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(TicketFilter $filters): AnonymousResourceCollection
    {
        return TicketResource::collection(Ticket::filter($filters)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request): TicketResource|JsonResponse
    {
        if ($this->authorize('store', Ticket::class)) {
            return new TicketResource(Ticket::create($request->mappedAttributes()));
        }

        return $this->error('This action is unauthorized.', 403);
    }

    /**
     * Display the specified resource.
     */
    public function show($ticket): TicketResource|JsonResponse
    {
        if ($this->include('author')) {
            return new TicketResource($ticket->load('author'));
        }

        return TicketResource::make($ticket);
    }

    public function update(UpdateTicketRequest $request, $ticketId)
    {
        // PATCH
        $ticket = Ticket::findOrFail($ticketId);

        if ($this->authorize('update', $ticket)) {
            $ticket->update($request->mappedAttributes());
        }

        return new TicketResource($ticket);
    }

    public function replace(ReplaceTicketRequest $request, $ticket)
    {
        // PUT
        $this->authorize('replace', $ticket);
        $ticket->update($request->mappedAttributes());

        return new TicketResource($ticket);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($ticket): JsonResponse
    {
        if ($this->authorize('delete', $ticket)) {
            $ticket->delete();

            return $this->ok('Ticket deleted successfully', [
                'message' => 'The ticket was deleted successfully.',
            ]);
        }

        return $this->error('This action is unauthorized.', 403);
    }
}
