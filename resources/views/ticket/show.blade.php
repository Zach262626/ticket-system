@extends('layouts.app')

@section('content')
    <div class="container-fluid p-5">
        <div class="row">
            <div class="col">
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('ticket-index') }}" class="btn btn btn-primary mb-3 px-5">Home</a>
                    @can('edit tickets')
                        <a class="btn btn btn-secondary mb-3 px-5"
                            href="{{ route('ticket-edit', ['ticket' => $ticket->id]) }}">Edit</a>
                        @if($ticket->acceptedBy == null)
                            <span>
                                <form action="{{ route('ticket-assign', ['ticket' => $ticket->id]) }}" method="POST">
                                    @csrf
                                    <button class="btn btn btn-secondary mb-3 px-5" type="submit">Assign-Me</button>
                                </form>
                            </span>
                        @endif
                        @can('delete tickets')
                            <button type="button" class="btn btn btn-danger mb-3 px-5" data-bs-toggle="modal"
                                data-bs-target="#confirmDeleteModal">
                                Delete
                            </button>
                            <x-ticket.modal.delete :ticket=$ticket />
                        @endcan
                        <span>
                            <form action="{{ route('ticket-close', ['ticket' => $ticket->id]) }}" method="POST">
                                @csrf
                                <button class="btn btn btn-warning mb-3 px-5" type="submit">Close</button>
                            </form>
                        </span>
                    @endcan
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
                <h1>View Ticket</h1>
            </div>
        </div>
        <div class="row gy-4">
            <div class="col-md-3">
                <div class="bg-dark px-3 py-2 rounded-1 text-light">
                    Ticket #{{ $ticket->id }}
                </div>
                <div class="px-4 pt-3 pb-2 bg-light">
                    <div class="w-100">
                        <x-user-profile :subname="false" width="75" :user="$ticket->createdBy" />
                    </div>
                    <div class="w-100">
                        <div>
                            <strong>Description:</strong>
                        </div>
                        <p class="ms-2">
                            {{ $ticket->description }}
                        </p>
                    </div>
                    @if(isset($ticket->createdBy->phone_number))
                        <div class="w-100">
                            <div><strong>Phone Number:</strong></div>
                            <p class="ms-2">{{ $ticket->createdBy->phone_number }}</p>
                        </div>
                    @endif
                    <div class="w-100">
                        <div><strong>Status:</strong></div>
                        <p class="ms-2">{{ $ticket->status->name }}</p>
                    </div>
                    <div class="w-100">
                        <div><strong>Type:</strong></div>
                        <p class="ms-2">{{ $ticket->type->name }}</p>
                    </div>
                    <div class="w-100">
                        <div><strong>Level:</strong></div>
                        <p class="ms-2">{{ $ticket->level->name }}</p>
                    </div>
                    {{-- !Temporary! make this responsive so when a user accept in shows him --}}
                    @if(isset($ticket->acceptedBy))
                        <div class="w-100 pb-2">
                            <div class="mb-2"><strong>Accepted By:</strong></div>
                            <x-user-profile :subname="false" width="50" :user="$ticket->acceptedBy" />
                        </div>
                    @else
                        <div class="w-100 pb-2">
                            <div><strong>Accepted By:</strong></div>
                            <div class="ms-2">Name Here</div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-9">
                <div class="bg-dark px-3 py-2 rounded-1 text-light">
                    Chat
                </div>
                <div class="px-4 pt-3 pb-2 bg-light">
                    {{-- <ticket-messages :message='@json($message)' :current-user-id='@json(auth()->id())'
                        :sender-id='@json($message["sender_id"])' :tenant-id='@json($tenant_id)' :ticket-id='@json($ticket->id)'>
                    </ticket-messages> --}}
                    {{-- <ticket-messages
                    :ticket-id="{{ $ticket->id }}"
                    :tenant-id="{{ tenant()->id }}"
                    :current-user-id="{{ auth()->id() }}"
                    :ticket-status="'{{ $ticket->status->name }}'"
                    :initial-messages='@json($ticketMessages)'
                    ></ticket-messages> --}}
                    <ticket-messages-panel
                        :ticket-messages='@json($messages)'
                        :ticket='@json($ticket)'
                        :sender-id='@json(Auth::id())'
                        :tenant-id='@json(tenant()->id)'
                        :csrfToken='@csrf'
                    ></ticket-messages-panel>
                </div>
            </div>
        </div>
@endsection