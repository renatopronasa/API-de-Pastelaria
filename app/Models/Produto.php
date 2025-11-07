<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nome', 'preco', 'foto'];

    public function pedidos()
    {
        return $this->belongsToMany(\App\Models\Pedido::class, 'pedido_produto')
                    ->withTimestamps();
    }
}
