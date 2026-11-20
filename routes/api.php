<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReactPostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->name('auth.')->group(function () {

    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::middleware('auth:sanctum')->group(function (){
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/me',[AuthController::class,'me'])->name('me');
    });

});



Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('posts', PostController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('profiles', ProfileController::class);
    Route::apiResource('bookmarks',BookmarkController::class);
    Route::apiResource('users', UserController::class);
    Route::get('users-count', [UserController::class,'countUsers']);
    Route::get('users/{userId}/posts', [PostController::class, 'userPosts'])->name('posts.userPosts');
    Route::get('latestposts', [PostController::class, 'latestPosts'])->name('posts.latestPosts');
    Route::get('posts-count', [PostController::class, 'countPosts'])->name('posts.countPosts');
    Route::get('featured', [PostController::class, 'featuredPosts'])->name('posts.featuredPosts');
    Route::get('interests', [InterestController::class, 'index'])->name('interests.index');
    Route::post('/bookmarks/{postId}', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');
    Route::post('/interests/{category_id}', [InterestController::class, 'toggle'])->name('interests.toggle');
    Route::post('/posts/{postId}/react', [ReactPostController::class, 'toggle'])->name('reactposts.toggle');
    Route::get('/posts/{post}/comments', [CommentController::class, 'index']);
    Route::post('/posts/{post}/comments', [CommentController::class, 'store']);
    Route::patch('/comments/{comment}', [CommentController::class, 'update']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);
});







// Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
