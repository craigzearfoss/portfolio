<?php

namespace App\Http\Resources\Portfolio;

use App\Http\Resources\CandidateResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SkillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this['id'],
            'name'         => $this['name'],
            'slug'         => $this['slug'],
            'version'      => $this['slug'],
            'featured'     => $this['featured'],
            'summary'      => $this['summary'],
            'type'         => !empty($this['type']) ? 'hard' : 'soft',
            'category'     => $this['category']['name'] ?? null,
            'level'        => $this['level'],
            'start_year'   => $this['start_year'],
            'end_year'     => $this['end_year'],
            'years'        => $this['years'],
            'link'         => $this['link'],
            'link_name'    => $this['link_name'],
            'description'  => $this['description'],
            'disclaimer'   => $this['disclaimer'],
            'image_credit' => $this['image_credit'],
            'image_source' => $this['image_source'],
            'thumbnail'    => $this['thumbnail'],
            'is_demo'      => $this['is_demo'],
            'created_at'   => longDateTime($this['created_at']),
            'updated_at'   => longDateTime($this['updated_at']),
            'candidate'    => new CandidateResource($this['owner']),
        ];
    }
}
