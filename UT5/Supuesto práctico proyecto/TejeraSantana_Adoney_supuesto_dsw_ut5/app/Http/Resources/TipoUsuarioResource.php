<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TipoUsuarioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "tipo_usuario" => $this->tipo_usuario,
            "descripcion" => $this->descripcion,
            "usuarios" => new UsuarioCollection($this->whenLoaded("usuarios"))
        ];
    }
}
