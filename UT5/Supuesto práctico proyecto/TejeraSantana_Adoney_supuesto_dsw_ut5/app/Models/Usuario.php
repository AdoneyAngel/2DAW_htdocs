<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UsuariosFactory> */
    use HasFactory, HasApiTokens, Notifiable;
    protected $table = 'usuarios';

    protected $primaryKey = "id_usuario";

    protected $fillable = [
        "email",
        "clave",
        "id_tipo_usuario"
    ];

    const CREATED_AT = 'fecha_registro';

    public function tipoUsuario() {
        return $this->belongsTo(TipoUsuario::class, "id_tipo_usuario");
    }
}
