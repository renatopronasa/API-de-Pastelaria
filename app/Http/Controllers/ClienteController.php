<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    public function index()
    {
        return response()->json(Cliente::all());
    }
    public function show($id)
    {
        $cliente = Cliente::findOrFail($id);
        return response()->json($cliente);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes',
            'telefone' => 'required|string|max:20',
            'data_nascimento' => 'required|date',
            'endereco' => 'required|string|max:255',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'required|string|max:255',
            'cep' => 'required|string|max:10',
            'data_de_cadastro' => 'nullable|date',
        ]);

        $cliente = Cliente::create($validated);
        return response()->json($cliente, 201);
    }
    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'string|max:255',
            'email' => 'email|unique:clientes,email,' . $id,
            'telefone' => 'string|max:20',
            'data_nascimento' => 'date',
            'endereco' => 'string|max:255',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'string|max:255',
            'cep' => 'string|max:10',
            'data_de_cadastro' => 'nullable|date',

        ]);

        $cliente->update($validated);
        return response()->json($cliente);
    }
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return response()->json(['message' => 'Cliente removido com sucesso']);
    }
}
