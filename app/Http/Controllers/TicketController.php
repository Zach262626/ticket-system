<?php

namespace App\Http\Controllers;

use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketLevel;
use App\Models\Ticket\TicketStatus;
use App\Models\Ticket\TicketType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Stancl\Tenancy\Middleware\ScopeSessions;
use \Symfony\Component\HttpKernel\Exception\HttpException;

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
            new Middleware('permission:edit tickets', only: ['edit', 'showEdit', 'close']),
            new Middleware('permission:delete tickets', only: ['delete']),
            new Middleware('permission:create tickets', only: ['create', 'store']),
            new Middleware('permission:assign tickets', only: ['assign']),
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
            'tickets' => $tickets,
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
        $types  = TicketType::all();
        return view('ticket.create')->with(
            [
                'levels' => $levels,
                'types'  => $types,
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
            'description' => 'required|string|max:1000',
            'level_id'    => 'exists:ticket_levels,id',
            'type_id'     => 'exists:ticket_types,id',
        ]);

        $data['created_by'] = Auth::id();
        $data['status_id']  = TicketStatus::where('name', 'Open')->get()->first()->id;

        $ticket = Ticket::create($data);

        return redirect()
            ->route('ticket-index', $ticket)
            ->with('success', 'Ticket created successfully.');
    }

    /**
     * Display the specified ticket.
     *
     * @param  \App\Models\Ticket\Ticket  $ticket
     */
    public function show(Ticket $ticket)
    {
        if (! ($ticket->createdBy->id == Auth::id()) && ! (Auth::user())->hasPermissionTo('view all tickets')) {
            return redirect()->route('ticket-index')->with('error', 'You are not authorized to view this ticket.');
        }
        $ticket->load(['status', 'level', 'type', 'createdBy', 'acceptedBy', 'attachments']);
        $messages = $ticket->messages()->orderBy('created_at')->get();
        $ticketMessages = [];
        foreach ($messages as $message) {
            $message->load(['sender']);
            $ticketMessages[] = $message;
        }
        $ticketMessages = array_reverse($ticketMessages);
        return view('ticket.show')->with([
            'ticket' => $ticket,
            'messages' => $ticketMessages
        ]);
    }

    /**
     * Show form to edit an existing ticket.
     *
     * @param  \App\Models\Ticket\Ticket  $ticket
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Ticket $ticket)
    {
        if (!(Auth::user())->hasPermissionTo('edit tickets')) {
            return redirect()->route('ticket-index')->with('error', 'You are not authorized to edit this ticket.');
        }
        $levels   = TicketLevel::all();
        $types    = TicketType::all();
        $statuses = TicketStatus::all();
        $users    = User::withoutRole('member')->get();
        $ticket->load(['status', 'level', 'type', 'createdBy', 'acceptedBy', 'attachments']);
        return view('ticket.edit')->with([
            'levels'   => $levels,
            'types'    => $types,
            'statuses' => $statuses,
            'ticket'   => $ticket,
            'users'    => $users,
        ]);
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
            'description' => 'required|string|max:1000',
            'status_id'   => 'exists:ticket_status,id',
            'level_id'    => 'exists:ticket_levels,id',
            'type_id'     => 'exists:ticket_types,id',
            'accepted_by' => 'nullable|exists:users,id',
        ]);
        if (isset($data['accepted_by']) && ! (Auth::user())->hasPermissionTo('assign tickets')) {
            return redirect()->route('ticket-index')->with('error', 'You are not authorized to assign ticket.');
        } elseif (! Auth::user()->hasPermissionTo('edit tickets')) {
            throw new HttpException(403, 'You are not authorized to edit ticket.');
        }

        $ticket->update($data);

        return redirect()
            ->back()
            ->with('success', 'Ticket updated successfully.');
    }

    /**
     * Delete the specified ticket.
     *
     * @return \Illuminate\Http\redirectResponse
     */
    public function delete(Ticket $ticket)
    {
        if ($ticket->status->name != "closed") {
            return response()->json([
                'success' => false,
                'message' => 'Close ticket before deleting.'
            ], 400);
        }

        $ticket->delete();

        return response()->json([
            'success' => true,
            'redirect' => route('ticket-index'),
            'message' => 'Ticket deleted successfully.'
        ]);
    }
    
    /**
     * Search for a specific ticket
     */
    public function search(Request $request)
    {
        $search = $request->input('search');

        $tickets = Ticket::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('id', $search)
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhereHas('status', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('level', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('type', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('acceptedBy', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('createdBy', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                });
            });

        if (!Auth::user()->hasPermissionTo('view all tickets')) {
            $tickets->where('created_by', Auth::id());
        }

        $tickets = $tickets
            ->with(['status', 'level', 'type', 'createdBy', 'acceptedBy'])
            ->paginate(15)
            ->withQueryString();

        return view('ticket.index')->with([
            'tickets' => $tickets,
        ]);
    }

    /**
     * assign user to a specific ticket
     */
    public function assign(Ticket $ticket)
    {
        $ticket->accepted_by = Auth::id();
        $ticket->status_id = TicketStatus::where('name', 'in_progress')->first()->id;
        $ticket->save();
        return redirect()->back()->with('success', 'Ticket #' . $ticket->id . " has been accepted by " . Auth::user()->name . "");
    }
    /**
     * Close a specific ticket
     */
    public function close(Ticket $ticket)
    {
        $ticket->status_id = TicketStatus::where('name', 'closed')->first()->id;
        $ticket->save();
        return redirect()->back()->with('success', 'Ticket #' . $ticket->id . " has been closed by " . Auth::user()->name . "");
    }
}
