<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Ticket System</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div id="app">
        @if(tenant('id') != null)
            <nav class="navbar navbar-expand-lg bg-body-tertiary px-3 py-2">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ route('home') }}">Support Ticket System</a>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            @auth
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('ticket-index') }}">Ticket</a>
                                </li>
                                @can('assign roles')
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('users-roles') }}">Assign Roles</a>
                                    </li>
                                @endcan
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user-logout') }}">Logout</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="{{ route('user-login') }}">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user-register') }}">Register</a>
                                </li>
                            @endauth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('tenant-logout') }}">Tenant Logout</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav ms-auto">
                            @auth
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('home') }}">Name: {{ Auth::user()->name }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('home') }}">Role:
                                        {{ Auth::user()->getRoleNames()->first() }}</a>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </nav>
        @else
            <nav class="navbar navbar-expand-lg bg-body-tertiary px-3 py-2">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ route('home') }}">Support Ticket System</a>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            @auth
                                @can('assign roles')
                                    <li class="nav-item">
                                        <a class="nav-link" aria-current="page" href="{{ route('home') }}">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('users-roles') }}">Assign Roles</a>
                                    </li>
                                @endcan
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user-logout') }}">Logout</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="{{ route('user-login') }}">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user-register') }}">Register</a>
                                </li>
                            @endauth
                        </ul>
                        <ul class="navbar-nav ms-auto">
                            @auth
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('home') }}">Name: {{ Auth::user()->name }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('home') }}">Role:
                                        {{ Auth::user()->getRoleNames()->first() }}</a>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </nav>
        @endif
        @if(tenant('id') != null)
            @auth
                {{-- Alerts --}}
                @can('view all tickets')
                    <ticket-created-alert
                        :tenant-id="{{ tenant()->id }}" :user-id="{{ Auth::id() }}"></ticket-created-alert>
                @endcan
                <ticket-message-alert :tenant-id="{{ tenant()->id }}" :user-id="{{ Auth::id() }}"></ticket-message-alert>
                <alert-stack></alert-stack>
            @endauth
        @endif
        @yield('content')

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>