<?php

namespace App\Http\Resources\TipoUsuario;

use App\Http\Resources\Usuario\UsuarioCollection;
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
            "id_tipo_usuario" => $this->id_tipo_usuario,
            "tipo_usuario" => $this->tipo_usuario,
            "descripcion" => $this->descripcion,
            "usuarios" => new UsuarioCollection($this->whenLoaded("usuarios"))
        ];
    }
}
