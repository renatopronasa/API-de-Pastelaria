<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\PedidoCriado;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Produto;

class MailTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_pedido_criado()
    {
        Mail::fake();

        $cliente = Cliente::factory()->create();
        $produto = Produto::factory()->create();
        $pedido = Pedido::factory()->create(['cliente_id' => $cliente->id]);
        $pedido->produtos()->attach($produto->id, ['quantidade' => 2]);

        Mail::to($cliente->email)->send(new PedidoCriado($pedido));

        Mail::assertSent(PedidoCriado::class, function ($mail) use ($cliente) {
            return $mail->hasTo($cliente->email);
        });
    }
}
