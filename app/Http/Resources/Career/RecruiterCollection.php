<?php

namespace App\Http\Resources\Career;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RecruiterCollection extends ResourceCollection
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
                'total_recruiters' => $this->collection->count(),
                'status' => 'success',
            ],
            'links' => [
                'self' => url('/api/v1/career/recruiters'),
            ],
        ];
    }
}
