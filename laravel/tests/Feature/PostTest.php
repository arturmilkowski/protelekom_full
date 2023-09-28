<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Blog\Post;

class PostTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    // json, getJson, postJson, putJson, patchJson, deleteJson
    public function testIndex(): void
    {
        $this->withoutExceptionHandling();
        $response = $this
            // ->actingAs($this->user)
            ->getJson(route('api.blog.posts.index'));
        // $response->dumpHeaders(); 
        // $response->dumpSession();
        // $response->dump();
        // $response->dd();
        $response->assertStatus(200);
    }

    public function testStore(): void
    {
        $this->withoutExceptionHandling();
        $post = Post::factory()->for($this->user)->make();
        $response = $this->postJson(route('api.blog.posts.store'), $post->toArray());

        $response->assertStatus(201)->assertJson(['title' => $post->title]);
        $this->assertDatabaseHas('posts', ['title' => $post->title]);
    }

    public function testStoreWithValidationError(): void
    {
        $post = Post::factory()->make(['title' => '']);
        $response = $this->postJson(route('api.blog.posts.store'), $post->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title' => 'The title field is required.'], $responseKey = 'errors');
        $this->assertDatabaseMissing('posts', ['title' => $post->title]);
    }

    public function testShow(): void
    {
        $this->withoutExceptionHandling();
        $post = Post::factory()->for($this->user)->create();
        $response = $this->getJson(route('api.blog.posts.show', $post));

        $response->assertStatus(200)->assertJson(['data' => ['title' => $post->title]]);
    }

    public function testUpdate(): void
    {
        $post = Post::factory()->for($this->user)->create();
        $post1 = Post::factory()->for($this->user)->make();
        $response = $this->putJson(route('api.blog.posts.update', $post), $post1->toArray());

        $response->assertStatus(200)->assertJson(['title' => $post1->title]);
        $this->assertDatabaseHas('posts', ['title' => $post1->title]);
    }

    public function testUpdateWithValidationError(): void
    {
        $post = Post::factory()->for($this->user)->create();
        $post1 = Post::factory()->for($this->user)->make(['title' => '']);
        $response = $this->putJson(route('api.blog.posts.update', $post), $post1->toArray());

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('title', $responseKey = 'errors');
        $this->assertDatabaseMissing('posts', ['title' => $post1->title]);
    }

    public function testDestroy(): void
    {
        $this->withoutExceptionHandling();
        $post = Post::factory()->for($this->user)->create();
        $response = $this->deleteJson(route('api.blog.posts.destroy', $post));

        $response->assertStatus(204);
        $this->assertDatabaseMissing('posts', ['title' => $post->title]);
    }
}
