<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\Pedido;
use App\Mail\PedidoCriado;

class PedidoTest extends TestCase
{
    use RefreshDatabase;

    public function test_criar_pedido_envia_email()
    {
        Mail::fake();

        $cliente = Cliente::factory()->create();
        $produto = Produto::factory()->create();

        $response = $this->postJson('/api/pedidos', [
            'cliente_id' => $cliente->id,
            'produtos' => [
                ['produto_id' => $produto->id, 'quantidade' => 2]
            ]
        ]);

        $response
        
        ->assertStatus(201)
        ->assertJsonStructure(['id', 'cliente_id', 'produtos']);

        Mail::assertSent(PedidoCriado::class, function ($mail) use ($cliente) {
            return $mail->hasTo($cliente->email);
        });

        $this->assertDatabaseHas('pedidos', ['cliente_id' => $cliente->id]);
        $this->assertDatabaseHas('pedido_produto', ['produto_id' => $produto->id, 'quantidade' => 2]);
    }

    public function test_atualizar_pedido()
    {
        $pedido = Pedido::factory()->create();
        $produto = Produto::factory()->create();

        $response = $this->putJson("/api/pedidos/{$pedido->id}", [
            'produtos' => [
                ['produto_id' => $produto->id, 'quantidade' => 3]
            ]
        ]);

        $response
        ->assertStatus(200)
        ->assertJsonFragment(['produto_id' => $produto->id, 'quantidade' => 3]);
    }

    public function test_deletar_pedido()
    {
        $pedido = Pedido::factory()->create();

        $response = $this->deleteJson("/api/pedidos/{$pedido->id}");
        
        $response
        ->assertStatus(200)
        ->assertJson(['message' => 'Pedido removido com sucesso']);

        $this->assertSoftDeleted('pedidos', ['id' => $pedido->id]);
    }

    public function test_listar_pedidos()
    {
        Pedido::factory()->count(2)->create();

        $response = $this->getJson('/api/pedidos');
        
        $response
        ->assertStatus(200)
        ->assertJsonCount(2);
    }
}
