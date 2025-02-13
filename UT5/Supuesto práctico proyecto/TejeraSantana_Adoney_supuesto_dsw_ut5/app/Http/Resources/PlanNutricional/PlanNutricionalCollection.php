<?php

namespace App\Http\Resources\PlanNutricional;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PlanNutricionalCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return PlanNutricionalResource::collection($this->collection);
    }
}
