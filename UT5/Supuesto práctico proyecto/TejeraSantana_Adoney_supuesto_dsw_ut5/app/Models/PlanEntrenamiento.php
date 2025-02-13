<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanEntrenamiento extends Model
{
    /** @use HasFactory<\Database\Factories\PlanesEntrenamientoFactory> */
    use HasFactory;
    protected $table = 'planesentrenamiento';
    protected $primaryKey = "id_plan";
    protected $fillable = [
        "id_entrenador",
        "id_cliente",
        "nombre",
        "fecha_inicio",
        "fecha_fin"
    ];

    public function entrenador() {
        return $this->belongsTo(Usuario::class, "id_entrenador");
    }

    public function cliente() {
        return $this->belongsTo(Usuario::class, "id_cliente");
    }

    public function tablasEntrenamiento() {
        return $this->belongsToMany(TablaEntrenamiento::class, "planestablasentrenamiento", "id_plan", "id_tabla");
    }
}
