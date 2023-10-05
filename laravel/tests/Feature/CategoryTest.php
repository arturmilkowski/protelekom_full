<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product\Category;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    private $user, $category;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        $this->category = Category::factory()->create();
    }

    public function testIndex(): void
    {
        $this->withoutExceptionHandling();
        $response = $this
            ->actingAs($this->user)
            ->getJson(route('api.products.categories.index'));

        $response->assertStatus(200);
        // $response->assertJsonFragment(['name' => $this->category->name]);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'slug',
                    'name',
                ]
            ]
        ]);
        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('data', 1)
                    ->has(
                        'data.0',
                        fn (AssertableJson $json) =>
                        $json->where('id', $this->category->id)
                            ->where('name', $this->category->name)
                            ->etc()
                    )
            );
        // $response->dd();
    }

    public function testStore(): void
    {
        $this->withoutExceptionHandling();
        $category = Category::factory()->make([]);
        $response = $this->postJson(route('api.products.categories.store'), $category->toArray());

        $response->assertStatus(201)->assertJson(['name' => $category->name]);
        $response->assertJsonIsObject();
        $response->assertJsonStructure(['name', 'slug']);
        $this->assertDatabaseHas('categories', ['name' => $category->name]);
    }

    public function testStoreWithValidationError(): void
    {
        $category = Category::factory()->make(['name' => '']);
        $response = $this->postJson(route('api.products.categories.store'), $category->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name' => 'The name field is required.'], $responseKey = 'errors');
        $this->assertDatabaseMissing('categories', ['name' => $category->title]);
    }

    public function testShow(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson(route('api.products.categories.show', $this->category));

        $response->assertStatus(200)->assertJson(['data' => ['name' => $this->category->name]]);
        // $response->dd();
    }

    public function testUpdate(): void
    {
        $category1 = Category::factory()->make();
        $response = $this->putJson(route('api.products.categories.update', $this->category), $category1->toArray());

        $response->assertJsonIsObject();
        $response->assertStatus(200)->assertJson(['name' => $category1->name]);
        $this->assertDatabaseHas('categories', ['name' => $category1->name]);
    }

    public function testUpdateWithValidationError(): void
    {
        $category1 = Category::factory()->make(['name' => '']);
        $response = $this->putJson(route('api.products.categories.update', $this->category), $category1->toArray());

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('name', $responseKey = 'errors');
        $this->assertDatabaseMissing('categories', ['name' => $category1->name]);
    }

    public function testDestroy(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->deleteJson(route('api.products.categories.destroy', $this->category));

        // $response->assertStatus(204);
        $response->assertNoContent($status = 204);
        $this->assertDatabaseMissing('categories', ['name' => $this->category->name]);
    }
}
