<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Cliente;

class ClienteTest extends TestCase
{
    use RefreshDatabase;

    public function test_criar_cliente()
    {
        $cliente = Cliente::factory()->make();

        $response = $this->postJson('/api/clientes', $cliente->toArray());

        $response
        ->assertStatus(201)
        ->assertJsonFragment(['email' => $cliente->email]);

        $this->assertDatabaseHas('clientes', ['email' => $cliente->email]);
    }

    public function test_listar_clientes()
    {
        Cliente::factory()->count(3)->create();

        $response = $this->getJson('/api/clientes');

        $response
        ->assertStatus(200)
        ->assertJsonCount(3);
    }

    public function test_atualizar_cliente()
    {
        $cliente = Cliente::factory()->create();

        $response = $this->putJson("/api/clientes/{$cliente->id}", [
            'nome' => 'Nome Atualizado'
        ]);

        $response
        ->assertStatus(200)
        ->assertJsonFragment(['nome' => 'Nome Atualizado']);
    }

    public function test_deletar_cliente()
    {
        $cliente = Cliente::factory()->create();

        $response = $this->deleteJson("/api/clientes/{$cliente->id}");
        
        $response
        ->assertStatus(200)
        ->assertJson(['message' => 'Cliente removido com sucesso']);

        $this->assertSoftDeleted('clientes', ['id' => $cliente->id]);
    }
}
