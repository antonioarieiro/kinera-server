<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\SocialPostController;
use App\Http\Controllers\CommentController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('users')->group(function () {
    Route::get('/{user}', [UserProfileController::class, 'get']);
    Route::post('/user', [UserProfileController::class, 'create']);
});

Route::prefix('social')->group(function () {
    Route::get('/{id}', [SocialPostController::class, 'getById']);
    Route::get('', [SocialPostController::class, 'getAllPosts']);
    Route::post('', [SocialPostController::class, 'create']);
});

Route::prefix('comment')->group(function () {
    Route::get('/{id}', [CommentController::class, 'getById']);
    Route::post('', [CommentController::class, 'create']);
});