<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group( function () {
   Route::post('/post_images',[\App\Http\Controllers\PostImageController::class,'store']);
   Route::post('/posts',[\App\Http\Controllers\PostController::class,'store']);
   Route::get('/posts',[\App\Http\Controllers\PostController::class,'index']);



    Route::post('/posts/{post}/liked_posts',[\App\Http\Controllers\PostController::class,'toggleLike']);
    Route::post('/posts/{post}/repost',[\App\Http\Controllers\PostController::class,'repost']);
    Route::post('/posts/{post}/comment',[\App\Http\Controllers\PostController::class,'comment']);
    Route::get('/posts/{post}/comment',[\App\Http\Controllers\PostController::class,'getComments']);
    Route::get('/users',[\App\Http\Controllers\UserController::class,'index']);
    Route::get('/users/{user}/posts',[\App\Http\Controllers\UserController::class,'posts']);

    Route::post('/user/stats',[\App\Http\Controllers\UserController::class,'stat']);

    Route::post('/users/{user}/toggle_follow',[\App\Http\Controllers\UserController::class,'toggleFollow']);
    Route::get('/users/following_posts',[\App\Http\Controllers\UserController::class,'followingPost']);

    Route::delete('/posts/{comment}',[\App\Http\Controllers\PostController::class,'deleteComment']);
    Route::delete('/posts/{post}/post',[\App\Http\Controllers\PostController::class,'deletePost']);
});
