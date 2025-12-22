<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CompanyCollection extends ResourceCollection
{
    const NUM_PER_PAGE = 20;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    /*
    public function toArray(Request $request): array
    {
        if ($request->has('list')) {
            return $this->collection;
        } else {
            return [
                'data' => $this->collection,
                'links' => [
                    'self' => 'link-value',
                ],
            ];
        }
    }
    */
}
