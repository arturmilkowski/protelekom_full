<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product\{Brand, Category, Product};

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private $product, $brand, $category;

    public function setUp(): void
    {
        parent::setUp();

        $this->brand = Brand::factory()->create();
        $this->category = Category::factory()->create();
        $this->product = Product::factory()->for($this->brand)->for($this->category)->create();
    }

    public function testMakeProduct(): void
    {
        $this->product = Product::factory()->make();

        $this->assertInstanceOf(Product::class, $this->product);
    }

    public function testCreateProduct(): void
    {
        $this->assertDatabaseHas('products', [
            'brand_id' => $this->brand->id,
            'category_id' => $this->category->id,
            'slug' => $this->product->slug,
            'name' => $this->product->name,
            'hide' => $this->product->hide,
        ]);
    }

    public function testProductBelongsToBrand(): void
    {
        $this->assertInstanceOf(Brand::class, $this->product->brand);
    }

    public function testProductBelongsToCategory(): void
    {
        $this->assertInstanceOf(Category::class, $this->product->category);
    }
}
