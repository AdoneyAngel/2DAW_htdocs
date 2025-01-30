<?php

namespace App\Http\Resources\PlanEntrenamiento;

use App\Http\Resources\Usuario\UsuarioResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanEntrenamientoResource extends JsonResource
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
            "fecha_inicio" => $this->fecha_inicio,
            "fecha_fin" => $this->fecha_fin,
            "entrenador" => new UsuarioResource($this->whenLoaded("entrenador")),
            "cliente" => new UsuarioResource($this->whenLoaded("cliente"))
        ];
    }
}
