<?php

namespace App\Http\Resources;

use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClienteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "nombre" => $this->nombre,
            "tipo" => $this->tipo,
            "email" => $this->email,
            "direccion" => $this->direccion,
            "ciudad" => $this->ciudad,
            "facturas" => FacturaResource::collection($this->facturas)
        ];
    }
}
