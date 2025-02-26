<?php

namespace App\Services;

use App\Repositories\PostRepository;

class PostService
{
    protected PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    // Get all posts
    public function getAllPosts($perPage = null)
    {
        return $this->postRepository->getAll($perPage);
    }

    // Create new post
    public function createPost(array $data)
    {
        return $this->postRepository->create($data);
    }

    // Get post by ID
    public function getPostById($id)
    {
        return $this->postRepository->findById($id);
    }

    // Update post data
    public function updatePost($id, array $data)
    {
        return $this->postRepository->update($id, $data);
    }

    // Delete a post
    public function deletePost($id)
    {
        return $this->postRepository->delete($id);
    }
}
