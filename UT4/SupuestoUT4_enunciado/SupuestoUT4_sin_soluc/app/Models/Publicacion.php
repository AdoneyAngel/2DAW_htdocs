<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    use HasFactory;

    protected $table = "publicaciones";

    public function usuario() {
        return $this->belongsTo(Usuario::class, "Usuario_ID");
    }

    public function comentarios() {
        return $this->hasMany(Comentario::class, "Publicacion_ID");
    }
}
