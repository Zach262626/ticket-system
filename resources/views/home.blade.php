@extends('layouts.app')
@section('content')

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12 text-center">

                @if (isset($tenant_id))
                    <h1>Welcome to the Home Page of {{ $tenant_id }}</h1>
                    <a href="{{ route('user-login') }}" class="btn btn-primary">Login</a>
                    <a href="{{ route('user-register') }}" class="btn btn-secondary">Register</a>
                @else
                    <h1>Welcome to the Home Page</h1>
                    <a href="{{ route('tenant-register') }}" class="btn btn-secondary">Register New Tenant</a>
                    <a href="{{ route('tenant-login') }}" class="btn btn-primary">Login</a>

                @endif
            </div>

        </div>
    </div>
@endsection