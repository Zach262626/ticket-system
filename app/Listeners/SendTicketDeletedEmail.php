<?php

namespace App\Listeners;

use \App\Models\Ticket\Ticket;
use App\Events\TicketDeleted;
use App\Mail\TicketDeletedMail;
use App\Mail\TicketUpdatedMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Stancl\Tenancy\Facades\Tenancy;

class SendTicketDeletedEmail implements ShouldQueue
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
    public function handle(TicketDeleted $event): void
    {
        $ticket = $event->ticket;
        Tenancy::initialize($event->tenantId);;
        if ($ticket['created_by'] && $ticket['created_by']['email']) {
            Mail::to($ticket['created_by']['email'])
                ->queue(new TicketDeletedMail($ticket, $event->tenantDomain));
        }
        if ($ticket['accepted_by'] && $ticket['accepted_by']['email']) {
            Mail::to($ticket['accepted_by']['email'])
                ->queue(new TicketDeletedMail($ticket, $event->tenantDomain));
        }
        Tenancy::end();
    }
}
