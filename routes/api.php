<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\PedidoController;

Route::apiResource('clientes', ClienteController::class);
Route::apiResource('produtos', ProdutoController::class);
Route::apiResource('pedidos', PedidoController::class);