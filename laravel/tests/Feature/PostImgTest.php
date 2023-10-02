<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Blog\Post;

class PostImgTest extends TestCase
{
    use RefreshDatabase;

    public function testDestroy(): void
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $post = Post::factory()->for($user)->create();
        $response = $this->deleteJson(route('api.blog.posts.images.destroy', $post));

        $response->assertStatus(204);
        $this->assertDatabaseHas('posts', ['img' => null]);
    }
}
