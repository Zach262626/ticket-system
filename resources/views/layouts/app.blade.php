<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>

<body>
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
                            @hasanyrole('admin|developer')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('users-roles') }}">Assign Roles</a>
                            </li>
                            @endhasanyrole
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
                                <a class="nav-link" href="{{ route('home') }}">Name: {{ Auth::user()->name  }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">Role:
                                    {{ Auth::user()->getRoleNames()->first()  }}</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
    @else
        <nav class="navbar navbar-expand-lg bg-body-tertiary px-3 py-2">
            <div class="container-fluid">
                @hasanyrole('admin|developer')
                <a class="navbar-brand" href="{{ route('index') }}">Support Ticket System</a>
                @else
                <a class="navbar-brand" href="{{ route('unauthorized') }}">Support Ticket System</a>
                @endhasanyrole
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        @auth
                            @hasanyrole('admin|developer')
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="{{ route('index') }}">Homes</a>
                                </li>   
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('users-roles') }}">Assign Roles</a>
                                </li> 
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="{{ route('unauthorized') }}">Home</a>
                                </li>
                            @endhasanyrole
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
                                <a class="nav-link" href="{{ route('home') }}">Name: {{ Auth::user()->name  }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">Role:
                                    {{ Auth::user()->getRoleNames()->first()  }}</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
    @endif
    @yield('content')
</body>

</html>