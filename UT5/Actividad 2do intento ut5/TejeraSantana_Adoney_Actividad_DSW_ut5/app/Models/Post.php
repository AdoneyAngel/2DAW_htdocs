<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = "posts";

    protected $fillable = [
        "titulo",
        "cuerpo",
        "imagen",
        "usuario_id",
        "categoria_id"
    ];

    public function usuario() {
        return $this->belongsTo(Usuario::class, "usuario_id");
    }

    public function categoria() {
        return $this->belongsTo(Categoria::class, "categoria_id");
    }
}
