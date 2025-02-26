<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponse;

    protected UserService $userService;


    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // List users with
    public function index(Request $request)
    {
        $users = $this->userService->getAllUsers($request->get('per_page'));
        return $this->successResponse(UserResource::collection($users), 'Users retrieved successfully');
    }

    // Show user by ID
    public function show($id)
    {
        $user = $this->userService->getUserById($id);
        return $user
            ? $this->successResponse(new UserResource($user), 'User retrieved successfully')
            : $this->errorResponse('User not found', 404);
    }

    // Update user data
    public function update(UpdateUserRequest $request, $id)
    {
        $data = $request->validated();

        $user = $this->userService->updateUser($id, $data);
        if (! $user) {
            return $this->errorResponse('User not found', 404);
        }

        // Sync roles if provided
        if (isset($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        return $this->successResponse(new UserResource($user), 'User updated successfully');
    }

    // Delete a user
    public function destroy($id)
    {
        return $this->userService->deleteUser($id)
            ? $this->successResponse([], 'User deleted successfully')
            : $this->errorResponse('User not found', 404);
    }
}
