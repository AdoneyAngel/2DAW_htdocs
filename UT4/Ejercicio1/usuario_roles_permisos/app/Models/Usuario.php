<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Usuario extends Model
{
    use HasFactory;
    protected $table = 'usuarios';
    public $timestamps = false;

    public function roles(): BelongsToMany {
        return $this->belongsToMany(Rol::class, "usuarios_roles", "id_usuario", "id_rol");
    }
}
