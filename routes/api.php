<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\ProfileApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Authentication Routes
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });
});

// Get authenticated user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Profile Management API Routes
Route::middleware('auth:sanctum')->prefix('profile')->group(function () {
    Route::get('/', [ProfileApiController::class, 'show']);
    Route::put('/', [ProfileApiController::class, 'update']);
    Route::post('/password', [ProfileApiController::class, 'changePassword']);
    Route::post('/avatar', [ProfileApiController::class, 'uploadAvatar']);
    Route::delete('/avatar', [ProfileApiController::class, 'deleteAvatar']);
});

// Blog Management API Routes
Route::prefix('blog')->group(function () {
    // Public endpoints
    Route::get('posts', [PostController::class, 'index']);
    Route::get('posts/published', [PostController::class, 'published']);
    Route::get('posts/{post}', [PostController::class, 'show']);
    Route::get('posts/slug/{slug}', [PostController::class, 'showBySlug']);
    Route::get('posts/category/{category}', [PostController::class, 'byCategory']);

    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{category}', [CategoryController::class, 'show']);
    Route::get('categories/slug/{slug}', [CategoryController::class, 'showBySlug']);

    // Protected endpoints (require authentication)
    Route::middleware('auth:sanctum')->group(function () {
        // Posts management
        Route::post('posts', [PostController::class, 'store']);
        Route::put('posts/{post}', [PostController::class, 'update']);
        Route::delete('posts/{post}', [PostController::class, 'destroy']);
        Route::post('posts/{post}/publish', [PostController::class, 'publish']);
        Route::post('posts/{post}/unpublish', [PostController::class, 'unpublish']);

        // Categories management
        Route::post('categories', [CategoryController::class, 'store']);
        Route::put('categories/{category}', [CategoryController::class, 'update']);
        Route::delete('categories/{category}', [CategoryController::class, 'destroy']);
    });
});
