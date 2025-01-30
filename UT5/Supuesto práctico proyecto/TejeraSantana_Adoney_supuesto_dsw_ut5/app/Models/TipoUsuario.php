<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
    /** @use HasFactory<\Database\Factories\TipoUsuarioFactory> */
    use HasFactory;
    protected $table = 'tipousuario';

    protected $primaryKey = "id_tipo_usuario";

    protected $fillable = [
        "tipo_usuario",
        "descripcion"
    ];

    public function usuarios() {
        return $this->hasMany(Usuario::class, "id_tipo_usuario");
    }
}
