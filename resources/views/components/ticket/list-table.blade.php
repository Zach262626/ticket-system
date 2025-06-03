<div>
    @can('edit tickets')
        <table class="table mt-2 w-100 table-fixed align-middle text-break">
            <thead>
                <tr>
                    <th class="col-1" scope="col">Ticket #</th>
                    <th class="col-5" scope="col">Description</th>
                    <th class="col-1" scope="col">Type</th>
                    <th class="col-1" scope="col">Status</th>
                    @can('delete tickets')
                        <th class="col-1 text-center" scope="col">Assign</th>
                        <th class="col-1  text-center" scope="col">Delete</th>
                    @else
                        <th class="col-2 text-center" scope="col">Assigned By</th>
                    @endcan
                    <th class="col-1 text-center" scope="col">Edit</th>
                    <th class="col-1 text-center" scope="col">View</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                    <tr>
                        <td scope="row">{{ $ticket->id }}</td>
                        <td>{{ $ticket->description }}</td>
                        <td>{{ optional($ticket->type)->name }}</td>
                        <td>{{ optional($ticket->status)->name }}</td>

                        @if ($ticket->acceptedBy != null)
                            <td class="text-center">{{ optional($ticket->acceptedBy)->name }}</td>
                        @else
                            <td>
                                <form action="{{ route('ticket-assign', ['ticket' => $ticket->id]) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-primary w-100" type="submit">
                                        <i class="bi bi-person-check"></i>
                                    </button>
                                </form>
                            </td>
                        @endif

                        @can('delete tickets')
                            <td>
                                <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal"
                                    data-bs-target="#confirmDeleteModal">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <x-ticket.modal.delete :ticket="$ticket" />
                            </td>
                        @endcan

                        <td>
                            <a class="btn btn-primary w-100" href="{{ route('ticket-edit', ['ticket' => $ticket->id]) }}">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>

                        <td>
                            <a class="btn btn-secondary w-100" href="{{ route('ticket-show', ['ticket' => $ticket->id]) }}">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <table class="table mt-2 w-100 table-fixed align-middle text-break">
            <thead>
                <tr>
                    <th class="col-1" scope="col">Ticket #</th>
                    <th class="col-5" scope="col">Description</th>
                    <th class="col-2" scope="col">Type</th>
                    <th class="col-2" scope="col">Status</th>
                    <th class="col-2 text-center" scope="col">View</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                    <tr>
                        <td scope="row">{{ $ticket->id }}</td>
                        <td>{{ $ticket->description }}</td>
                        <td>{{ optional($ticket->type)->name }}</td>
                        <td>{{ optional($ticket->status)->name }}</td>
                        <td>
                            <a class="btn btn-secondary w-100" href="{{ route('ticket-show', ['ticket' => $ticket->id]) }}">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endcan
    <div class="mt-3">
        {{ $tickets->links() }}
    </div>
</div>