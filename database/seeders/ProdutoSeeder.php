<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produto;

class ProdutoSeeder extends Seeder
{
    public function run(): void
    {
        $produtos = [
            [
                'nome' => 'Pastel de Carne',
                'preco' => 12.00,
                'foto' => 'https://picsum.photos/200/300',
            ],
            [
                'nome' => 'Pastel de Queijo',
                'preco' => 10.00,
                'foto' => 'https://picsum.photos/200/300',
            ],
            [
                'nome' => 'Pastel de Frango com Catupiry',
                'preco' => 12.00,
                'foto' => 'https://picsum.photos/200/300',
            ],
            [
                'nome' => 'Pastel de Palmito',
                'preco' => 12.00,
                'foto' => 'https://picsum.photos/200/300',
            ],
            [
                'nome' => 'Suco Natural',
                'preco' => 8.00,
                'foto' => 'https://picsum.photos/200/300',
            ],
            [
                'nome' => 'Refrigerante Lata',
                'preco' => 6.00,
                'foto' => 'https://picsum.photos/200/300',
            ],
        ];

        foreach ($produtos as $produto) {
            Produto::create($produto);
        }
    }
}
