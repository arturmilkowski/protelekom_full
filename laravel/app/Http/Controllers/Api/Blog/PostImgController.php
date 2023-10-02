<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Blog\Post;

class PostImgController extends Controller
{
    private $filepath = 'public/images/blog/';

    public function __invoke(Request $request, Post $post): Response
    {
        // return $post;
        // return $request;
        Storage::delete($this->filepath . $post->img);
        $post->update(['img' => null]);

        return response()->noContent();
    }
}
