<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ejercicio extends Model
{
    /** @use HasFactory<\Database\Factories\EjerciciosFactory> */
    use HasFactory;
    protected $table = 'ejercicios';
    protected $primaryKey = "id_ejercicio";
    protected $fillable = [
        "nombre",
        "descripcion",
        "id_tipo_musculo",
        "descripcion",
    ];

    public function tipoMusculo() {
        return $this->belongsTo(TipoMusculo::class, "id_tipo_musculo");
    }
}
