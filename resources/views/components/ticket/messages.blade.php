<div class="p-1 overflow-auto" style="height: 400px;">
    <div class="d-flex flex-row justify-content-start w-100">
        <div class="d-flex flex-column align-items-end mb-2 w-100 pe-2">
            <div class="bg-primary text-white rounded-3 p-2 mb-1 text-end"
                style="max-width: 75%; word-wrap: break-word;">
                MESSAGE 1
            </div>
            <div class="bg-primary text-white rounded-3 p-2 mb-1 text-end"
                style="max-width: 75%; word-wrap: break-word;">
                MESSAGE 2
            </div>
            <div class="bg-primary text-white rounded-3 p-2 mb-1 text-end"
                style="max-width: 75%; word-wrap: break-word;">
                MESSAGE 3
            </div>
            <div class="bg-primary text-white rounded-3 p-2 mb-1 text-end"
                style="max-width: 75%; word-wrap: break-word;">
                MESSAGE 4 MESSAGE 4 MESSAGE 4 MESSAGE 4 MESSAGE 4 MESSAGE 4 MESSAGE 4 MESSAGE 4...
            </div>
            <p class="small me-3 mb-3 text-muted">00:06</p>
        </div>
        <img src="https://loremflickr.com/200/200?random=1" alt="Avatar" class="avatar" width="45"
            style="vertical-align: middle;  border-radius:50%; height: 100%;" />
    </div>
    <div class="d-flex flex-row justify-content-start w-100">
        <img src="https://loremflickr.com/200/200?random=1" alt="Avatar" class="avatar" width="45"
            style="vertical-align: middle;  border-radius:50%; height: 100%;" />
        <div class="d-flex flex-column align-items-start mb-2 w-100 ps-2">
            <div class="bg-body-tertiary rounded-3 p-2 mb-1 text-start" style="max-width: 75%; word-wrap: break-word;">
                message 1
            </div>
            <div class="bg-body-tertiary rounded-3 p-2 mb-1 text-start" style="max-width: 75%; word-wrap: break-word;">
                message 2
            </div>
            <div class="bg-body-tertiary rounded-3 p-2 mb-1 text-start" style="max-width: 75%; word-wrap: break-word;">
                message 3
            </div>
            <p class="small me-3 mb-3 text-muted">00:06</p>
        </div>
    </div>
    <div class="d-flex flex-row justify-content-start w-100">
        <div class="d-flex flex-column align-items-end mb-2 w-100 pe-2">
            <div class="bg-primary text-white rounded-3 p-2 mb-1 text-end"
                style="max-width: 75%; word-wrap: break-word;">
                This is a test, This is a test, This is a test, This is a test,
                This is a test, This is a test, This is a test, This is a test,
                This is a test, This is a test, This is a test, This is a test,
            </div>
            <p class="small me-3 mb-3 text-muted">00:06</p>
        </div>
        <img src="https://loremflickr.com/200/200?random=1" alt="Avatar" class="avatar" width="45"
            style="vertical-align: middle;  border-radius:50%; height: 100%;" />
    </div>
</div>


<div>
    <form action="">
        <div class="input-group mb-3 mt-2">
            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
            <input type="hidden" name="sender_id" value="{{ $user->id }}">
            <input type="hidden" name="receiver_id" value="{{ $user->id }}">
            <input type="text" class="form-control mx-2" aria-label="Sizing example input"
                aria-describedby="inputGroup-sizing-default" placeholder="Message here">
            @if ($canSendMessage)
                <input type="text" class="form-control mx-2" aria-label="Sizing example input"
                    aria-describedby="inputGroup-sizing-default" placeholder="Message here">
                <span><button class="px-5 btn btn-primary">Send</button></span>
            @else
                <input type="text" class="form-control mx-2" aria-label="Sizing example input"
                    aria-describedby="inputGroup-sizing-default" placeholder="Wait for the support agent.">
                <span><button type="button" class="px-5 btn btn-hidden">Send</button></span>
            @endif
            <span><button class="px-5 btn btn-primary">Send</button></span>
        </div>
    </form>
</div>