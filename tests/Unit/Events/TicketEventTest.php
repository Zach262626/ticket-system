<?php

use App\Events\TicketCreated;
use App\Events\TicketStatusChange;
use App\Events\TicketUpdated;
use App\Events\TicketDeleted;
use App\Events\TicketMessageSent;
use App\Models\Ticket\TicketMessage;
use App\Models\Ticket\Ticket;
use Illuminate\Broadcasting\PrivateChannel;

it('ticket created event has correct broadcast name and queue', function () {
    $event = new TicketCreated(1, 1);
    expect($event->broadcastAs())->toBe('ticket.created')
        ->and($event->broadcastQueue())->toBe('broadcasts');
});

it('ticket status change event has correct broadcast name and queue', function () {
    $event = new TicketStatusChange(1, 1, []);
    expect($event->broadcastAs())->toBe('ticket.status.change')
        ->and($event->broadcastQueue())->toBe('broadcasts');
});

it('ticket updated event has correct broadcast name and queue', function () {
    $event = new TicketUpdated(1, 1, []);
    expect($event->broadcastAs())->toBe('ticket.updated')
        ->and($event->broadcastQueue())->toBe('broadcasts');
});

it('ticket deleted event has correct broadcast name and queue', function () {
    $data = ['id' => 1, 'created_by' => ['id' => 1], 'accepted_by' => ['id' => 2]];
    $event = new TicketDeleted($data, 1);
    expect($event->broadcastAs())->toBe('ticket.deleted')
        ->and($event->broadcastQueue())->toBe('broadcasts');
});

it('ticket message sent event channels exclude sender', function () {
    $ticket = new Ticket();
    $ticket->created_by = 1;
    $ticket->accepted_by = 2;
    $message = new TicketMessage(['sender_id' => 1]);
    $message->setRelation('ticket', $ticket);

    $event = new TicketMessageSent($message, 5);
    $channels = $event->broadcastOn();

    expect($channels)->toHaveCount(1)
        ->and($channels[0])->toBeInstanceOf(PrivateChannel::class)
        ->and($channels[0]->name)->toBe('tenant-5.user-2');
});

