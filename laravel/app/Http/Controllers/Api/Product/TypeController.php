<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\Product\TypeResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Product\TypeRequest;
use App\Models\Product\{Product, Type};
use App\Services\File;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product): AnonymousResourceCollection
    {
        return TypeResource::collection($product->with(['types'])->latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TypeRequest $request, Product $product): JsonResponse
    {
        $validated = $request->validated();

        $file = $request->file('img');
        if ($file) {
            $extension = $file->extension();
            $filename = $validated['slug'] . '.' . $extension;
            File::store($request, config('settings.filepath.type'), $filename);
            $validated['img'] = $filename;
        }

        // $typeObject = new Type($validated);
        // $type = $product->types()->save($typeObject);
        $type = $product->types()->create($validated);

        return response()->json($type, 201);
    }


    public function show(Product $product, Type $type): TypeResource
    {
        return new TypeResource($type);
    }

    public function update(TypeRequest $request, Product $product, Type $type): JsonResponse
    {
        $validated = $request->validated();

        $file = $request->file('img');
        if ($file) {
            $extension = $file->extension();
            $filename = $validated['slug'] . '.' . $extension;
            $path = File::update($request, $product->img, config('settings.filepath.type'), $filename);
            if ($path) {
                $validated['img'] = $filename; // assign new path
            }
        }

        $type->update($validated);
        // $type = $product->types()->save($validated);

        return response()->json($type, 200);
    }

    public function destroy(Product $product, Type $type): Response
    {
        if ($type->img) {
            Storage::delete(config('settings.filepath.type') . $product->img);
        }

        $type->delete();

        return response()->noContent();
    }
}
