<?php
// App\Events\TicketUpdated.php
namespace App\Events;

use App\Models\Ticket\Ticket;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Bus\Batchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class TicketUpdated implements ShouldBroadcast
{
    use Batchable, Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Ticket $ticket,
        public int    $tenantId,
        public array  $changes = [],
    ) {
        $this->ticket
            ->refresh()
            ->loadMissing([
                'createdBy',
                'acceptedBy',
                'status',
                'type',
                'level',
            ]);
    }

    public function broadcastWith(): array
    {
        return [
            'ticket'  => $this->ticket->toArray(),
            'changes' => $this->changes,
        ];
    }

    public function broadcastOn(): array
    {
        return [new PrivateChannel("tenant-{$this->tenantId}")];
    }

    public function broadcastQueue(): string
    {
        return 'broadcast';
    }

    public function broadcastAs(): string
    {
        return 'ticket.updated';
    }
}
