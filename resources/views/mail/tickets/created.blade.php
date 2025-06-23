<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>New Ticket Created: #{{ $ticket->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            color: #333;
            padding: 20px;
        }

        .card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
        }

        .header {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .section {
            margin-bottom: 10px;
        }

        .label {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="header">New Ticket Created: #{{ $ticket->id }}</div>

        <div class="section">
            <span class="label">Created By:</span> {{ $ticket->createdBy->name ?? 'N/A' }}
        </div>

        <div class="section">
            <span class="label">Description:</span><br>
            {{ $ticket->description }}
        </div>

        <div class="section">
            <span class="label">Status:</span> {{ $ticket->status->name ?? 'N/A' }}
        </div>

        <div class="section">
            <span class="label">Level:</span> {{ $ticket->level->name ?? 'N/A' }}
        </div>

        <div class="section">
            <span class="label">Type:</span> {{ $ticket->type->name ?? 'N/A' }}
        </div>


        <div class="section" style="margin-top: 20px;">
            <a href="{{ $tenantDomainPath }}/ticket/{{ $ticket->id }}">View Ticket</a>
        </div>
    </div>
</body>

</html>