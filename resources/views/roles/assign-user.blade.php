@extends('layouts.app')
@section('content')
    <div class="container py-5">
        <div class="row  justify-content-center ">
            <div class="col-md-6">
                <div class=" bg-dark px-3 py-2 rounded-top-2 text-light">
                    <h1 class="col bg-dark">Assign Role To User</h1>
                </div>

            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="{{ route('users-asign-roles') }}" method="POST">
                    @csrf
                    <div class="mb-3 bg-light p-3 rounded">
                        <div class="mb-3">
                            <select class="form-select" aria-label="Select User" name="user_id">
                                <option selected>Select User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>

                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <select class="form-select" aria-label="Select User Role" name="role_id">
                                <option selected>Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('home') }}" class="btn btn btn-light">Home</a>

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
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection