<?php

namespace App\Services;

use App\Models\Pedido;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\PedidoCriado;

class PedidoService
{
    public function criarPedido(array $data): Pedido
    {
        DB::beginTransaction();

        try {
            $pedido = Pedido::create([
                'cliente_id' => $data['cliente_id'],
            ]);

            $syncData = [];
            foreach ($data['produtos'] as $p) {
                $syncData[$p['produto_id']] = ['quantidade' => $p['quantidade']];
            }
            $pedido->produtos()->sync($syncData);

            Mail::to($pedido->cliente->email)->send(new PedidoCriado($pedido));

            DB::commit();

            return $pedido->load('produtos');

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function atualizarPedido(Pedido $pedido, array $data): Pedido
    {
        DB::beginTransaction();

        try {
            if (isset($data['cliente_id'])) {
                $pedido->update(['cliente_id' => $data['cliente_id']]);
            }

            if (isset($data['produtos'])) {
                $syncData = [];
                foreach ($data['produtos'] as $p) {
                    $syncData[$p['produto_id']] = ['quantidade' => $p['quantidade']];
                }
                $pedido->produtos()->sync($syncData);
            }

            DB::commit();

            return $pedido->load('produtos');

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
