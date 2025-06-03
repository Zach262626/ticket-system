<?php

namespace App\Http\Controllers;

use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketMessage;
use App\Models\Ticket\TicketStatus;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Stancl\Tenancy\Middleware\ScopeSessions;

class MessageController extends Controller implements HasMiddleware
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
            new Middleware('permission:edit tickets', only: ['show', 'edit', 'update', 'delete']),
        ];
    }
    /**mig
     * Store a newly created message in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => 'required|string|max:1000',
            'ticket_id'    => 'required|exists:tickets,id',
            'sender_id'     => 'required|exists:users,id',
        ]);
        $ticket = Ticket::where('id', $data['ticket_id'])->first();
        if (($ticket->status)->name != 'in_progress') {
            return redirect()->back()->with('error', 'Ticket is not in progress');
        }
        $ticket = TicketMessage::create($data);
        $ticket->save();

        return redirect()
            ->back();
    }

    /**
     * Display the specified message.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        $message = TicketMessage::find($id);
        return $message;
    }

    /**
     * Show the form for editing the specified message.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        $message = TicketMessage::find($id);
        return $message;
    }

    /**
     * Update the specified message in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified message from storage.
     *
     * @param  int  $id
     */
    public function delete($id)
    {
        $ticketMessage = TicketMessage::find($id);
        $ticketMessage->delete();
        return redirect()->back()->with('success', 'Message deleted');
    }
}
