<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $table = "comentarios";

    public function usuario() {
        return $this->belongsTo(Usuario::class, "Usuario_Comentario");
    }

    public function publicacion() {
        return $this->belongsTo(Publicacion::class, "Publicacion_ID");
    }
}
