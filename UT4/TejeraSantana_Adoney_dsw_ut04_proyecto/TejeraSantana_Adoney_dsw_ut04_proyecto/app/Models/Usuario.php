<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = "usuarios";

    public function productosCarrito() {
        return $this->hasMany(Carrito::class, "usuario");
    }

    public function pedidos() {
        return $this->hasMany(Pedido::class, "usuario");
    }
}
