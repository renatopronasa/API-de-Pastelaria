<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\Produto;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RelacionamentosTest extends TestCase
{
    use RefreshDatabase;

    public function test_cliente_pode_ter_varios_pedidos()
{
    $cliente = \App\Models\Cliente::factory()->create();
    \App\Models\Pedido::factory()->count(3)->create(['cliente_id' => $cliente->id]);

    $cliente->load('pedidos'); 

    $this->assertCount(3, $cliente->pedidos);
    $this->assertInstanceOf(\App\Models\Pedido::class, $cliente->pedidos->first());
}


    public function test_pedido_tem_muitos_produtos()
    {
        $pedido = Pedido::factory()->create();
        $produtos = Produto::factory()->count(2)->create();

        $pedido->produtos()->attach($produtos->pluck('id'));

        $this->assertCount(2, $pedido->produtos);
        $this->assertInstanceOf(Produto::class, $pedido->produtos->first());
    }

    public function test_produto_pode_estar_em_varios_pedidos()
    {
        $produto = Produto::factory()->create();
        $pedidos = Pedido::factory()->count(3)->create();

        $produto->pedidos()->attach($pedidos->pluck('id'));

        $this->assertCount(3, $produto->pedidos);
        $this->assertInstanceOf(Pedido::class, $produto->pedidos->first());
    }
}
