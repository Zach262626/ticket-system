<?php

namespace App\Listeners;

use \App\Models\Ticket\Ticket;
use App\Events\TicketStatusChange;
use App\Mail\TicketStatusChangeMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Stancl\Tenancy\Facades\Tenancy;

class SendTicketStatusChangeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;
    public $queue = 'emails';
    public $tries = 3;

    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(TicketStatusChange $event): void
    {
        Tenancy::initialize($event->tenantId);
        $ticket = Ticket::with('createdBy')->findOrFail($event->ticketId);
        $user = $ticket->createdBy;
        if ($user && $user->email) {
            Mail::to($ticket->createdBy->email)
                ->queue(new TicketStatusChangeMail($ticket, $event->tenantDomain));
        }
        Tenancy::end();
    }
}
