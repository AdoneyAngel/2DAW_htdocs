<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "email" => $this->email,
            "tipo_usuario" => new TipoUsuarioResource($this->whenLoaded("tipoUsuario")),
            "fecha_registro" => $this->fecha_registro,
            // "suscripciones" => $this->suscripciones
        ];
    }
}
