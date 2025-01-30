<?php

namespace App\Http\Resources\TablaEntrenamiento;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TablaEntrenamientoCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return TablaEntrenamientoResource::collection($this->collection);
    }
}
