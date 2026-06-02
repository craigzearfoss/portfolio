<?php

namespace App\Http\Resources\Personal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RecipeCollection extends ResourceCollection
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
                'total_recipes' => $this->collection->count(),
                'status' => 'success',
            ],
            'links' => [
                'self' => url('/api/v1/personal/recipes'),
            ],
        ];
    }
}
