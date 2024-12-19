<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $table = "productos_carrito";
    protected $fillable = [
        "unidades",
        "producto"
    ];

    public function producto() {
        return $this->belongsTo(Producto::class, "producto");
    }
}
