<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = "posts";

    public function usuario() {
        return $this->belongsTo(Usuario::class, "usuario_id");
    }

    public function categoria() {
        return $this->belongsTo(Categoria::class, "categoria_id");
    }
}
