<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\Cliente;
use Illuminate\Support\Facades\Mail;
use App\Mail\PedidoCriado;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PedidoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_criar_pedido_envia_email()
    {
        Mail::fake();

        $cliente = Cliente::factory()->create();
        $produtos = Produto::factory()->count(2)->create();

        $response = $this->postJson('/api/pedidos', [
            'cliente_id' => $cliente->id,
            'produtos' => [
                ['produto_id' => $produtos[0]->id, 'quantidade' => 2],
                ['produto_id' => $produtos[1]->id, 'quantidade' => 1],
            ]
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['cliente_id' => $cliente->id]);

        Mail::assertSent(PedidoCriado::class, function ($mail) use ($cliente) {
            return $mail->hasTo($cliente->email);
        });
    }

    public function test_listar_pedidos()
    {
        $pedidos = Pedido::factory()->count(3)->create();

        $response = $this->getJson('/api/pedidos');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_atualizar_pedido()
    {
        $pedido = Pedido::factory()->create();

        $response = $this->putJson("/api/pedidos/{$pedido->id}", [
            'cliente_id' => $pedido->cliente_id
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $pedido->id]);
    }

    public function test_deletar_pedido()
    {
        $pedido = Pedido::factory()->create();

        $response = $this->deleteJson("/api/pedidos/{$pedido->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Pedido removido com sucesso']);

        $this->assertSoftDeleted('pedidos', ['id' => $pedido->id]);
    }
}
