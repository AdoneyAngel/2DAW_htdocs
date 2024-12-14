<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    protected $table = 'usuarios';
    public $timestamps = false;

    public function roles() {
        return $this->belongsToMany(Rol::class, "usuarios_roles", "id_usuario", "id_rol");
    }
}
