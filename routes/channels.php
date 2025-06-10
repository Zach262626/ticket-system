<?php

use App\Models\Ticket\Ticket;
use Illuminate\Broadcasting\BroadcastController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Stancl\Tenancy\Middleware\ScopeSessions;






Broadcast::channel('tenant-{tenantId}.ticket-{ticketId}', function ($user, $tenantId, $ticketId) {
    // Check if user belongs to the tenant and is related to the ticket via the pivot table
    return ($tenantId == tenant()->id) && Ticket::where('id', $ticketId)
        ->where(function ($query) use ($user) {
            $query->where('created_by', $user->id)
                ->orWhere('accepted_by', $user->id);
        })->exists();
});

Broadcast::channel('tenant-{tenantId}.user-{userId}', function ($user, $tenantId, $userId) {
    return tenant()->id == (int) $tenantId && $user->id == (int) $userId;
});
Broadcast::channel('tenant-{tenantId}', function ($user, $tenantId) {
    if (tenant()->id !== (int) $tenantId) {
        return false;
    }
    return $user->can('view all tickets');
});

Broadcast::channel('channel-name', function ($user) {
    // Print the authenticated user
    logger($user); // Logs to storage/logs/laravel.log

    // Or use dd($user); to dump and die (for debugging only)
    // dd($user);

    return true; // or your own logic
});
