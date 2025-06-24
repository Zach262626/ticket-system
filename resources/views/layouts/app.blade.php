<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Ticket System</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div id="app">
        <x-navbar :tenant-id="tenant('id')" :user-id="Auth::id()" />
        @if(tenant('id') != null)
            @auth
                {{-- Alerts --}}
                <ticket-created-alert :tenant-id="{{ tenant()->id }}" :user-id="{{ Auth::id() }}"></ticket-created-alert>
                <ticket-deleted-alert :tenant-id="{{ tenant()->id }}" :user-id="{{ Auth::id() }}"></ticket-deleted-alert>
                <ticket-status-alert :tenant-id="{{ tenant()->id }}" :user-id="{{ Auth::id() }}"></ticket-status-alert>
                <ticket-updated-alert :tenant-id="{{ tenant()->id }}" :user-id="{{ Auth::id() }}"></ticket-updated-alert>
                <ticket-message-alert :tenant-id="{{ tenant()->id }}" :user-id="{{ Auth::id() }}"></ticket-message-alert>
                <alert-stack></alert-stack>
            @endauth
        @endif
        @yield('content')

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>