@extends('layouts.app')
@section('content')

    <div class="container py-5">
        <div class="row  justify-content-center ">
            <div class="col-md-6">
                <div class=" bg-dark px-3 py-2 rounded-top-2 text-light">
                    <h1 class="col bg-dark">Register User</h1>
                </div>

            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="{{ route('user-register') }}" method="POST">
                    @csrf
                    <div class="mb-3 bg-light p-3 rounded">
                        <div class="mb-3">
                            <label for="InputName" class="form-label">Name</label>
                            <input name='name' type="text" class="form-control" id="InputName" aria-describedby="nameHelp"
                                value="{{ old(key: 'name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="InputEmail1" class="form-label">Email address</label>
                            <input name="email" type="email" class="form-control" id="InputEmail1"
                                aria-describedby="emailHelp" value="{{ old(key: 'email') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="InputPassword1" class="form-label">Password</label>
                            <input name="password" type="password" class="form-control" id="InputPassword1" required>
                        </div>
                        <div class="mb-3">
                            <label for="InputComfirmPassword1" class="form-label">Password Comfirmation</label>
                            <input name="password_confirmation" type="password" class="form-control"
                                id="InputComfirmPassword1" required>
                        </div>
                        {{-- <div class="mb-3 form-check">
                            <input name="remember" type="checkbox" class="form-check-input" id="rememberCheck1"
                                value="{{ true }}">
                            <label class="form-check-label" for="rememberCheck1">Remember Me</label>
                        </div> --}}
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('user-login') }}" class="btn btn-secondary">Login</a>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </form>
            </div>


        </div>
    </div>
@endsection