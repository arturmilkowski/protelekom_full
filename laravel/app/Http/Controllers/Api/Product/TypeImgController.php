<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Product\{Product, Type};

class TypeImgController extends Controller
{
    public function __invoke(Product $product, Type $type): Response
    {
        Storage::delete(config('settings.filepath.type') . $type->img);
        $type->update(['img' => null]);

        return response()->noContent();
    }
}
