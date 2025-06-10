@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="bg-dark px-3 py-2 rounded-top-2 text-light">
                    <h1>Edit Ticket #{{ $ticket->id }}</h1>
                </div>
                <div class="bg-light p-3 rounded-bottom-2">
                    <form action="{{ route('ticket-update', ['ticket' => $ticket->id]) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name="description" class="form-control" rows="3"
                                required>{{ old('description', $ticket->description) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="level_id" class="form-label">Level</label>
                            <select id="level_id" name="level_id" class="form-select" required>
                                @foreach($levels as $level)
                                    <option value="{{ $level->id }}" {{ $level->id == $ticket->level_id ? 'selected' : '' }}>
                                        {{ $level->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="type_id" class="form-label">Type</label>
                            <select id="type_id" name="type_id" class="form-select" required>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}" {{ $type->id == $ticket->type_id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="status_id" class="form-label">Status</label>
                            <select id="status_id" name="status_id" class="form-select" required>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" {{ $status->id == $ticket->status_id ? 'selected' : '' }}>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @can('assign tickets')
                            <div class="mb-3">
                                <label for="accepted_by" class="form-label">Accepted By</label>
                                <select id="accepted_by" name="accepted_by" class="form-select">
                                    <option value="">None</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ $user->id == $ticket->accepted_by ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endcan

                        <div class="d-flex gap-2 mb-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('ticket-index') }}" class="btn btn-secondary">Home</a>
                            <a href="{{ route('ticket-show', ['ticket' => $ticket->id]) }}" class="btn btn-light">View</a>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                 data-bs-target="#confirmDeleteModal-{{ $ticket->id }}">
                                Delete
                            </button>
                            <ticket-delete-modal :ticket="{{ $ticket }}" csrf-token="{{ csrf_token() }}" />
                        </div>
                    </form>
                </div>

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show my-2" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show my-2" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection