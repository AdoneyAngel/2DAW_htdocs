<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    use HasFactory;
    protected $table = 'series';
    protected $primaryKey = "id_serie";
    protected $fillable = [
        "repeticiones_min",
        "repeticiones_max",
        "peso",
        "duracion",
        "descanso",
        "id_ejercicio",
        "id_tabla",
        "id_tipo_serie",
    ];

    public function tipoSerie() {
        return $this->belongsTo(TipoSerie::class, "id_tipo_serie");
    }
    public function tablaEntrenamiento() {
        return $this->belongsTo(TablaEntrenamiento::class, "id_tabla");
    }
    public function ejercicio() {
        return $this->belongsTo(Ejercicio::class, "id_ejercicio");
    }
}
