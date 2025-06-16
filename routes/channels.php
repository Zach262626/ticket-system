<?php

use App\Models\Ticket\Ticket;
use Illuminate\Broadcasting\BroadcastController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Stancl\Tenancy\Middleware\ScopeSessions;






Broadcast::channel('tenant-{tenantId}.user-{userId}', function ($user, $tenantId, $userId) {
    return tenant()->id == (int) $tenantId && $user->id === (int) $userId;
});

Broadcast::channel('tenant-{tenantId}.user-{userId}', function ($user, $tenantId, $userId) {
    return Auth::check()
        && tenant()->id == (int) $tenantId
        && $user->id === (int) $userId;
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
