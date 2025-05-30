@extends('layouts.app')
@section('content')
<div class="container  py-5">
    <div class="row  justify-content-center ">
        <div class="col-md-6">
            <div class=" bg-dark px-3 py-2 rounded-top-2 text-light">
                <h1 class="col bg-dark">Edit Ticket #{{ $ticket->id }}</h1>
            </div>

        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="mb-3 bg-light p-3 rounded-bottom-2 ">
                <form action="{{ route('ticket-update', ['ticket' => $ticket]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text">Description</span>
                            <textarea id="description" name="description" class="form-control"
                                aria-label="With textarea">{{ $ticket->description }}</textarea>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="level_id" class="form-label">Level</label>
                        <select id="level_id" class="form-select" aria-label="Select User" name="level_id">
                            @foreach($levels as $level)
                            @if($level == $ticket->level)
                            <option selected value="{{ $level->id }}">{{ $level->name }}</option>
                            @else
                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="type_id" class="form-label">Type</label>
                        <select id="type_id" class="form-select" aria-label="Select User Role" name="type_id">
                            @foreach($types as $type)
                            @if($type == $ticket->type)
                            <option selected value="{{ $type->id }}">{{ $type->name }}</option>
                            @else
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status_id" class="form-label">Status</label>
                        <select id="status_id" class="form-select" aria-label="Select User Role" name="status_id">
                            @foreach($statuses as $status)
                            @if($status == $ticket->status)
                            <option selected value="{{ $status->id }}">{{ $status->name }}</option>
                            @else
                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    @can('re-assign tickets')
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Accepted By</label>
                        <select id="user_id" class="form-select" aria-label="Select User Role" name="user_id">
                            @foreach($users as $user)
                            @if($ticket->accepted_by == null) {
                                <option selected>None</option>
                            }
                            @endif
                            @if($user == $ticket->accepted_by)
                            <option selected value="{{ $user->id }}">{{ $user->name }}</option>
                            @else
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    @endcan
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('ticket-index') }}" class="btn btn-light">Back</a>
                </form>
                <form action="{{ route('ticket-delete', ['ticket' => $ticket->id]) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this ticket?');">
                    @csrf
                    <button class="btn btn-danger" type="submit">Delete</button>
                </form>
            </div>
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
    </div>
</div>
</div>
@endsection