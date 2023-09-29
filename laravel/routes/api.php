<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Blog\PostController;

Route::apiResource('blog/posts', PostController::class)->names('api.blog.posts');
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
