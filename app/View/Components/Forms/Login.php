<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Login extends Component
{
    public string $routeBack;
    /**
     * Create a new component instance.
     */
    public function __construct(public string $type)
    {
        if ($this->type == 'Tenant') {
            $this->routeBack = 'tenant-register';
        } else {
            $this->routeBack = 'user-register';
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.login');
    }
}
