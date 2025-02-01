<?php

namespace App\Http\Resources\Usuario;

use App\Http\Resources\Ejercicio\EjercicioCollection;
use App\Http\Resources\EstadisticaCliente\EstadisticaClienteCollection;
use App\Http\Resources\PerfilUsuario\PerfilUsuarioCollection;
use App\Http\Resources\PlanEntrenamiento\PlanEntrenamientoCollection;
use App\Http\Resources\Serie\SerieCollection;
use App\Http\Resources\Suscripcion\SuscripcionCollection;
use App\Http\Resources\TablaEntrenamiento\TablaEntrenamientoCollection;
use App\Http\Resources\TipoUsuario\TipoUsuarioResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id_usuario" => $this->id_usuario,
            "email" => $this->email,
            "tipo_usuario" => new TipoUsuarioResource($this->whenLoaded("tipoUsuario")),
            "fecha_registro" => $this->fecha_registro,
            "suscripciones" => new SuscripcionCollection($this->whenLoaded("suscripciones")),
            "estadisticas" => new EstadisticaClienteCollection($this->whenLoaded("estadisticas")),
            "perfil" => new PerfilUsuarioCollection($this->whenLoaded("perfil")),
            "planes_entrenamiento" => new PlanEntrenamientoCollection($this->whenLoaded("planesEntrenamiento")),
            "tablas_entrenamiento" => new TablaEntrenamientoCollection($this->tablasEntrenamiento()),
            "series" => new SerieCollection($this->ejercicios()),
            "ejercicios" => new EjercicioCollection($this->ejercicios())
        ];
    }
}
