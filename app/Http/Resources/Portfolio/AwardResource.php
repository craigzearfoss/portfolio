<?php

namespace App\Http\Resources\Portfolio;

use App\Http\Resources\CandidateResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AwardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this['id'],
            'name'           => $this['name'],
            'slug'           => $this['slug'],
            'featured'       => $this['featured'],
            'summary'        => $this['summary'],
            'category'       => $this['category'],
            'nominated_work' => $this['nominated_work'],
            'award_year'     => $this['award_year'],
            'received'       => $this['received'],
            'organization'   => $this['organization'],
            'link'           => $this['link'],
            'link_name'      => $this['link_name'],
            'description'    => $this['description'],
            'disclaimer'     => $this['disclaimer'],
            'image_credit'   => $this['image_credit'],
            'image_source'   => $this['image_source'],
            'thumbnail'      => $this['thumbnail'],
            'is_demo'        => $this['is_demo'],
            'created_at'     => longDateTime($this['created_at']),
            'updated_at'     => longDateTime($this['updated_at']),
            'candidate'      => new CandidateResource($this['owner']),
        ];
    }
}
