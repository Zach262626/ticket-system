<div>
    <table class="table mt-2 w-100">
        <thead>
            <tr>
                <th class="col-1" scope="col">Ticket #</th>
                <th class="col-5" scope="col">Description</th>
                <th class="col-2" scope="col">Type</th>
                @can('delete tickets')
                <th class="col-1" scope="col">Status</th>
                <th class="col-1 text-center" scope="col">Delete</th>
                @else
                <th class="col-2" scope="col">Status</th>
                @endcan
                @can('edit tickets')
                <th class="col-1 text-center" scope="col">Edit</th>
                <th class="col-1 text-center" scope="col">View</th>
                @else
                <th class="col-2 text-center" scope="col">View</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach ($tickets as $ticket)
            <tr>
                <td scope="row">{{ $ticket->id }}</td>
                <td>{{ $ticket->description }}</td>
                <td>{{ optional($ticket->type)->name }}</td>
                @can('delete tickets')
                <td>{{ optional($ticket->status)->name }}</td>
                <td>
                    <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal"
                        data-bs-target="#confirmDeleteModal">
                        Delete
                    </button>
                    <x-ticket.modal.delete :ticket=$ticket />
                </td>
                @else
                <td>{{ optional($ticket->status)->name }}</td>
                @endcan
                @can('edit tickets')
                <td><a class="btn btn-primary w-100"
                        href="{{ route('ticket-edit', ['ticket' => $ticket->id]) }}">Edit</a></td>
                <td><a class="btn btn-secondary w-100"
                        href="{{ route('ticket-show', ['ticket' => $ticket->id]) }}">Here</a></td>
                @else
                <td><a class="btn btn-secondary w-100"
                        href="{{ route('ticket-show', ['ticket' => $ticket->id]) }}">Here</a></td>
                @endcan
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-3">
        {{ $tickets->links() }}
    </div>
</div>