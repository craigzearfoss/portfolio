<?php

namespace App\Http\Resources\V1;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 *
 * @return array<int|string, mixed>
 */

/**
 * Transform the resource collection into an array.
 *
 * @return Collection|array
 */
class UserCollection extends ResourceCollection
{
    const int NUM_PER_PAGE = 20;

    public function toArray(Request $request): Collection|array
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
}
