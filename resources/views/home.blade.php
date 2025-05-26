@extends('layouts.app')
@section('content')

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12 text-center">

                @if (isset($tenant_id))
                    <h1>Welcome to the Home Page of {{ $tenant_name }}</h1>
                    @auth
                        <a href="{{ route('user-logout') }}" class="btn btn-primary">Logout</a>
                    @else
                        <a href="{{ route('user-login') }}" class="btn btn-primary">Login</a>
                        <a href="{{ route('user-register') }}" class="btn btn-secondary">Register</a>
                    @endauth
                    <a href="{{ route('tenant-logout') }}" class="btn btn-secondary">Tenant Logout</a>

                @else
                    <h1>Welcome to the Home Page</h1>
                    <a href="{{ route('tenant-register') }}" class="btn btn-primary">Register New Tenant</a>
                @endif
            </div>
            @if (isset($tenants) && !isset($tenant_id))
                <div class="col-md-12 text-center mt-3">
                    <h2>Available Tenants</h2>
                    <ul class="list-group">
                        @foreach ($tenants as $tenant)
                            <a href="{{ route('tenant-login', ['tenant_id' => $tenant->id]) }}"
                                class="list-group-item list-group-item-action">
                                {{ $tenant->name }}
                            </a>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </div>
@endsection