<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Blog\PostResource;
use App\Models\Blog\Post;
use App\Http\Requests\Blog\Post\PostRequest;
use App\Services\File;

class PostController extends Controller
{
    private $filepath = 'public/images/blog/';

    public function index(): AnonymousResourceCollection
    {
        return PostResource::collection(Post::latest()->get());
    }

    public function store(PostRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $file = $request->file('img');
        if ($file) {
            $extension = $file->extension();
            $filename = $validated['slug'] . '.' . $extension;
            File::store($request, $this->filepath, $filename);
            $validated['img'] = $filename;
        }

        $post = Post::create($validated);

        return response()->json($post, 201);
    }

    public function show(Post $post): PostResource
    {
        return new PostResource($post);
    }

    public function update(PostRequest $request, Post $post): JsonResponse
    {
        $validated = $request->validated();

        $file = $request->file('img');
        if ($file) {
            $extension = $file->extension();
            $filename = $validated['slug'] . '.' . $extension;
            $path = File::update($request, $post->img, $this->filepath, $filename);
            if ($path) {
                $validated['img'] = $filename; // assign new path
            }
        }
        $post->update($validated);

        return response()->json($post, 200);
    }

    public function destroy(Post $post): Response
    {
        if ($post->img) {
            Storage::delete($this->filepath . $post->img);
        }
        $post->delete();

        return response()->noContent();
    }
}
