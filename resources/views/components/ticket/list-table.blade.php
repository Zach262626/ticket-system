<div>
    <table class="table mt-2 w-100">
        <thead>
            <tr>
                <th class="col-1" scope="col">Ticket #</th>
                <th class="col-5" scope="col">Description</th>
                <th class="col-2" scope="col">Type</th>
                @can('delete tickets')
                    <th class="col-1" scope="col">Status</th>
                    <th class="col-1" scope="col">Delete</th>
                @else
                    <th class="col-2" scope="col">Status</th>
                @endcan
                @can('edit tickets')
                    <th class="col-1" scope="col">View</th>
                    <th class="col-1" scope="col">Edit</th>
                @else
                    <th class="col-2" scope="col">View</th>
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
                        <td>
                            <form action="{{ route('ticket-delete', ['ticket' => $ticket->id]) }}" method="POST">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                        <td>{{ optional($ticket->status)->name }}</td>
                    @else
                        <td>{{ optional($ticket->status)->name }}</td>
                    @endcan
                    @can('edit tickets')
                        <td><a href="{{ route('ticket-show', ['ticket' => $ticket->id]) }}">Here</a></td>
                        <td><a href="{{ route('ticket-edit', ['ticket' => $ticket->id]) }}">Edit</a></td>
                    @else
                        <td><a href="{{ route('ticket-show', ['ticket' => $ticket->id]) }}">Here</a></td>
                    @endcan
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-3">
        {{ $tickets->links() }}
    </div>
</div>