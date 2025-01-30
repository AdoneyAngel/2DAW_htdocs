<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadisticaCliente extends Model
{
    /** @use HasFactory<\Database\Factories\EstadisticasClienteFactory> */
    use HasFactory;
    protected $table = 'estadisticascliente';
    protected $primaryKey = "id_estadistica_cliente";
    protected $fillable = [
        "peso",
        "altura",
        "grasa_corporal",
        "cintura",
        "pecho",
        "pierna",
        "biceps",
        "triceps",
        "id_cliente"
    ];

    public function cliente() {
        return $this->belongsTo(Usuario::class, "id_cliente");
    }
}
