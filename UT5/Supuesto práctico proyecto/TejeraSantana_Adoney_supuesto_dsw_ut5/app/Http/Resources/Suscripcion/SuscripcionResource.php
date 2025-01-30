<?php

namespace App\Http\Resources\Suscripcion;

use App\Http\Resources\Usuario\UsuarioResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuscripcionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "tipo_suscripcion" => $this->tipo_suscripcion,
            "precio" => $this->precio,
            "dias" => $this->dias,
            "fecha_inicio" => $this->fecha_inicio,
            "fecha_fin" => $this->fecha_fin,
            "cliente" => new UsuarioResource($this->whenLoaded("cliente"))
        ];
    }
}
