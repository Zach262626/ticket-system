@extends('layouts.app')
@section('content')
    <div class="container  py-5">
        <div class="row  justify-content-center ">
            <div class="col-md-6">
                <div class=" bg-dark px-3 py-2 rounded-top-2 text-light">
                    <h1 class="col bg-dark">Create a Ticket</h1>
                </div>

            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="{{ route('ticket-store') }}" method="POST">
                    @csrf
                    <div class="mb-3 bg-light p-3 rounded-bottom-2 ">
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text">Description</span>
                                <textarea name="description" class="form-control" aria-label="With textarea"
                                    value="{{ old(key: 'description') }}"></textarea>
                            </div>
                        </div>
                        <div class=" mb-3">
                            <select class="form-select" aria-label="Select User" name="level_id">
                                <option selected>Select Level</option>
                                @foreach ($levels as $level)
                                    <option value="{{ $level->id }}">{{ $level->name }}</option>

                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <select class="form-select" aria-label="Select User Role" name="type_id">
                                <option selected>Select Type</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('ticket-index') }}" class="btn btn btn-light">Back</a>

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