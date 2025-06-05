<?php

use Illuminate\Support\Facades\Broadcast;

// Broadcast::routes(['middleware' => ['auth']]);
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('tenant-{tenantId}.ticket-{ticketId}', function ($user, $tenantId, $ticketId) {
    // return $user->tenant_id === (int) $tenantId && $user->canAccessTicket($ticketId);
    return true;
});
Broadcast::channel('channel-name', function ($user) {
    return true; // or your own logic
});