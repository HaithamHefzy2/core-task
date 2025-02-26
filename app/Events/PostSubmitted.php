<?php

namespace App\Events;

use App\Models\Post;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostSubmitted
{
    use Dispatchable, SerializesModels;

    public Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }
}
