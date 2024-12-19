<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = "pedidos";

    public function productos() {
        return $this->belongsToMany(Producto::class, "pedidos_productos", "pedido", "producto");
    }

    public function usuario() {
        return $this->belongsTo(Usuario::class, "usuario");
    }
}
