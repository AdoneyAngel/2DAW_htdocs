<?php

namespace App\Http\Resources\PlanNutricional;

use App\Http\Resources\Usuario\UsuarioResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanNutricionalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id_plan" => $this->id_plan_nutricional,
            "nombre" => $this->nombre,
            "recomendaciones_dieta" => $this->recomendaciones_dieta,
            "porcentaje_carbohidratos" => $this->porcentaje_carbohidratos,
            "porcentaje_proteinas" => $this->porcentaje_proteinas,
            "porcentaje_grasas" => $this->porcentaje_grasas,
            "porcentaje_fibra" => $this->porcentaje_fibra,
            "fecha_inicio" => $this->fecha_inicio,
            "fecha_fin" => $this->fecha_fin,
            "nutricionista" => new UsuarioResource($this->whenLoaded("nutricionista")),
            "cliente" => new UsuarioResource($this->whenLoaded("cliente"))
        ];
    }
}
