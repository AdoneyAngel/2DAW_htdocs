<?php

namespace App\Http\Resources\TipoSerie;

use App\Http\Resources\Serie\SerieCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TipoSerieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id_tipo_serie" => $this->id_tipo_serie,
            "nombre" => $this->nombre,
            "descripcion" => $this->descripcion,
            "series" => new SerieCollection($this->whenLoaded("series"))
        ];
    }
}
