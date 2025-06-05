<?php

namespace App\Broadcasting;

use Illuminate\Broadcasting\PrivateChannel;

class TenantChannel extends PrivateChannel
{
    public function __construct($name)
    {
        $tenantId = tenant()->getTenantKey(); // Adjust this based on your tenant identification method
        parent::__construct("tenant-{$tenantId}:{$name}");
    }
}