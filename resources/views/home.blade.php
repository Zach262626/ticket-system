@extends('layouts.app')
@section('content')

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>Welcome to the Home Page of {{ $tenant_name }}</h1>
                @auth
                    <a href="{{ route('user-logout') }}" class="btn btn-primary">Logout</a>
                    <a href="{{ route('ticket-index') }}" class="btn btn-primary">Ticket</a>
                @else
                    <a href="{{ route('user-login') }}" class="btn btn-primary">Login</a>
                    <a href="{{ route('user-register') }}" class="btn btn-secondary">Register</a>
                @endauth
                <a href="{{ route('tenant-logout') }}" class="btn btn-secondary">Tenant Logout</a>
            </div>
        </div>
    </div>
@endsection