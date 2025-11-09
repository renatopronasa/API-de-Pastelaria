<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name'  => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 1, 50),
            'photo' => $this->faker->imageUrl(400, 400, 'pastel', true),
            'type'  => $this->faker->randomElement(['Savory', 'Drink']),
        ];
    }
}
