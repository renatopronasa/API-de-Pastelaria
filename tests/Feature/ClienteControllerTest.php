<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClienteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_criar_cliente()
    {
        $dados = [
            'nome' => 'Jorge Silva',
            'email' => 'jorge@email.com',
            'telefone' => '11999999999',
            'data_nascimento' => '1990-01-01',
            'endereco' => 'Rua A',
            'bairro' => 'Centro',
            'cep' => '10100-678',
        ];

        $response = $this->postJson('/api/clientes', $dados);

        $response->assertStatus(201)
                 ->assertJsonFragment(['email' => 'jorge@email.com']);
    }

    public function test_listar_clientes()
    {
        $this->withoutExceptionHandling();
        Cliente::factory()->count(3)->create();

        
        $response = $this->getJson('/api/clientes');
        

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_atualizar_cliente()
    {
        $cliente = Cliente::factory()->create();

        $response = $this->putJson("/api/clientes/{$cliente->id}", [
            'nome' => 'Nome Atualizado'
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['nome' => 'Nome Atualizado']);
    }

    public function test_deletar_cliente()
    {
        $cliente = Cliente::factory()->create();

        $response = $this->deleteJson("/api/clientes/{$cliente->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Cliente removido com sucesso']);

        $this->assertSoftDeleted('clientes', ['id' => $cliente->id]);
    }
}
