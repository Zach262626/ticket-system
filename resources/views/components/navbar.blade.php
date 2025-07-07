@props(['tenantId', 'userId'])
<nav class="navbar navbar-expand-lg bg-body-tertiary px-3 py-2">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">{{ $tenantName }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                @auth
                    @if($tenantId)
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('ticket-index') }}">Ticket</a></li>
                        @can('assign roles')
                            <li class="nav-item"><a class="nav-link" href="{{ route('users-roles') }}">Assign Roles</a></li>
                        @endcan
                        <li class="nav-item"><a class="nav-link" href="{{ route('user-logout') }}">Logout</a></li>
                    @else
                        @can('assign roles')
                            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('users-roles') }}">Assign Roles</a></li>
                        @endcan
                        <li class="nav-item"><a class="nav-link" href="{{ route('user-logout') }}">Logout</a></li>
                    @endif
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('user-login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('user-register') }}">Register</a></li>
                @endauth

                <li class="nav-item"><a class="nav-link" href="{{ route('tenant-logout') }}">Tenant Logout</a></li>
            </ul>
            @auth
                <div class="d-flex align-items-center ms-auto">
                    <a href="{{ route('settings-index') }}" class="text-decoration-none text-dark">
                        <user-profile :user="{{ Auth::user() }}" :width="30" :show-name="true" :show-subname="false" />
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>