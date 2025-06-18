<?php

namespace App\Listeners;

use App\Events\TicketCreated;
use App\Mail\TicketCreatedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stancl\Tenancy\Facades\Tenancy;

class SendTicketCreatedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;
    public $queue = 'emails';
    public $tries = 3;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        logger()->info('[SendTicketCreatedEmail] Constructor called');
    }

    /**
     * Handle the event.
     */
    public function handle(TicketCreated $event): void
    {

        logger()->info('[SendTicketCreatedEmail] handle() called with Ticket ID: ' . $event->ticket->id);
        try {
            Tenancy::initialize($event->tenantId);
            $ticket = $event->ticket->loadMissing('user');

            if ($ticket->user?->email) {
                Mail::to($ticket->user->email)->queue(new TicketCreatedMail($ticket));
                Log::info('Mail queued for Ticket #' . $ticket->id);
            } else {
                Log::warning('No user/email for Ticket #' . $ticket->id);
            }
        } catch (\Throwable $e) {
            Log::error('SendTicketCreatedEmail failed: ' . $e->getMessage(), [
                'ticket_id' => $event->ticket->id,
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }
}
