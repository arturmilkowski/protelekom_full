<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\Product\ConditionResource;
use App\Http\Requests\Product\ConditionRequest;
use App\Models\Product\Condition;

class ConditionController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ConditionResource::collection(
            Cache::rememberForever(
                'conditions',
                function () {
                    return Condition::latest()->get();
                }
            )
        );
    }

    public function store(ConditionRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $condition = Condition::create($validated);

        return response()->json($condition, 201);
    }

    public function show(Condition $condition): ConditionResource
    {
        return new ConditionResource($condition);
    }

    public function update(ConditionRequest $request, Condition $condition): JsonResponse
    {
        $validated = $request->validated();
        $condition->update($validated);

        return response()->json($condition, 200);
    }

    public function destroy(Condition $condition): Response
    {
        $condition->delete();

        return response()->noContent();
    }
}
