<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::routes([
    'middleware' => ['auth:sanctum'],
    'prefix' => 'api',
]);

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('broadcast-test', function () {
    return true;
});

Broadcast::channel('tenant-{tenantId}.chat.{chatId}', function ($user, $tenantId, $chatId) {
    return $user->tenant_id === (int) $tenantId && $user->canAccessChat($chatId);
});
