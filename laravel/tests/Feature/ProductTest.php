<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product\{Brand, Category, Product};

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private $user, $product, $product1, $product2, $brand, $category;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        $this->brand = Brand::factory()->create();
        $this->category = Category::factory()->create();
        $this->product = Product::factory()->for($this->brand)->for($this->category)->create();
        $this->product1 = Product::factory()->for($this->brand)->for($this->category)->make();
        $this->product2 = Product::factory()->for($this->brand)->for($this->category)->make(['name' => '']);
    }

    /**
     * A basic feature test example.
     */
    public function testIndex(): void
    {
        $this->withoutExceptionHandling();
        $response = $this
            ->actingAs($this->user)
            ->getJson(route('api.products.index'));

        $response->assertStatus(200);
        // $response->dd();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'slug',
                    'name',
                ]
            ]
        ]);
        /*
        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('data', 1)
                    ->has(
                        'data.0',
                        fn (AssertableJson $json) =>
                        $json->where('id', $this->product->id)
                            ->where('name', $this->product->name)
                            ->etc()
                    )
            );
        */
    }

    public function testStore(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->postJson(route('api.products.store'), $this->product1->toArray());

        $response->assertStatus(201)->assertJson(['name' => $this->product1->name]);
        $response->assertJsonIsObject();
        $response->assertJsonStructure(['name', 'slug']);
        $this->assertDatabaseHas('products', ['name' => $this->product1->name]);
    }

    public function testStoreWithValidationError(): void
    {
        $response = $this->postJson(route('api.products.store'), $this->product2->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name' => 'The name field is required.'], $responseKey = 'errors');
        $this->assertDatabaseMissing('products', ['name' => $this->product2->name]);
    }

    public function testShow(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson(route('api.products.show', $this->product));

        $response->assertStatus(200)->assertJson(['data' => ['name' => $this->product->name]]);
    }

    public function testUpdate(): void
    {
        $response = $this->putJson(route('api.products.update', $this->product), $this->product1->toArray());

        $response->assertJsonIsObject();
        $response->assertStatus(200)->assertJson(['name' => $this->product1->name]);
        $this->assertDatabaseHas('products', ['name' => $this->product1->name]);
    }

    public function testUpdateWithValidationError(): void
    {
        $response = $this->putJson(route('api.products.update', $this->product), $this->product2->toArray());

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('name', $responseKey = 'errors');
        $this->assertDatabaseMissing('products', ['name' => $this->product2->name]);
    }

    public function testDestroy(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->deleteJson(route('api.products.destroy', $this->product));

        // $response->assertStatus(204);
        $response->assertNoContent($status = 204);
        $this->assertDatabaseMissing('products', ['name' => $this->product->name]);
    }
}
