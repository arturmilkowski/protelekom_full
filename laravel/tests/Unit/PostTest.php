<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Blog\Post;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testMakePost(): void
    {
        $post = Post::factory()->make();

        $this->assertInstanceOf(Post::class, $post);
    }

    public function testCreatePost(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();

        $this->assertDatabaseHas('posts', [
            'user_id' => $user->id,
            'slug' => $post->slug,
            'title' => $post->title,
            'intro' => $post->intro,
            'approved' => $post->approved,
            'published' => $post->published,
            'comments_allowed' => $post->comments_allowed,
        ]);
    }

    public function testPostBelongsToUser(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();

        $this->assertInstanceOf(User::class, $post->user);
    }
}
