<?php

namespace App\Events;

use App\Models\Ticket\Ticket;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketStatusChange implements ShouldBroadcast
{
    use Batchable, Dispatchable, InteractsWithSockets, SerializesModels;
    public string $tenantDomain;
    /**
     * @var Ticket|null
     */
    protected ?Ticket $ticket = null;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public int    $ticketId,
        public int    $tenantId,
        public array  $changes = []
    ) {
        $this->tenantDomain = tenant()->domains->first()?->domain ?? '';
        $this->ticket = Ticket::with([
            'createdBy',
            'status',
            'type',
            'level',
            'acceptedBy'
        ])->find($this->ticketId);
    }

    public function broadcastWith(): array
    {
        return [
            'ticket'  => $this->ticket ? $this->ticket->toArray() : null,
            'changes' => $this->changes,
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $channels = [];

        try {
            if (!$this->ticket) {
                return $channels;
            }

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

    /**
     * The name of the queue on which to place the broadcasting job.
     */
    public function broadcastQueue(): string
    {
        return 'broadcasts';
    }

    public function broadcastAs(): string
    {
        return 'ticket.status.change';
    }
}
