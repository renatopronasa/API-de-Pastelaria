<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Produto;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProdutoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_criar_produto()
    {
        $dados = [
            'nome' => 'Pastel de Frango',
            'preco' => 12.50,
            'foto' => 'https://picsum.photos/200/300',
        ];

        $response = $this->postJson('/api/produtos', $dados);

        $response->assertStatus(201)
                 ->assertJsonFragment(['nome' => 'Pastel de Queijo']);
    }

    public function test_listar_produtos()
    {
        Produto::factory()->count(3)->create();

        $response = $this->getJson('/api/produtos');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_atualizar_produto()
    {
        $produto = Produto::factory()->create();

        $response = $this->putJson("/api/produtos/{$produto->id}", [
            'nome' => 'Pastel Atualizado'
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['nome' => 'Pastel Atualizado']);
    }

    public function test_deletar_produto()
    {
        $produto = Produto::factory()->create();

        $response = $this->deleteJson("/api/produtos/{$produto->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Produto removido com sucesso']);

        $this->assertSoftDeleted('produtos', ['id' => $produto->id]);
    }
}
