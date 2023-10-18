<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Product\Product;

class ProductImgController extends Controller
{
    public function __invoke(Product $product): Response
    {
        Storage::delete(config('settings.filepath.product') . $product->img);
        $product->update(['img' => null]);

        return response()->noContent();
    }
}
