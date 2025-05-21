@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 p-5">
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3 bg-light p-3 rounded">
                        <h1>Register</h1>
                        <label for="exampleInputName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="exampleInputName" aria-describedby="nameHelp">
                        <div id="nameHelp" class="form-text">We'll never share your name with anyone else.</div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1">
                        </div>
                        {{-- <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div> --}}
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
                </form>
            </div>

        </div>
@endsection