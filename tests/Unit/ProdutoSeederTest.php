<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\ProdutoSeeder;
use App\Models\Produto;

class ProdutoSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_produto_seeder()
    {
        $this->seed(ProdutoSeeder::class);

        $this->assertGreaterThan(0, Produto::count(), 'Nenhum produto foi criado pelo seeder.');

        $this->assertTrue(
            Produto::where('nome', 'Pastel de Carne')->exists(),
            'Produto "Pastel de Carne" não foi criado.'
        );

        $this->assertTrue(
            Produto::where('nome', 'Pastel de Queijo')->exists(),
            'Produto "Pastel de Queijo" não foi criado.'
        );
    }
}
