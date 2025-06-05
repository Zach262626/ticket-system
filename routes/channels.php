<?php

use Illuminate\Broadcasting\BroadcastController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Stancl\Tenancy\Middleware\ScopeSessions;







Broadcast::channel('tenant-{tenantId}.ticket-{ticketId}', function ($user, $tenantId, $ticketId) {
    // return $user->tenant_id === (int) $tenantId && $user->canAccessTicket($ticketId);
    return true;
});
Broadcast::channel('channel-name', function ($user) {
    // Print the authenticated user
    logger($user); // Logs to storage/logs/laravel.log

    // Or use dd($user); to dump and die (for debugging only)
    // dd($user);

    return true; // or your own logic
});