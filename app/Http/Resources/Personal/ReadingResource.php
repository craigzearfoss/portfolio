<?php

namespace App\Http\Resources\Personal;

use App\Http\Resources\CandidateResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReadingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this['id'],
            'title'            => $this['title'],
            'author'           => $this['author'],
            'slug'             => $this['slug'],
            'featured'         => $this['featured'],
            'publication_year' => $this['publication_year'],
            'fiction'          => $this['fiction'],
            'nonfiction'       => $this['nonfiction'],
            'paper'            => $this['paper'],
            'audio'            => $this['audio'],
            'wishlist'         => $this['wishlist'],
            'link'             => $this['link'],
            'link_name'        => $this['link_name'],
            'description'      => $this['description'],
            'disclaimer'       => $this['disclaimer'],
            'image'            => $this['image'],
            'image_credit'     => $this['image_credit'],
            'image_source'     => $this['image_source'],
            'thumbnail'        => $this['thumbnail'],
            'is_demo'          => $this['is_demo'],
            'created_at'       => longDateTime($this['created_at']),
            'updated_at'       => longDateTime($this['updated_at']),
            'candidate'        => new CandidateResource($this['owner']),
        ];
    }
}
