@extends('layouts.app')

@section('content')
    <div class="container-fluid p-5">
        <div class="row">
            <div class="col">
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
                        <x-user-profile :subname="false" width="100" :user="$ticket->createdBy" />
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
                        <div class="w-100">
                            <div><strong>Accepted By:</strong></div>
                            <p class="ms-2">{{ $ticket->acceptedBy->name }}</p>
                        </div>
                    @else
                        <div class="w-100">
                            <div><strong>Accepted By:</strong></div>
                            <p class="ms-2">Waiting</p>
                        </div>
                    @endif

                </div>
            </div>
            <div class="col-md-9">
                <div class="bg-dark px-3 py-2 rounded-1 text-light">
                    Chat
                </div>
                <div class="px-4 pt-3 pb-2 bg-light">
                </div>
            </div>
        </div>
    </div>
@endsection