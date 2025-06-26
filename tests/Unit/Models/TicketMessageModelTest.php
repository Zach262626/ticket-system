<?php

use App\Models\Ticket\TicketMessage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

it('belongs to a ticket', function () {
    $message = new TicketMessage();
    expect($message->ticket())->toBeInstanceOf(BelongsTo::class);
});

it('belongs to a sender', function () {
    $message = new TicketMessage();
    expect($message->sender())->toBeInstanceOf(BelongsTo::class);
});

