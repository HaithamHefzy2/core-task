<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Jobs\SendWelcomeEmailJob;

class SendWelcomeEmailListener
{
    // Handle the event and dispatch a queue job
    public function handle(UserRegistered $event)
    {
        SendWelcomeEmailJob::dispatch($event->user);
    }
}
