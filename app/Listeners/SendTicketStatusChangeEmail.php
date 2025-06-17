<?php

namespace App\Listeners;

use App\Events\TicketStatusChange;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTicketStatusChangeEmail implements ShouldQueue
{
    public $queue = 'emails';

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TicketStatusChange $event): void
    {
        //
    }
}
