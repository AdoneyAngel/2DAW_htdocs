<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanNutricional extends Model
{
    /** @use HasFactory<\Database\Factories\PlanesNutricionalesFactory> */
    use HasFactory;
    protected $table = 'planesnutricionales';
    protected $primaryKey = "id_plan_nutricional";
    protected $fillable = [
        "id_nutricionista",
        "id_cliente",
        "nombre",
        "recomendaciones_dieta",
        "porcentaje_carbohidratos",
        "porcentaje_proteinas",
        "porcentaje_grasas",
        "porcentaje_fibra",
        "fecha_inicio",
        "fecha_fin",
    ];

    public function cliente() {
        return $this->belongsTo(Usuario::class, "id_cliente");
    }

    public function nutricionista() {
        return $this->belongsTo(Usuario::class, "id_nutricionista");
    }
}
