<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TablaEntrenamiento extends Model
{
    /** @use HasFactory<\Database\Factories\TablasEntrenamientoFactory> */
    use HasFactory;
    protected $table = 'tablasentrenamiento';
    protected $primaryKey = "id_tabla";
    protected $fillable = [
        "semana",
        "nombre",
        "num_series",
        "num_ejercicios",
        "num_dias",
    ];

    public function planesEntrenamiento() {
        return $this->belongsToMany(PlanEntrenamiento::class, "planestablasentrenamiento", "id_tabla", "id_plan");
    }
}
