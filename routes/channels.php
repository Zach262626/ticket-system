<?php

use App\Models\Ticket\Ticket;
use Illuminate\Broadcasting\BroadcastController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Stancl\Tenancy\Middleware\ScopeSessions;






Broadcast::channel('tenant-{tenantId}.ticket-{ticketId}', function ($user, $tenantId, $ticketId) {
    if (!Auth::check()) {
        return false;
    }
    // Check if user belongs to the tenant and is related to the ticket via the pivot table
    return ($tenantId == tenant()->id) && Ticket::where('id', $ticketId)
        ->where(function ($query) use ($user) {
            $query->where('created_by', $user->id)
                ->orWhere('accepted_by', $user->id);
        })->exists();
});

Broadcast::channel('tenant-{tenantId}.user-{userId}', function ($user, $tenantId, $userId) {
    if (!Auth::check()) {
        return false;
    }
    return tenant()->id == (int) $tenantId && $user->id == (int) $userId;
});

Broadcast::channel('tenant-{tenantId}', function ($user, $tenantId) {
    if (!Auth::check()) {
        return false;
    }
    return tenant()->id == (int) $tenantId;
});

Broadcast::channel('viewall.tenant-{tenantId}', function ($user, $tenantId) {
    if (!Auth::check()) {
        return false;
    }
    if (tenant()->id !== (int) $tenantId) {
        return false;
    }
    return $user->can('view all tickets');
});
