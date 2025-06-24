<?php

namespace App\View\Components;

use App\Models\Tenant;
use Illuminate\View\Component;

class Navbar extends Component
{
    public $tenantId;
    public $userId;
    public $tenantName;

    public function __construct($tenantId = null, $userId = null)
    {
        $this->tenantId = $tenantId;
        $this->userId = $userId;
        $this->tenantName = $tenantId
            ? Tenant::find($tenantId)?->name ?? 'Unknown Company'
            : null;
    }

    public function render()
    {
        return view('components.navbar');
    }
}
