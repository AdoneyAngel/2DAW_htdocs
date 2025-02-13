<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = "productos";

    public function categoria() {
        return $this->belongsTo(Categoria::class);
    }

    public static function exist($id) {
        $producto = self::find($id);

        if ($producto) {
            return true;

        } else {
            return false;
        }
    }
}
