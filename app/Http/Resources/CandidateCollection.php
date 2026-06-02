<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CandidateCollection extends ResourceCollection
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
                'total_candidates' => $this->collection->count(),
                'status' => 'success',
            ],
            'links' => [
                'self' => url('/api/v1/candidates'),
            ],
        ];
    }
}
