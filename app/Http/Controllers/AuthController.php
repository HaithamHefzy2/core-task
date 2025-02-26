<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\StoreUserRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use App\Traits\ApiResponse;
use App\Models\User;
use App\Events\UserRegistered;

class AuthController extends Controller
{
    use ApiResponse;

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Handle user registration
    public function register(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = $this->userService->createUser($data);

        // Fire event for user registration
        event(new UserRegistered($user));
        // save the log
        activity()
            ->causedBy($user)
            ->withProperties(['email' => $user->email])
            ->log('User Registered');

        // Create token for user
        $token = $user->createToken('api_token')->plainTextToken;

        return $this->successResponse([
            'user'  => new UserResource($user),
            'token' => $token,
        ], 'Registration successful');
    }

    // Handle user login
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return $this->errorResponse('Invalid credentials', 401);
        }
        // save the log
        activity()
            ->causedBy($user)
            ->withProperties(['ip' => $request->ip()])
            ->log('User Logged In');
        // Create token for user
        $token = $user->createToken('api_token')->plainTextToken;

        return $this->successResponse([
            'user'  => new UserResource($user),
            'token' => $token,
        ], 'Login successful');
    }

    // Handle user logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->successResponse([], 'Logged out successfully');
    }
}
