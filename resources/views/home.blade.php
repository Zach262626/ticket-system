@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Welcome to the Home Page</h1>
                @if (isset($tenant_id))
                    <a href="{{ route('user-login') }}" class="btn btn-primary">Login</a>
                    <a href="{{ route('user-register') }}" class="btn btn-secondary">Register</a>
                @else
                    <a href="{{ route('tenant-register') }}" class="btn btn-secondary">Register New Tenant</a>
                    <a href="{{ route('tenant-login') }}" class="btn btn-primary">Login</a>

                @endif
            </div>

        </div>
@endsection