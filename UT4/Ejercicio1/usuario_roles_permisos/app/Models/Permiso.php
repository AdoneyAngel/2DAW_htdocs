<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = "permisos";
    public $timestamps = false;

    public function roles() {
        return $this->belongsToMany(Rol::class, "roles_permisos", "id_permiso", "id_rol");
    }
}
