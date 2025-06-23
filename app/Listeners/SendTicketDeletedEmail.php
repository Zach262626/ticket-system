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
        Tenancy::initialize($event->tenantId);
        $createdBy = User::findOrFail($event->createdBy);
        $acceptedBy = User::find($event->acceptedBy);
        if ($createdBy && $createdBy->email) {
            Mail::to($createdBy->email)
                ->queue(new TicketDeletedMail($event->ticketId,  $createdBy, $acceptedBy, $event->tenantDomain));
        }
        if ($acceptedBy && $acceptedBy->email) {
            Mail::to($acceptedBy->email)
                ->queue(new TicketDeletedMail($event->ticketId,  $createdBy, $acceptedBy, $event->tenantDomain));
        }
        Tenancy::end();
    }
}
