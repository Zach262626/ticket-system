<?php

namespace App\View\Components\Ticket;

use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketMessage;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class Messages extends Component
{
    public array $ticketMessages = [];
    public Ticket $ticket;
    /**
     * Create a new component instance.
     */
    public function __construct(
        public int $ticketid,
        public int $senderid,
    ) {
        $this->ticket = Ticket::where("id", $ticketid)->first();
        $messages = $this->ticket->messages()->orderBy('created_at')->get();
        foreach ($messages as $message) {
            $message->load(['sender']);
            $this->ticketMessages[] = $message;
        }
        $this->ticketMessages= array_reverse($this->ticketMessages);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ticket.messages');
    }
}
