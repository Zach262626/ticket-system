@extends('layouts.app')
@section('content')

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>Welcome to the Home Page</h1>
                <a href="{{ route('tenant-register') }}" class="btn btn-primary">Register New Tenant</a>
            </div>
            @if (isset($tenants))
                <div class="col-md-12 text-center mt-3">
                    <h2>Available Tenants</h2>
                    <ul class="list-group">
                        <form method="post" action="{{ route('tenant-login') }}" class="mb-3">
                            @csrf
                            @foreach ($tenants as $tenant)
                                <button class="list-group-item list-group-item-action" type="submit" name="tenant_id" value={{  $tenant->id }}>{{ $tenant->name }}</button>

                            @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </div>
@endsection