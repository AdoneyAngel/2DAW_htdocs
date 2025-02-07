<?php

namespace App\Http\Resources\EstadisticaEjercicio;

use App\Http\Resources\Ejercicio\EjercicioResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EstadisticaEjercicioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id_estadistica_ejercicio" => $this->id_estadistica,
            "num_sesiones" => $this->num_sesiones,
            "tiempo_total" => $this->tiempo_total,
            "duracion_media" => $this->duracion_media,
            "sets_completados" => $this->sets_completados,
            "volumen_total" => $this->volumen_total,
            "repeticiones_totales" => $this->repeticiones_totales,
            "fecha_entrenamiento" => $this->fecha_entrenamiento,
            "ejercicio" => new EjercicioResource($this->whenLoaded("ejercicio"))
        ];
    }
}
