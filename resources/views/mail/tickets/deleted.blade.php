<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Ticket {{ $ticket['id'] }} Deleted</title>
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
        <div class="header">Ticket {{ $ticket['id'] }} Deleted</div>

        <div class="section">
            <span class="label">Created By:</span> {{ $ticket['created_by']['name'] ?? 'N/A' }}
        </div>

        <div class="section">
            <span class="label">Assigned By:</span> {{ $ticket['accepted_by']['name'] ?? 'N/A' }}
        </div>

        <div class="section">
            <span class="label">Description:</span><br>
            {{ $ticket['description'] }}
        </div>

        <div class="section">
            <span class="label">Status:</span> Closed
        </div>

        <div class="section">
            <span class="label">Level:</span> {{ $ticket['level']['name'] ?? 'N/A' }}
        </div>

        <div class="section">
            <span class="label">Type:</span> {{ $ticket['type']['name'] ?? 'N/A' }}
        </div>
    </div>
</body>

</html>