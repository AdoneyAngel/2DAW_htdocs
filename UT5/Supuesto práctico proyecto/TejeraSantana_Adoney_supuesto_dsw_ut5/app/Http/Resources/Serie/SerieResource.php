<?php

namespace App\Http\Resources\Serie;

use App\Http\Resources\Ejercicio\EjercicioResource;
use App\Http\Resources\TablaEntrenamiento\TablaEntrenamientoResource;
use App\Http\Resources\TipoMusculo\TipoMusculoResource;
use App\Http\Resources\TipoSerie\TipoSerieResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SerieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "repeticiones_min" => $this->repeticiones_min,
            "repeticiones_max" => $this->repeticiones_max,
            "peso" => $this->peso,
            "duracion" => $this->duracion,
            "descanso" => $this->descanso,
            "ejercicio" => new EjercicioResource($this->whenLoaded("ejercicio")),
            "tabla" => new TablaEntrenamientoResource($this->whenLoaded("tablaEntrenamiento")),
            "tipo_serie" => new TipoSerieResource($this->whenLoaded("tipoSerie"))
        ];
    }
}
