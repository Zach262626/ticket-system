<div class="p-1 d-flex overflow-auto flex-column-reverse" style="height: 400px;" id="messages-container">
    @foreach ($ticketMessages as $message)
        {{-- <ticket-messages :message='@json($message)' :current-user-id='@json(auth()->id())'
            :sender-id='@json($message["sender_id"])' :tenant-id='@json($tenant_id)' :ticket-id='@json($ticket->id)'>
        </ticket-messages> --}}
        @if ($message['sender_id'] == $senderid)
        <div class="d-flex flex-row justify-content-start w-100">
            <div class="d-flex flex-column align-items-end w-100 pe-2">
                <div class="bg-primary text-white rounded-3 p-2 mb-1 text-end"
                    style="max-width: 75%; word-wrap: break-word;">
                    {{ $message['content'] }}
                </div>
                <p class="small me-3 text-muted" style="font-size:12px">
                    {{ \Carbon\Carbon::parse($message['created_at'])->format('M d, Y h:i A') }}
                </p>
            </div>
            @if(($message->sender)->profile_picture == null)
            <img src="{{ Avatar::create(($message->sender)->name) }}" alt="Avatar" class="avatar" width="45"
                style="vertical-align: middle;  border-radius:50%; height:45px" />
            @else
            <img src="{{ ($message->sender)->profile_picture }}" alt="Avatar" class="avatar" width="45"
                style="vertical-align: middle;  border-radius:50%; height:45px" />
            @endif
        </div>
        @else
        <div class="d-flex flex-row justify-content-start w-100">
            @if(($message->sender)->profile_picture == null)
            <img src="{{ Avatar::create(($message->sender)->name) }}" alt="Avatar" class="avatar" width="45"
                style="vertical-align: middle;  border-radius:50%; height:45px" />
            @else
            <img src="{{ ($message->sender)->profile_picture}}" alt="Avatar" class="avatar" width="45"
                style="vertical-align: middle;  border-radius:50%; height:45px" />
            @endif
            <div class="d-flex flex-column align-items-start w-100 ps-2">
                <div class="bg-body-tertiary rounded-3 p-2 mb-1 text-start" style="max-width: 75%; word-wrap: break-word;">
                    {{ $message['content'] }}
                </div>
                <p class="small me-3 text-muted" style="font-size:12px">
                    {{ \Carbon\Carbon::parse($message['created_at'])->format('M d, Y h:i A') }}
                </p>
            </div>
        </div>
        @endif
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
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof Echo !== 'undefined') {
            console.log('Echo is connected');
            // Echo.private('channel-name')
            //     .listen('.broadcast-test-true', (e) => {
            //         console.log('here2', e);
            //     });
            Echo.private('tenant-{{ tenant()->id }}.ticket-{{ $ticketid }}')
                .listen('.broadcast-test', (e) => {
                    console.log('here', e);
                });
            // Echo.private('channel-name-{{ $ticketid }}')
            //     .listen('.broadcast-test-true', (e) => {
            //         console.log('here2', e);
            //         // Example of using a Blade variable in JS:
            //         let ticketId = @json($ticketid);
            //         console.log('Ticket ID:', ticketId);
            //     });
        } else {
            console.error('Echo is not defined');
        }
    });
</script>
@endpush