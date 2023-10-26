<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Blog\{PostController, PostImgController};
use App\Http\Controllers\Api\Product\{
    BrandController,
    CategoryController,
    ConditionController,
    ProductController,
    ProductImgController,
    TypeController,
    TypeImgController
};
use App\Http\Controllers\Api\Page\AboutController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('blog/posts', PostController::class)->names('api.blog.posts');
    Route::delete('blog/posts/images/{post}', PostImgController::class)->name('api.blog.posts.images.destroy');

    Route::apiResource('products/brands', BrandController::class)->names('api.products.brands');
    Route::apiResource('products/categories', CategoryController::class)->names('api.products.categories');
    Route::apiResource('products/conditions', ConditionController::class)->names('api.products.conditions');
    Route::apiResource('products', ProductController::class)->names('api.products');
    Route::delete('products/images/{product}', ProductImgController::class)->name('api.products.images.destroy');
    Route::apiResource('products.types', TypeController::class)->names('api.products.types');
    Route::delete('products/{product}/types/images/{type}', TypeImgController::class)->name('api.products.types.images.destroy');

    Route::get('about', AboutController::class)->name('api.pages.about');
});
