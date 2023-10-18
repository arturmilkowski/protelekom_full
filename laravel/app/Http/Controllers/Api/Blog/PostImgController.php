<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Blog\Post;

class PostImgController extends Controller
{
    public function __invoke(Post $post): Response
    {
        Storage::delete(config('settings.filepath.blog') . $post->img);
        $post->update(['img' => null]);

        return response()->noContent();
    }
}
