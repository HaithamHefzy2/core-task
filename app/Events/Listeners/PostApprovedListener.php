<?php

namespace App\Listeners;

use App\Events\PostApproved;
use App\Notifications\PostApprovedNotification;

class PostApprovedListener
{
    /**
     * Handle the event.
     *
     * @param PostApproved $event
     * @return void
     */
    public function handle(PostApproved $event)
    {
        // Notify the post author
        $post = $event->post;
        $post->user->notify(new PostApprovedNotification($post));
    }
}
