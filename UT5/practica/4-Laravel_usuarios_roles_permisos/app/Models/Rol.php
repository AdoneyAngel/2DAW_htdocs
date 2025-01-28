<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Rol extends Model
{
    protected $table = 'roles';

    public function usuarios() : BelongsToMany {
        return $this->belongsToMany(Usuario::class);
    }

    public function permisos() {
        // La nomenclatura es distinta por tanto debemos definir la tabla intermedia, y las claves de las tablas.
        return $this->belongsToMany(Permiso::class,'roles_permisos', 'id_rol', 'id_permiso');
    }
}
