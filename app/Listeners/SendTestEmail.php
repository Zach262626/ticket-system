<?php

namespace App\Listeners;

use App\Events\TestEvent;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;

class SendTestEmail
{
    public function handle(TestEvent $event): void
    {
        Mail::to($event->email)->send(new TestMail());
    }
}
