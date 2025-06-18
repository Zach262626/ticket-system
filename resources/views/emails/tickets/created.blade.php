<h1>Ticket #{{ $ticket->id }} Created</h1>
<p><strong>Status:</strong> {{ $ticket->status->name }}</p>
<p><strong>Description:</strong> {{ $ticket->description }}</p>
<p>Submitted at: {{ $ticket->created_at->format('Y-m-d H:i') }}</p>