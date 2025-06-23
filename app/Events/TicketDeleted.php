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
    public string $tenantDomain;
    /**
     * Create a new event instance.
     */
    public function __construct(
        public array $ticket,
        public int $tenantId,
    ) {
        $this->tenantDomain = tenant()->domains->first()?->domain ?? '';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $channels = [];

        $channels[] = new PrivateChannel("tenant-{$this->tenantId}.user-{$this->ticket['created_by']['id']}");

        if ($this->ticket['created_by']) {
            $channels[] = new PrivateChannel("tenant-{$this->tenantId}.user-{$this->ticket['accepted_by']['id']}");
        }

        $excludedIds = [$this->ticket['created_by']['id'], $this->ticket['accepted_by']['id']];

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
        return 'broadcasts';
    }
    public function broadcastAs(): string
    {
        return 'ticket.deleted';
    }
}
