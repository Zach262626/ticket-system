<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Navbar extends Component
{
    public $tenantId;
    public $userId;

    public function __construct($tenantId = null, $userId = null)
    {
        $this->tenantId = $tenantId;
        $this->userId = $userId;
    }

    public function render()
    {
        return view('components.navbar');
    }
}
