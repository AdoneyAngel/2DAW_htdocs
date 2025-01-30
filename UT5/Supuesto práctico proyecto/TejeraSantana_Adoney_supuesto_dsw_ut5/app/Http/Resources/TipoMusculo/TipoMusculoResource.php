<?php

namespace App\Http\Resources\TipoMusculo;

use App\Http\Resources\Ejercicio\EjercicioCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TipoMusculoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "nombre" => $this->nombre,
            "descripcion" => $this->descripcion,
            "ejercicios" => new EjercicioCollection($this->whenLoaded("ejercicios"))
        ];
    }
}
