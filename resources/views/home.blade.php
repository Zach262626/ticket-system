@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Welcome to the Home Page</h1>
                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
            </div>

        </div>
@endsection