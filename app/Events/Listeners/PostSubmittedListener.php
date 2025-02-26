<?php

namespace App\Listeners;

use App\Events\PostSubmitted;
use App\Jobs\NotifyAdminsForPostApproval;

class PostSubmittedListener
{
    public function handle(PostSubmitted $event)
    {

        NotifyAdminsForPostApproval::dispatch($event->post);
    }
}
