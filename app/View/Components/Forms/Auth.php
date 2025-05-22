<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Auth extends Component
{
    public string $route;
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $type,
        public bool $login = false,
    ) {
        if ($this->type == 'Tenant') {
            if ($this->login) {
                $this->route = 'tenant-login';
            } else {
                $this->route = 'tenant-register';
            }
        } else {
            if ($this->login) {
                $this->route = 'user-login';
            } else {
                $this->route = 'user-register';
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.auth');
    }
}
