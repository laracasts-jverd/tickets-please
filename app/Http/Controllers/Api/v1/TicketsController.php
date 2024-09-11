<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\StoreTicketRequest;
use App\Http\Requests\Api\v1\UpdateTicketRequest;
use App\Http\Resources\v1\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TicketsController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $tickets = Ticket::paginate();

        if ($this->include('author')) {
            $tickets->load('user');
        }

        return TicketResource::collection($tickets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket): TicketResource
    {
        if ($this->include('author')) {
            $ticket->load('user');
        }

        return TicketResource::make($ticket);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
