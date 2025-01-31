<?php

namespace App\Http\Resources\PerfilUsuario;

use App\Http\Resources\Suscripcion\SuscripcionCollection;
use App\Http\Resources\Usuario\UsuarioResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PerfilUsuarioResource extends JsonResource
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
            "apellido1" => $this->apellido1,
            "apellido2" => $this->apellido2,
            "edad" => $this->edad,
            "direccion" => $this->direccion,
            "telefono" => $this->direccion,
            "foto" => $this->foto,
            "fecha_nacimiento" => $this->fecha_nacimiento,
            "usuario" => new UsuarioResource($this->whenLoaded("usuario"))
        ];
    }
}
