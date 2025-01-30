<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EjercicioResource extends JsonResource
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
            "tipo_musculo" => new TipoMusculoResource($this->whenLoaded("tipoMusculo"))
        ];
    }
}
