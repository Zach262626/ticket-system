<?php

namespace App\Http\Controllers;

use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketLevel;
use App\Models\Ticket\TicketStatus;
use App\Models\Ticket\TicketType;
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
        if ((Auth::user())->hasPermissionTo('view all tickets')) {
            $tickets = Ticket::with(['status', 'level', 'type', 'createdBy', 'acceptedBy'])
                ->paginate(15);
        } else {
            $tickets = Ticket::where('created_by', Auth::user()->id)
                ->with(['status', 'level', 'type', 'createdBy', 'acceptedBy'])
                ->paginate(15);
        }

        return view('ticket.index')->with([
            'tickets' => $tickets
        ]);
    }

    /**
     * Show form to create a new ticket.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $levels = TicketLevel::all();
        $types = TicketType::all();
        return view('ticket.create')->with(
            [
                'levels' => $levels,
                'types' => $types,
            ]
        );
    }

    /**
     * store a new ticket.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\redirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'description'   => 'required|string|max:1000',
            'level_id'      => 'exists:ticket_levels,id',
            'type_id'       => 'exists:ticket_types,id',
        ]);

        $data['created_by'] = Auth::id();
        $data['status_id'] = TicketStatus::where('name', 'Open')->get()->first()->id;

        $ticket = Ticket::create($data);

        return redirect()
            ->route('ticket-index', $ticket)
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
        if (!($ticket->createdBy->id == Auth::id()) && !(Auth::user())->hasPermissionTo('view all tickets')) {
            return redirect()->route('ticket-index');
        }
        $ticket->load(['status', 'level', 'type', 'createdBy', 'acceptedBy', 'attachments']);

        return view('ticket.show')->with(['ticket' => $ticket]);
    }

    /**
     * Show form to edit an existing ticket.
     *
     * @param  \App\Models\Ticket\Ticket  $ticket
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Ticket $ticket)
    {
        return view('ticket.edit');
    }

    /**
     * update the specified ticket.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket\Ticket  $ticket
     * @return \Illuminate\Http\redirectResponse
     */
    public function update(Request $request, Ticket $ticket)
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
     * Delete the specified ticket.
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
