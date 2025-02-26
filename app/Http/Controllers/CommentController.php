<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CommentService;
use App\Http\Resources\CommentResource;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Traits\ApiResponse;

class CommentController extends Controller
{
    use ApiResponse;

    protected CommentService $commentService;

    /**
     * Inject the CommentService.
     *
     * @param CommentService $commentService
     */
    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * Display a listing of all comments
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $comments = $this->commentService->getAllComments($request->get('per_page'));
        return $this->successResponse(CommentResource::collection($comments), 'Comments retrieved successfully');
    }

    /**
     * Display a listing of comments for a specific post.
     *
     * @param int $postId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexByPost($postId, Request $request)
    {
        $comments = $this->commentService->getCommentsByPostId($postId, $request->get('per_page'));
        return $this->successResponse(CommentResource::collection($comments), 'Comments for post retrieved successfully');
    }

    /**
     * Store a comment.
     *
     * @param StoreCommentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCommentRequest $request)
    {
        $data = $request->validated();
        $comment = $this->commentService->createComment($data);

        // save the log
        activity()
            ->causedBy(auth()->user())
            ->performedOn($comment)
            ->withProperties(['content' => $comment->content])
            ->log('Comment Created');
        return $this->successResponse(new CommentResource($comment), 'Comment created successfully', 201);
    }

    /**
     * Display the comment.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $comment = $this->commentService->getCommentById($id);
        return $comment
            ? $this->successResponse(new CommentResource($comment), 'Comment retrieved successfully')
            : $this->errorResponse('Comment not found', 404);
    }

    /**
     * Update the comment.
     *
     * @param UpdateCommentRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCommentRequest $request, $id)
    {
        $data = $request->validated();
        $comment = $this->commentService->updateComment($id, $data);
       // save the log
        if ($comment) {
            activity()
                ->causedBy(auth()->user())
                ->performedOn($comment)
                ->withProperties(['content' => $comment->content])
                ->log('Comment Updated');
        }

        return $comment
            ? $this->successResponse(new CommentResource($comment), 'Comment updated successfully')
            : $this->errorResponse('Comment not found', 404);
    }

    /**
     * Remove the comment.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return $this->commentService->deleteComment($id)
            ? $this->successResponse([], 'Comment deleted successfully')
            : $this->errorResponse('Comment not found', 404);
    }
}
