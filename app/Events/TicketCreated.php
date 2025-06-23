<?php

namespace App\Events;

use App\Models\Ticket\Ticket;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Bus\Batchable;
use Stancl\Tenancy\Facades\Tenancy;

class TicketCreated implements ShouldBroadcast
{
    use Batchable, Dispatchable, InteractsWithSockets, SerializesModels;
    public string $tenantDomain;
    public function __construct(
        public int $ticketId,
        public int $tenantId
    ) {
        $this->tenantDomain = tenant()->domains->first()?->domain ?? '';
        // $domain = tenant()->domains->first()?->domain ?? '';
        // $scheme = app()->environment('local') ? 'http' : 'https';
        // $port   = app()->environment('local') && str_ends_with($domain, '.localhost')
        //     ? ':' . env('APP_PORT', 8000)
        //     : '';

        // $this->tenantDomain = "{$scheme}://{$domain}{$port}";

    }

    public function broadcastWith(): array
    {
        Tenancy::initialize($this->tenantId);

        $ticket = Ticket::with(['status', 'level', 'type', 'createdBy', 'acceptedBy', 'attachments'])
            ->findOrFail($this->ticketId);

        $data = ['ticket' => $ticket->toArray()];

        Tenancy::end();

        return $data;
    }

    public function broadcastOn(): array
    {
        Tenancy::initialize($this->tenantId);

        $ticket = Ticket::findOrFail($this->ticketId);

        $channels = [];

        if ($ticket->created_by) {
            $channels[] = new PrivateChannel("tenant-{$this->tenantId}.user-{$ticket->created_by}");
        }

        if ($ticket->accepted_by) {
            $channels[] = new PrivateChannel("tenant-{$this->tenantId}.user-{$ticket->accepted_by}");
        }

        $excludedIds = array_filter([$ticket->created_by, $ticket->accepted_by]);
        $editors = User::permission('view all tickets')
            ->whereNotIn('id', $excludedIds)
            ->pluck('id');

        foreach ($editors as $userId) {
            $channels[] = new PrivateChannel("tenant-{$this->tenantId}.user-{$userId}");
        }

        Tenancy::end();

        return $channels;
    }

    public function broadcastQueue(): string
    {
        return 'broadcasts';
    }

    public function broadcastAs(): string
    {
        return 'ticket.created';
    }
}
