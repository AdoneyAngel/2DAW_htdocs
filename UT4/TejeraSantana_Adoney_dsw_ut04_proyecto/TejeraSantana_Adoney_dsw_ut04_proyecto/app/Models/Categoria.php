<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $table = 'categorias';

    public function productos() {
        return $this->hasMany(Producto::class, "categoria");
    }

    public static function exist(int $id) {
        $categoria = self::find($id);

        if ($categoria) {
            return true;
        }

        return false;
    }
}
