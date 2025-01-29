<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellidos',
        'email'
    ];

    protected $table = "usuarios";

    public function posts() {
        return $this->hasMany(Post::class, "usuario_id");
    }
}
