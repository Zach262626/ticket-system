<?php
// App\Events\TicketUpdated.php
namespace App\Events;

use App\Models\Ticket\Ticket;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

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
        $channels = [];

        try {
            $channels[] = new PrivateChannel("tenant-{$this->tenantId}.user-{$this->ticket->created_by}");

            if ($this->ticket->accepted_by) {
                $channels[] = new PrivateChannel("tenant-{$this->tenantId}.user-{$this->ticket->accepted_by}");
            }

            $excludedIds = [$this->ticket->created_by, $this->ticket->accepted_by];
            $editors = User::permission('view all tickets')
                ->whereNotIn('id', array_filter($excludedIds))
                ->pluck('id');

            foreach ($editors as $userId) {
                $channels[] = new PrivateChannel("tenant-{$this->tenantId}.user-{$userId}");
            }
        } catch (\Throwable $e) {
            throw $e;
        }

        return $channels;
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
