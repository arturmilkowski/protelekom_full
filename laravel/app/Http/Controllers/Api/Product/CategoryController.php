<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\Product\CategoryResource;
use App\Http\Requests\Product\CategoryRequest;
use Illuminate\Support\Facades\Cache;
use App\Models\Product\Category;

class CategoryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return CategoryResource::collection(
            Cache::rememberForever(
                'categories',
                function () {
                    return Category::latest()->get();
                }
            )
        );
    }

    public function store(CategoryRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $category = Category::create($validated);

        return response()->json($category, 201);
    }

    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category);
    }

    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        $validated = $request->validated();
        $category->update($validated);

        return response()->json($category, 200);
    }

    public function destroy(Category $category): Response
    {
        $category->delete();

        return response()->noContent();
    }
}
