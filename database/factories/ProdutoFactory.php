<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProdutoFactory extends Factory
{
    protected $model = \App\Models\Produto::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->word,
            'preco' => $this->faker->randomFloat(2, 1, 50),
            'foto' => $this->faker->imageUrl(400, 400, 'pastel', true),
        ];
    }
}
