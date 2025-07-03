<?php

use App\Models\Ticket\TicketMessage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
it('belongs to a ticket', function () {
    $message = new TicketMessage();
    expect($message->ticket())->toBeInstanceOf(BelongsTo::class);
});

it('belongs to a sender', function () {
    $message = new TicketMessage();
    expect($message->sender())->toBeInstanceOf(BelongsTo::class);
});

