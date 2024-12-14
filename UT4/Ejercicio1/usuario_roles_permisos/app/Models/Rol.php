<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = "roles";
    public $timestamps = false;

    public function permisos() {
        return $this->belongsToMany(Permiso::class, "roles_permisos", "id_rol", "id_permiso");
    }
}
