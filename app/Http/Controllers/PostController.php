<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PostService;
use App\Http\Resources\PostResource;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Traits\ApiResponse;

class PostController extends Controller
{
    use ApiResponse;

    protected PostService $postService;

    /**
     *
     * @param PostService $postService
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of posts
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $posts = $this->postService->getAllPosts($request->get('per_page'));
        return $this->successResponse(PostResource::collection($posts), 'Posts retrieved successfully');
    }

    /**
     * Store a  post.
     *
     * @param StorePostRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();

        $post = $this->postService->createPost($data);

        // Sync categories if provided
        if (isset($data['categories'])) {
            $post->categories()->sync($data['categories']);
        }

        // save the log
        activity()
            ->causedBy(auth()->api()->user())
            ->performedOn($post)
            ->withProperties(['title' => $post->title])
            ->log('Post Created');

        return $this->successResponse(new PostResource($post), 'Post created successfully');
    }

    /**
     * Display the  post.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {

        $post = $this->postService->getPostById($id);

        return $post
            ? $this->successResponse(new PostResource($post), 'Post retrieved successfully')
            : $this->errorResponse('Post not found', 404);
    }

    /**
     * Update the  post.
     *
     * @param UpdatePostRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePostRequest $request, $id)
    {
        $data = $request->validated();

        $post = $this->postService->updatePost($id, $data);

        if (! $post) {
            return $this->errorResponse('Post not found', 404);
        }

        // Sync categories if provided
        if (isset($data['categories'])) {
            $post->categories()->sync($data['categories']);
        }

        // save the log
        activity()
            ->causedBy(auth()->user())
            ->performedOn($post)
            ->withProperties(['title' => $post->title])
            ->log('Post Updated');

        return $this->successResponse(new PostResource($post), 'Post updated successfully');
    }

    /**
     * Remove the post.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return $this->postService->deletePost($id)
            ? $this->successResponse([], 'Post deleted successfully')
            : $this->errorResponse('Post not found', 404);
    }
}
