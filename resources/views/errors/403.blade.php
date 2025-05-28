@extends('layouts.app')
@section('content')
    <div class="position-fixed top-50 start-50 translate-middle">
        <div class="text-center">
            <h1 class="display-1 text-danger">403</h1>
            <p class="lead mb-4">Oops! User does not have the necessary access rights.</p>
            <a href="/" class="btn btn-primary btn-lg">Return Home</a>
        </div>
    </div>
@endsection