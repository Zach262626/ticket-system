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
        <div class="px-4 pt-3 bg-light">
            <div>
                <a href="{{ route('ticket-create') }}" class="btn btn-primary">Create new Ticket</a>
            </div>
            <div class="mt-3">
                <form method="GET" action="{{ route('ticket-search') }}" class="d-flex gap-2 align-items-center">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tickets..."
                        class="form-control w-auto" style="min-width: 250px;" />
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="px-4 pb-2 bg-light">
            <x-ticket.list-table :tickets="$tickets" />
        </div>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show my-2" role="alert">
        <ul class="list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
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
@endsection