<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "titulo" => $this->titulo,
            "cuerpo" => $this->cuerpo,
            "imagen" => $this->imagen,
            "usuario" => new UsuarioResource($this->whenLoaded("usuario")),
            "categoria" => new CategoriaResource($this->whenLoaded("categoria"))
        ];
    }
}
