<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Blog\{PostController, PostImgController};


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('blog/posts', PostController::class)->names('api.blog.posts');
    Route::delete('blog/posts/images/{post}', PostImgController::class)->name('api.blog.posts.images.destroy');
});
// Route::get('/dashboard', function () { return ['laravel' => app()->version(), 'php' => PHP_VERSION]; });
