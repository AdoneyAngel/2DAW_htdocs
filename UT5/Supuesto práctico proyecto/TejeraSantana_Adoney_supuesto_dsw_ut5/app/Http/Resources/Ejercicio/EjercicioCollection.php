<?php

namespace App\Http\Resources\Ejercicio;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EjercicioCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return EjercicioResource::collection($this->collection);
    }
}
