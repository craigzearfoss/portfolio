<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Psy\Util\Json;

class UserResource extends JsonResource
{
    const NUM_PER_PAGE = 20;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int | string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }}
