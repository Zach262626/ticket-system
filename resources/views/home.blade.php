@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Welcome to the Home Page</h1>
                @if (isset($tenant_id))
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
                @else
                    @foreach ($domains as $domain)
                        <a href="{{ route('home', ['domain' => $domain['domain']]) }}"
                            class="btn btn-primary">{{ $domain['domain'] }}</a>
                    @endforeach
                @endif
            </div>

        </div>
@endsection