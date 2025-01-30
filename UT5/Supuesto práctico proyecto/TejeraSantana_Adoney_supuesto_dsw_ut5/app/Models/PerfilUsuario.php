<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilUsuario extends Model
{
    /** @use HasFactory<\Database\Factories\PerfilesUsuarioFactory> */
    use HasFactory;
    protected $table = 'perfilesusuario';
    protected $primaryKey = "id_perfil";
    protected $fillable = [
        "nombre",
        "apellido1",
        "apellido2",
        "edad",
        "direccion",
        "telefono",
        "foto",
        "fecha_nacimiento",
        "id_usuario"
    ];

    public function usuario() {
        return $this->belongsTo(Usuario::class, "id_usuario");
    }
}
