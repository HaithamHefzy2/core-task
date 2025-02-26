<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;

// Authentication Routes for  (registration & login)
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Authentication related routes
    Route::post('logout', [AuthController::class, 'logout']);

    // Get authenticated user info
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Activity Logs endpoint
    Route::get('activity-logs', [ActivityLogController::class, 'index']);

    // Users management routes
    Route::apiResource('users', UserController::class)->except(['store']);

    // Posts management routes
    Route::apiResource('posts', PostController::class);

    // Categories management routes
    Route::apiResource('categories', CategoryController::class);

    // Comments management routes
    Route::apiResource('comments', CommentController::class);
    Route::get('posts/{post}/comments', [CommentController::class, 'indexByPost']);

    // Roles management routes
    Route::apiResource('roles', RoleController::class);

    // Permissions management routes
    Route::apiResource('permissions', PermissionController::class);
});
