<?php

namespace App\Http\Resources\EstadisticaCliente;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EstadisticaClienteCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return EstadisticaClienteResource::collection($this->collection);
    }
}
