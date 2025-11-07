<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    protected $model = \App\Models\Cliente::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'telefone' => $this->faker->phoneNumber,
            'data_nascimento' => $this->faker->date('Y-m-d', '1990-07-10'),
            'endereco' => $this->faker->streetAddress,
            'complemento' => $this->faker->secondaryAddress,
            'bairro' => $this->faker->citySuffix,
            'cep' => $this->faker->postcode,
            'data_de_cadastro' => now(),
        ];
    }
}
