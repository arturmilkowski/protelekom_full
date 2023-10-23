<?php

namespace Database\Factories\Product;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product\Type>
 */
class TypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(3, true);
        $slug = $slug = Str::slug($name, '-');

        return [
            'slug' => $slug,
            'name' => $name,
            'price' => $this->faker->numberBetween(100, 10000),
            'promo_price' => $this->faker->numberBetween(100, 10000),
            'quantity' => $this->faker->numberBetween(0, 5),
            'hide' => $this->faker->numberBetween(0, 1),
            'description' => $this->faker->words(3, true),
            // 'img' => $this->faker->words(1, true),
        ];
    }
}
