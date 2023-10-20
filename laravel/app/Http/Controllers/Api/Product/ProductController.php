<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\Cache;
use App\Http\Resources\Product\ProductResource;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Product\Product;
use App\Services\File;

class ProductController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ProductResource::collection(Product::latest()->get());
        /*
        return ProductResource::collection(
            Cache::rememberForever(
                'products',
                function () {
                    return Product::latest()->simplePaginate(2);
                }
            )
        );
        */
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $file = $request->file('img');
        if ($file) {
            $extension = $file->extension();
            $filename = $validated['slug'] . '.' . $extension;
            File::store($request, config('settings.filepath.product'), $filename);
            $validated['img'] = $filename;
        }

        $product = Product::create($validated);

        return response()->json($product, 201);
    }

    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }

    public function update(ProductRequest $request, Product $product) //: JsonResponse
    {
        $validated = $request->validated();

        $file = $request->file('img');
        if ($file) {
            $extension = $file->extension();
            $filename = $validated['slug'] . '.' . $extension;
            $path = File::update($request, $product->img, config('settings.filepath.product'), $filename);
            if ($path) {
                $validated['img'] = $filename; // assign new path
            }
        }

        $product->update($validated);

        return response()->json($product, 200);
    }

    public function destroy(Product $product): Response
    {
        if ($product->img) {
            Storage::delete(config('settings.filepath.product') . $product->img);
        }

        $product->delete();

        return response()->noContent();
    }
}
