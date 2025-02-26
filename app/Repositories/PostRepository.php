<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
    // Retrieve all posts
    public function getAll($perPage = null)
    {
        return $perPage ? Post::paginate($perPage) : Post::all();
    }

    // Create a new post
    public function create(array $data)
    {
        return Post::create($data);
    }

    // Find post by ID
    public function findById($id)
    {
        return Post::find($id);
    }

    // Update post data
    public function update($id, array $data)
    {
        $post = Post::find($id);
        if ($post) {
            $post->update($data);
            return $post;
        }
        return null;
    }

    // Delete a post
    public function delete($id)
    {
        $post = Post::find($id);
        return $post ? $post->delete() : false;
    }
}
