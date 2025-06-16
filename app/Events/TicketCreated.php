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

class TicketCreated implements ShouldBroadcast
{
    use Batchable, Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Ticket $ticket,
        public int $tenantId,
    ) {}
    public function broadcastWith(): array
    {
        return ['ticket' => $this->ticket->toArray()];
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
            $channels[] = new PrivateChannel("tenant-{$this->tenantId}.user-{$this->ticket->created_by}");

            if ($this->ticket->accepted_by) {
                $channels[] = new PrivateChannel("tenant-{$this->tenantId}.user-{$this->ticket->accepted_by}");
            }

            $excludedIds = [$this->ticket->created_by, $this->ticket->accepted_by];
            $editors = User::permission('edit tickets')
                ->whereNotIn('id', array_filter($excludedIds))
                ->pluck('id');

            foreach ($editors as $userId) {
                $channels[] = new PrivateChannel("tenant-{$this->tenantId}.user-{$userId}");
            }
        } catch (\Throwable $e) {
            \Log::error('TicketCreated broadcastOn failed', [
                'error' => $e->getMessage(),
                'ticket_id' => $this->ticket->id,
            ]);
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
        return 'ticket.created';
    }
}
