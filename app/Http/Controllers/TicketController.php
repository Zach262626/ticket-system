<?php

namespace App\Http\Controllers;

use App\Models\Ticket\Ticket;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Stancl\Tenancy\Middleware\ScopeSessions;

class TicketController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware([
                'web',
                InitializeTenancyByDomain::class,
                ScopeSessions::class,
                PreventAccessFromCentralDomains::class,
            ]),
            new Middleware('role:admin|developer|support', only: ['edit', 'showEdit']),
            new Middleware('role:admin|developer', only: ['delete']),
        ];
    }
    /**
     * Show the application home.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $tickets = Ticket::with(['status', 'level', 'type', 'createdBy', 'acceptedBy'])
            ->paginate(15);

        return view('ticket.index')->with([
            'tickets' => $tickets
        ]);
    }

    /**
     * Show the form for creating a new ticket.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showCreate()
    {
        // You might want to pass lists for status, level, type dropdowns
        return view('ticket.create');
    }

    /**
     * Create a newly created ticket in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\redirectResponse
     */
    public function create(Request $request)
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
            ->route('ticket.index', $ticket)
            ->with('success', 'Ticket created successfully.');
    }

    /**
     * Display the specified ticket.
     *
     * @param  \App\Models\Ticket\Ticket  $ticket
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Ticket $ticket)
    {
        $ticket->load(['status', 'level', 'type', 'createdBy', 'acceptedBy', 'attachments']);

        return view('ticket.show');
    }

    /**
     * Show the form for editing the specified ticket.
     *
     * @param  \App\Models\Ticket\Ticket  $ticket
     * @return \Illuminate\Contracts\View\View
     */
    public function showEdit(Ticket $ticket)
    {
        return view('ticket.edit');
    }

    /**
     * Edit the specified ticket in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket\Ticket  $ticket
     * @return \Illuminate\Http\redirectResponse
     */
    public function edit(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'description'   => 'required|string|max:1000',
            'status_id'     => 'nullable|exists:ticket_status,id',
            'level_id'      => 'nullable|exists:ticket_levels,id',
            'type_id'       => 'nullable|exists:ticket_types,id',
            'accepted_by'   => 'nullable|exists:users,id',
        ]);

        $ticket->update($data);

        return redirect()
            ->route('ticket.show', $ticket)
            ->with('success', 'Ticket updated successfully.');
    }

    /**
     * Remove the specified ticket from storage.
     *
     * @param  \App\Models\Ticket\Ticket  $ticket
     * @return \Illuminate\Http\redirectResponse
     */
    public function delete(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()
            ->route('ticket.index')
            ->with('success', 'Ticket deleted successfully.');
    }
}
