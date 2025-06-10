@extends('layouts.app')
@section('content')
    <div class="container py-5">
        <div class="row">
            <h1 class="col">My Support Tickets</h1>
        </div>
        <div class="row">
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
        <div class="row bg-dark px-3 py-2 rounded-1">
            <div class="col text-light">Ticket List</div>
        </div>
        <div class="row">
            <div class="px-4 pt-3 bg-light d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <a href="{{ route('ticket-create') }}" class="btn btn-primary">Create new Ticket</a>
                </div>
                <div class="">
                    <form method="GET" action="{{ route('ticket-search') }}" class="d-flex gap-2 align-items-center">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tickets"
                            class="form-control w-auto" style="min-width: 250px;" />
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="px-4 pb-2 bg-light">
                <ticket-table :tickets='@json($tickets->items())' :can='@json(["edit" => auth()->user()->can("edit tickets"), "delete" => auth()->user()->can("delete tickets")])' csrf-token="{{ csrf_token() }}">
                    <template #pagination>
                        {!! $tickets->links() !!}
                    </template>
                </ticket-table>
            </div>
        </div>
    </div>
@endsection