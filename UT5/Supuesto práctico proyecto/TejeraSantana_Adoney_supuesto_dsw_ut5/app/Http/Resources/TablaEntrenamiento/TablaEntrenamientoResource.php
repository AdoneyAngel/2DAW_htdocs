<?php

namespace App\Http\Resources\TablaEntrenamiento;

use App\Http\Resources\PlanEntrenamiento\PlanEntrenamientoCollection;
use App\Http\Resources\Serie\SerieCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TablaEntrenamientoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id_tabla" => $this->id_tabla,
            "semana" => $this->semana,
            "nombre" => $this->nombre,
            "num_series" => $this->num_series,
            "num_ejercicios" => $this->num_ejercicios,
            "num_dias" => $this->num_dias,
            "planes_entrenamiento" => new PlanEntrenamientoCollection($this->whenLoaded("planesEntrenamiento")),
            "series" => new SerieCollection($this->whenLoaded("series"))
        ];
    }
}
