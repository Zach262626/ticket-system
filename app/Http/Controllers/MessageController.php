<?php

namespace App\Http\Controllers;

use App\Models\Ticket\TicketMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
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

        $ticket = TicketMessage::create($data);

        return redirect()
            ->back()
            ->with('success', 'message sent');
    }

    /**
     * Display the specified message.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        if (!Auth::user()->HasPermissionTo('view all tickets')) {
            return redirect()->back()->with('error', 'Cannot access this message');
        }

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
        if (!Auth::user()->HasPermissionTo('edit tickets')) {
            return redirect()->back()->with('error', 'Cannot edit this message');
        }

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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Auth::user()->HasPermissionTo('edit tickets')) {
            return redirect()->back()->with('error', 'Cannot delete this message');
        }
        $ticketMessage = TicketMessage::find($id);
        $ticketMessage->delete();
        return redirect()->back()->with('success', 'Message deleted');
    }
}
