<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product\Brand;

class BrandTest extends TestCase
{
    use RefreshDatabase;

    private $user, $brand;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        $this->brand = Brand::factory()->create();
    }

    public function testIndex(): void
    {
        $this->withoutExceptionHandling();
        $response = $this
            ->actingAs($this->user)
            ->getJson(route('api.products.brands.index'));

        $response->assertStatus(200);
        //  $response->dd();
    }

    public function testStore(): void
    {
        $this->withoutExceptionHandling();
        $brand = Brand::factory()->make([]);
        $response = $this->postJson(route('api.products.brands.store'), $brand->toArray());

        $response->assertStatus(201)->assertJson(['name' => $brand->name]);
        $this->assertDatabaseHas('brands', ['name' => $brand->name]);
        // $response->dd();
    }

    public function testStoreWithValidationError(): void
    {
        $brand = Brand::factory()->make(['name' => '']);
        $response = $this->postJson(route('api.products.brands.store'), $brand->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name' => 'The name field is required.'], $responseKey = 'errors');
        $this->assertDatabaseMissing('brands', ['name' => $brand->title]);
    }

    public function testShow(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson(route('api.products.brands.show', $this->brand));

        $response->assertStatus(200)->assertJson(['data' => ['name' => $this->brand->name]]);
    }

    public function testUpdate(): void
    {
        $brand1 = Brand::factory()->make();
        $response = $this->putJson(route('api.products.brands.update', $this->brand), $brand1->toArray());

        $response->assertStatus(200)->assertJson(['name' => $brand1->name]);
        $this->assertDatabaseHas('brands', ['name' => $brand1->name]);
    }

    public function testUpdateWithValidationError(): void
    {
        $brand1 = Brand::factory()->make(['name' => '']);
        $response = $this->putJson(route('api.products.brands.update', $this->brand), $brand1->toArray());

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('name', $responseKey = 'errors');
        $this->assertDatabaseMissing('brands', ['name' => $brand1->name]);
    }

    public function testDestroy(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->deleteJson(route('api.products.brands.destroy', $this->brand));

        $response->assertStatus(204);
        $this->assertDatabaseMissing('brands', ['name' => $this->brand->name]);
    }
}
