<?php

namespace App\Services;

use App\Repositories\CommentRepository;

class CommentService
{
    protected CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function getAllComments($perPage = null)
    {
        return $this->commentRepository->getAll($perPage);
    }

    public function getCommentsByPostId($postId, $perPage = null)
    {
        return $this->commentRepository->getByPostId($postId, $perPage);
    }

    public function createComment(array $data)
    {
        return $this->commentRepository->create($data);
    }

    public function getCommentById($id)
    {
        return $this->commentRepository->findById($id);
    }

    public function updateComment($id, array $data)
    {
        return $this->commentRepository->update($id, $data);
    }

    public function deleteComment($id)
    {
        return $this->commentRepository->delete($id);
    }
}
