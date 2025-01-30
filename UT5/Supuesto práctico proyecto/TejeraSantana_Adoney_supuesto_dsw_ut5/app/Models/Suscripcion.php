<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suscripcion extends Model
{
    /** @use HasFactory<\Database\Factories\SuscripcionesFactory> */
    use HasFactory;
    protected $table = 'suscripciones';

    protected $primaryKey = "id_suscripcion";

    protected $fillable = [
        "id_cliente",
        "tipo_suscripcion",
        "precio",
        "dias",
        "fecha_inicio",
        "fecha_fin"
    ];

    public function cliente() {
        return $this->belongsTo(Usuario::class, "id_cliente");
    }
}
