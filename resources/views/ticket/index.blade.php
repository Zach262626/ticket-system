@extends('layouts.app')
@section('content')
    <div class="container py-5">
        <div class="row">
            <h1 class="col">My Support Tickets</h1>
        </div>
        <div class="row bg-dark px-3 py-2 rounded-1">
            <div class="col text-light">Ticket List</div>
        </div>
        <div class="row">
            <div class="px-4 pt-3 pb-2 bg-light">
                <a href="{{ route('ticket-create') }}" class="btn btn btn-primary">Create new Ticket</a>
                <table class="table mt-2 w-100">
                    <thead>
                        <tr>
                            <th class="col-1" scope="col">Ticket #</th>
                            <th class="col-5" scope="col">Description</th>
                            <th class="col-2" scope="col">Type</th>
                            <th class="col-2" scope="col">Status</th>
                            <th class="col-2" scope="col">View</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $ticket)
                            <tr>
                                <th scope="row">{{ $ticket->id }}</th>
                                <td>{{ $ticket->description }}</td>
                                <td>{{ optional($ticket->type)->name }}</td>
                                <td>{{ optional($ticket->status)->name }}</td>
                                <td><a href="{{ route('ticket-show', ['ticket' => $ticket->id]) }}">Here</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $tickets->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection