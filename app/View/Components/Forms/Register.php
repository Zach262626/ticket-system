<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Register extends Component
{
    public string $route, $routeBack;
    /**
     * Create a new component instance.
     */
    public function __construct(public string $type)
    {
        if ($this->type == 'Tenant') {
            $this->route = 'tenant-register';
            $this->routeBack = 'tenant-login';
        } else {
            $this->route = 'user-register';
            $this->routeBack = 'user-login';
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.register');
    }
}
