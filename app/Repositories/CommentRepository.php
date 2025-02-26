<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository
{
    public function getAll($perPage)
    {
        return $perPage ? Comment::paginate($perPage) : Comment::with('post','user')->get();
    }

    public function getByPostId($postId, $perPage)
    {
        $query = Comment::where('post_id', $postId);
        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    public function create(array $data)
    {
        return Comment::create($data);
    }

    public function findById($id)
    {
        return Comment::find($id);
    }

    public function update($id, array $data)
    {
        $comment = Comment::find($id);
        if ($comment) {
            $comment->update($data);
            return $comment;
        }
        return null;
    }

    public function delete($id)
    {
        $comment = Comment::find($id);
        return $comment ? $comment->delete() : false;
    }
}
