<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Post;

class PostApprovalNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Post Pending Approval')
            ->line('A new post titled "' . $this->post->title . '" has been submitted and is pending your review.')
            ->action('Review Post', url('/admin/posts/' . $this->post->id))
            ->line('Thank you for using our application!');
    }
}
