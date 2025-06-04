<div class="p-1 d-flex overflow-auto flex-column-reverse" style="height: 400px;" id="messages-container">
    @foreach ($ticketMessages as $message)
        <ticket-messages :message='@json($message)' :current-user-id='@json(auth()->id())'
            :sender-id='@json($message["sender_id"])' :tenant-id='@json($tenant_id)' :ticket-id='@json($ticket->id)'>
        </ticket-messages>
    @endforeach
</div>
<div>
    <form action="{{ route('ticket-message-store') }}" method="POST">
        @csrf
        <div class="input-group mb-3 mt-2">
            <input type="hidden" name="ticket_id" value="{{ $ticketid }}">
            <input type="hidden" name="sender_id" value="{{ $senderid }}">
            @if (($ticket->status)->name == 'in_progress')
                <input name='content' type="text" class="form-control mx-2 rounded" aria-label="Sizing example input"
                    aria-describedby="inputGroup-sizing-default" placeholder="Message here">
                <span><button class="px-5 btn btn-primary">Send</button></span>
            @else
                <input type="text" class="form-control mx-2 rounded" aria-label="Sizing example input"
                    aria-describedby="inputGroup-sizing-default" placeholder="Wait for the support agent.">
                <span><button type="button" class="px-5 btn btn-hidden">Send</button></span>
            @endif
        </div>
    </form>
</div>