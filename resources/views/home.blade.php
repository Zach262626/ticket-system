@extends('layouts.app')
@section('content')

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>Welcome to the Home Page of {{ $tenant_name }}</h1>
                @auth
                    <a href="{{ route('user-logout') }}" class="btn btn-primary">Logout</a>
                    <a href="{{ route('ticket-index') }}" class="btn btn-primary">Ticket</a>
                    @can('assign roles')
                        <a href="{{ route('users-roles') }}" class="btn btn-primary">Assign Roles</a>
                    @endcan
                @else
                    <a href="{{ route('user-login') }}" class="btn btn-primary">Login</a>
                    <a href="{{ route('user-register') }}" class="btn btn-secondary">Register</a>
                @endauth
                <a href="{{ route('tenant-logout') }}" class="btn btn-secondary">Tenant Logout</a>
            </div>
        </div>
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show my-2" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show my-2" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
@endsection