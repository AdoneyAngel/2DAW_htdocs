<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = "usuarios";

    public function publicaciones() {
        return $this->hasMany(Publicacion::class, "Usuario_ID");
    }

    public function comentarios() {
        return $this->hasMany(Comentario::class, "Usuario_Comentario");
    }
}
