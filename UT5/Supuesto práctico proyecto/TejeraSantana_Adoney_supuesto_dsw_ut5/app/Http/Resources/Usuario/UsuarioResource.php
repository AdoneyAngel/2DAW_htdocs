<?php

namespace App\Http\Resources\Usuario;

use App\Http\Resources\EstadisticaCliente\EstadisticaClienteCollection;
use App\Http\Resources\PerfilUsuario\PerfilUsuarioCollection;
use App\Http\Resources\Suscripcion\SuscripcionCollection;
use App\Http\Resources\TipoUsuario\TipoUsuarioResource;
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
            "suscripciones" => new SuscripcionCollection($this->whenLoaded("suscripciones")),
            "estadisticas" => new EstadisticaClienteCollection($this->whenLoaded("estadisticas")),
            "perfil" => new PerfilUsuarioCollection($this->whenLoaded("perfil"))
        ];
    }
}
