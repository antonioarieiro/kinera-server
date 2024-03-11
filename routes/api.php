<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\SocialPostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotificationController;
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('users')->group(function () {
    Route::get('/{user}', [UserProfileController::class, 'get']);
    Route::get('/follow/{id}/{follow}', [UserProfileController::class, 'verifyFollow']);
    Route::post('/user', [UserProfileController::class, 'create']);
    Route::post('/follow/{id}/{follow}', [UserProfileController::class, 'follow']);
    Route::post('/unfollow/{id}/{follow}', [UserProfileController::class, 'unfollow']);
    
});

Route::prefix('social')->group(function () {
    Route::get('/{id}', [SocialPostController::class, 'getById']);
    Route::get('', [SocialPostController::class, 'getAllPosts']);
    Route::get('post/{id}', [SocialPostController::class, 'getPost']);
    Route::get('/folowers/{user}', [UserProfileController::class, 'getFollowers']);
    Route::get('/followings/{user}', [UserProfileController::class, 'getFollowings']);
    Route::get('/posts/{user}', [SocialPostController::class, 'getPostsByUser']);
    Route::post('post/{id}', [SocialPostController::class, 'editPost']);
    Route::post('', [SocialPostController::class, 'create']);
    Route::post('post/{id}', [SocialPostController::class, 'editPost']);
    Route::post('post/remove/{id}', [SocialPostController::class, 'removePost']);
});

Route::prefix('comment')->group(function () {
    Route::get('/{id}', [CommentController::class, 'getById']);
    Route::post('', [CommentController::class, 'create']);
});

Route::prefix('notification')->group(function () {
  Route::get('', [NotificationController::class, 'viewAll']);
  Route::get('/uu39', [NotificationController::class, 'getById']);
  Route::post('', [NotificationController::class, 'create']);
  Route::post('/remove', [NotificationController::class, 'removeAll']);
});