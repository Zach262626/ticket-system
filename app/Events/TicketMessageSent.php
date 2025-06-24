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

class TicketMessageSent implements ShouldBroadcast
{
    use Batchable, Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public TicketMessage $message,
        public int $tenantId,
    ) {}
    public function broadcastWith()
    {
        return [
            'message' => $this->message->toArray()
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $ticket = $this->message->ticket;
        $senderId = $this->message->sender_id;
        $channels = [];
        if ($ticket->created_by && $ticket->created_by != $senderId) {
            $channels[] = new PrivateChannel("tenant-{$this->tenantId}.user-{$ticket->created_by}");
        }
        if ($ticket->accepted_by && $ticket->accepted_by != $senderId) {
            $channels[] = new PrivateChannel("tenant-{$this->tenantId}.user-{$ticket->accepted_by}");
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
        return 'ticket-message-sent';
    }
}
