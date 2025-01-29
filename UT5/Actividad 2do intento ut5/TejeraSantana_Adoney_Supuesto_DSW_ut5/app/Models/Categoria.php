<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = "categorias";

    protected $fillable = [
        "nombre",
        "descripcion"
    ];

    public function posts() {
        return $this->hasMany(Post::class, "categoria_id");
    }
}
