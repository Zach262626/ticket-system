<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Ticket {{ $ticketId ?? 'N/A' }} Deleted</title>
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
        <div class="header">Ticket {{ $ticketId ?? 'N/A' }} Deleted</div>

        <div class="section">
            <span class="label">Created By:</span> {{ $ticket->createdBy->name ?? 'N/A' }}
        </div>

        <div class="section">
            <span class="label">Assigned By:</span> {{ $ticket->acceptedBy->name ?? 'N/A' }}
        </div>
    </div>
</body>

</html>