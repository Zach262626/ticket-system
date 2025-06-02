<?php

namespace App\View\Components\Ticket;

use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketMessage;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class Messages extends Component
{
    public TicketMessage $ticketMessages;
    /**
     * Create a new component instance.
     */
    public function __construct(
        public int $ticketid,
        public int $senderid,
    ) {
        $this->ticketMessages = TicketMessage::find($ticketid);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ticket.messages');
    }
}
