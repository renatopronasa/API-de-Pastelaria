<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cliente;

class PedidoFactory extends Factory
{
    protected $model = \App\Models\Pedido::class;

    public function definition()
    {
        return [
            'cliente_id' => Cliente::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
