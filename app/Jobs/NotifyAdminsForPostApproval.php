<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PostApprovalNotification;

class NotifyAdminsForPostApproval implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function handle()
    {
       // get the all admins
        $admins = \App\Models\User::role('admin')->get();

      // send notification to them
        Notification::send($admins, new PostApprovalNotification($this->post));
    }
}
