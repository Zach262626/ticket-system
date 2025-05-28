<?php

namespace App\Http\Controllers;

use App\Models\Ticket\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the tickets.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Eager load relationships to avoid N+1
        $tickets = Ticket::with(['status', 'level', 'type', 'createdBy', 'acceptedBy'])
            ->paginate(15);

        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new ticket.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // You might want to pass lists for status, level, type dropdowns
        return view('tickets.create');
    }

    /**
     * Store a newly created ticket in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'description'   => 'required|string|max:1000',
            'status_id'     => 'nullable|exists:ticket_statuses,id',
            'level_id'      => 'nullable|exists:ticket_levels,id',
            'type_id'       => 'nullable|exists:ticket_types,id',
            'accepted_by'   => 'nullable|exists:users,id',
        ]);

        // Attach the current user as creator
        $data['created_by'] = Auth::id();

        $ticket = Ticket::create($data);

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Ticket created successfully.');
    }

    /**
     * Display the specified ticket.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        $ticket->load(['status', 'level', 'type', 'createdBy', 'acceptedBy', 'attachments']);

        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified ticket.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        return view('tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified ticket in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'description'   => 'required|string|max:1000',
            'status_id'     => 'nullable|exists:ticket_statuses,id',
            'level_id'      => 'nullable|exists:ticket_levels,id',
            'type_id'       => 'nullable|exists:ticket_types,id',
            'accepted_by'   => 'nullable|exists:users,id',
        ]);

        $ticket->update($data);

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Ticket updated successfully.');
    }

    /**
     * Remove the specified ticket from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket deleted successfully.');
    }
}
