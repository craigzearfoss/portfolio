<?php

namespace App\Http\Resources\Portfolio;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PhotographyCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'meta' => [
                'total_photographies' => $this->collection->count(),
                'status' => 'success',
            ],
            'links' => [
                'self' => url('/api/v1/portfolio/photographies'),
            ],
        ];
    }
}
