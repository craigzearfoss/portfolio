<?php

namespace App\Http\Resources\Portfolio;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class JobCoworkerCollection extends ResourceCollection
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
                'total_job_coworkers' => $this->collection->count(),
                'status' => 'success',
            ],
            'links' => [
                //'self' => url('/api/v1/portfolio/job-coworkers'),
            ],
        ];
    }
}
