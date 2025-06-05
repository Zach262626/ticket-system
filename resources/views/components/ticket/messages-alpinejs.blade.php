{{-- <div 
    x-data="messageComponent({{ $ticket->id }}, {{ auth()->id() }}, {{ $tenantId }}, window.initialMessages)"
    x-init="init()"
    class="p-2 d-flex overflow-auto flex-column-reverse"
    style="height: 400px;"
    id="messages-container">
    <template x-for="message in messages" :key="message.id">
        <div>
            <template x-if="message.sender_id === currentUserId">
                <div class="d-flex flex-row justify-content-end w-100 mb-2">
                    <div class="bg-primary text-white rounded-3 p-2 mb-1 text-end"
                        style="max-width: 75%; word-wrap: break-word;">
                        <p class="m-0" x-text="message.content"></p>
                    </div>
                </div>
            </template>

            <template x-if="message.sender_id !== currentUserId">
                <div class="d-flex flex-row justify-content-start w-100 mb-2">
                    <div class="bg-light border rounded-3 p-2 mb-1 text-start"
                        style="max-width: 75%; word-wrap: break-word;">
                        <p class="m-0" x-text="message.content"></p>
                    </div>
                </div>
            </template>
        </div>
    </template>
</div> --}}
{{-- <div x-data="messageSender({{ $ticketid }}, {{ $senderid }}, '{{ ($ticket->status)->name }}')" class="w-100">
    <div class="input-group mb-3 mt-2">
        <input x-model="content" :disabled="!canSend" type="text"
            class="form-control mx-2 rounded"
            aria-label="Message input"
            placeholder="Message here"
        >
        <span>
            <button
                @click="sendMessage"
                type="button"
                class="px-5 btn"
                :class="canSend ? 'btn-primary' : 'btn-secondary'"
                :disabled="!canSend"
            >
                Send
            </button>
        </span>
    </div>
</div> --}}

{{-- @push('scripts')
<script>
    window.initialMessages = @json($ticketMessages);
    function messageComponent(ticketId, currentUserId, tenantId, initialticketMessages = []) {
        return {
            messages: initialMessages,
            currentUserId,
            init() {
                window.Echo.private(`tenant-${tenantId}.ticket-${ticketId}`)
                    .listen('.broadcast-test', (e) => {
                        console.log('here')
                    });
            }
        }
    }
    function messageSender(ticketId, senderId, statusName) {
        return {
            content: '',
            canSend: statusName === 'in_progress',
            async sendMessage() {
                if (!this.canSend || this.content.trim() === '') return;

                try {
                    const response = await fetch('{{ route('ticket-message-store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            content: this.content,
                            ticket_id: ticketId,
                            sender_id: senderId,
                        })
                    });

                    if (!response.ok) {
                        const errText = await response.text();
                        console.error('Server error:', errText);
                        alert('Failed to send message.');
                        return;
                    }

                    const newMessage = await response.json();
                    this.content = '';
                } catch (e) {
                    console.error('Error sending message:', e);
                    alert('Something went wrong.');
                }
            }
        }
    }
</script>
@endpush --}}