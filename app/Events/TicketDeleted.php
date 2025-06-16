<?php

namespace App\Events;

use App\Models\Ticket\Ticket;
use App\Models\User;
use GuzzleHttp\Psr7\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketDeleted implements ShouldBroadcast
{
    use Batchable, Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public int $ticketId,
        public int $tenantId,
        public int $createdBy,
        public ?int $acceptedBy
    ) {}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $channels = [];

        $channels[] = new PrivateChannel("tenant-{$this->tenantId}.user-{$this->createdBy}");

        if ($this->acceptedBy) {
            $channels[] = new PrivateChannel("tenant-{$this->tenantId}.user-{$this->acceptedBy}");
        }

        $excludedIds = [$this->createdBy, $this->acceptedBy];

        $editors = User::permission('view all tickets')
            ->whereNotIn('id', array_filter($excludedIds))
            ->pluck('id');

        foreach ($editors as $userId) {
            $channels[] = new PrivateChannel("tenant-{$this->tenantId}.user-{$userId}");
        }

        return $channels;
    }

    /**
     * The name of the queue on which to place the broadcasting job.
     */
    public function broadcastQueue(): string
    {
        return 'broadcast';
    }
    public function broadcastAs(): string
    {
        return 'ticket.deleted';
    }
}
