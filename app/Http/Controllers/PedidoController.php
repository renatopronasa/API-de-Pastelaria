<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Services\PedidoService;

class PedidoController extends Controller
{
    protected $service;

    public function __construct(PedidoService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json(Pedido::with('produtos')->get());
    }

    public function show($id)
    {
        $pedido = Pedido::with('produtos')->findOrFail($id);
        return response()->json($pedido);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'produtos' => 'required|array|min:1',
            'produtos.*.produto_id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|integer|min:1',
        ]);

        $pedido = $this->service->criarPedido($validated);

        return response()->json($pedido, 201);
    }

    public function update(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        $validated = $request->validate([
            'cliente_id' => 'sometimes|required|exists:clientes,id',
            'produtos' => 'sometimes|array|min:1',
            'produtos.*.produto_id' => 'required_with:produtos|exists:produtos,id',
            'produtos.*.quantidade' => 'required_with:produtos|integer|min:1',
        ]);

        $pedido = $this->service->atualizarPedido($pedido, $validated);

        return response()->json($pedido);
    }

    public function destroy($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->delete();

        return response()->json(['message' => 'Pedido removido com sucesso']);
    }
}
