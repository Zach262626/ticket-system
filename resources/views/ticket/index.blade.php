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
                <x-ticket.list-table :tickets="$tickets" />
            </div>
        </div>
    </div>
@endsection