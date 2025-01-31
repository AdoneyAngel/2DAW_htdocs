<?php

namespace App\Http\Resources\Serie;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SerieCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return SerieResource::collection($this->collection);
    }
}
