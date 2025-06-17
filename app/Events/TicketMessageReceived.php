<?php

namespace App\Events;

use App\Models\Ticket\TicketMessage;
use GuzzleHttp\Psr7\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketMessageReceived implements ShouldBroadcast
{
    use Batchable, Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public TicketMessage $message,
        public int $tenantId,
        public int $userId, //receiver
    ) {}
    public function broadcastWith()
    {
        return [
            'message' => $this->message->toArray(),
            'ticket' => $this->message->ticket->toArray(),
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel(name: "tenant-{$this->tenantId}.user-{$this->userId}"),
        ];
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
        return 'broadcast-message-received';
    }
}
