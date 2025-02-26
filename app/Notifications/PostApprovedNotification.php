<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Post;

class PostApprovedNotification extends Notification
{
    use Queueable;

    public Post $post;

    /**
     * Create a new notification instance.
     *
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Post Has Been Approved')
            ->line('Your post titled "' . $this->post->title . '" has been approved.')
            ->action('View Post', url('/posts/' . $this->post->id))
            ->line('Thank you for using our website!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'post_id' => $this->post->id,
            'title'   => $this->post->title,
        ];
    }
}
