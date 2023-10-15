<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\Product\ProductResource;
use App\Http\Requests\Product\ProductRequest;
use Illuminate\Support\Facades\Cache;
use App\Models\Product\Product;

class ProductController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ProductResource::collection(
            Cache::rememberForever(
                'products',
                function () {
                    return Product::latest()->simplePaginate(2);
                }
            )
        );
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $product = Product::create($validated);

        return response()->json($product, 201);
    }

    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }

    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        $validated = $request->validated();
        $product->update($validated);

        return response()->json($product, 200);
    }

    public function destroy(Product $product): Response
    {
        $product->delete();

        return response()->noContent();
    }
}
