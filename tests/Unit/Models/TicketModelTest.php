<?php

use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketAttachment;
use App\Models\Ticket\TicketLevel;
use App\Models\Ticket\TicketStatus;
use App\Models\Ticket\TicketType;
use App\Models\Ticket\TicketMessage;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stancl\Tenancy\Facades\Tenancy;
use App\Models\Tenant;

beforeEach(function () {
    $this->tenant    = Tenant::create(
        [
            'id' => fake()->unique()->randomNumber(),
            'name'                => 'Test Company',
            'tenancy_db_username' => 'testDomain' . fake()->unique()->randomNumber(),
            'tenancy_db_password' => '12345678',
        ]
    );
    $this->domain = $this->tenant->domains()->create([
        'domain' => 'testDomain.localhost',
    ]);
    Tenancy::initialize(tenant: $this->tenant);
});
afterEach(function () {
    Tenancy::end();

    if ($this->tenant) {
        $this->tenant->delete();
    }
});
it('has a status relation', function () {
    $ticket = new Ticket();
    expect($ticket->status())->toBeInstanceOf(BelongsTo::class);
});

it('has a level relation', function () {
    $ticket = new Ticket();
    expect($ticket->level())->toBeInstanceOf(BelongsTo::class);
});

it('has a type relation', function () {
    $ticket = new Ticket();
    expect($ticket->type())->toBeInstanceOf(BelongsTo::class);
});

it('has attachments relation', function () {
    $ticket = new Ticket();
    expect($ticket->attachments())->toBeInstanceOf(HasMany::class);
});

it('has createdBy relation', function () {
    $ticket = new Ticket();
    expect($ticket->createdBy())->toBeInstanceOf(BelongsTo::class);
});

it('has acceptedBy relation', function () {
    $ticket = new Ticket();
    expect($ticket->acceptedBy())->toBeInstanceOf(BelongsTo::class);
});

it('has messages relation', function () {
    $ticket = new Ticket();
    expect($ticket->messages())->toBeInstanceOf(HasMany::class);
});
