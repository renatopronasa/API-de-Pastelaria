<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Produto;

class ProdutoTest extends TestCase
{
    use RefreshDatabase;

    public function test_criar_produto()
    {
        $produto = Produto::factory()->make();

        $response = $this->postJson('/api/produtos', $produto->toArray());

        $response
        ->assertStatus(201)
        ->assertJsonFragment(['nome' => $produto->nome]);

        $this->assertDatabaseHas('produtos', ['nome' => $produto->nome]);
    }

    public function test_listar_produtos()
    {
        Produto::factory()->count(3)->create();

        $response = $this->getJson('/api/produtos');
        
        $response
        ->assertStatus(200)
        ->assertJsonCount(3);
    }

    public function test_atualizar_produto()
    {
        $produto = Produto::factory()->create();

        $response = $this->putJson("/api/produtos/{$produto->id}", [
        'nome' => 'Produto Atualizado'
        ]);

        $response
        ->assertStatus(200)
        ->assertJsonFragment(['nome' => 'Produto Atualizado']);
    }

    public function test_deletar_produto()
    {
        $produto = Produto::factory()->create();

        $response = $this->deleteJson("/api/produtos/{$produto->id}");
        
        $response
        ->assertStatus(200)
        ->assertJson(['message' => 'Produto removido com sucesso']);

        $this->assertSoftDeleted('produtos', ['id' => $produto->id]);
    }
}
