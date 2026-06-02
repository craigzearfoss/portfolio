<?php

namespace App\Http\Resources\Portfolio;

use App\Http\Resources\CandidateResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AudioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this['id'],
            'name'              => $this['name'],
            'slug'              => $this['slug'],
            'featured'          => $this['featured'],
            'summary'           => $this['summary'],
            'full_episode'      => $this['full_episode'],
            'clip'              => $this['clip'],
            'podcast'           => $this['podcast'],
            'source_recording'  => $this['source_recording'],
            'audio_date'        => $this['audio_date'],
            'audio_year'        => $this['audio_year'],
            'company'           => $this['company'],
            'credit'            => $this['credit'],
            'show'              => $this['show'],
            'location'          => $this['location'],
            'embed'             => $this['embed'],
            'audio_url'         => $this['audio_url'],
            'review_link1'      => $this['review_link1'],
            'review_link1_name' => $this['review_link1_name'],
            'review_link2'      => $this['review_link2'],
            'review_link2_name' => $this['review_link2_name'],
            'review_link3'      => $this['review_link3'],
            'review_link3_name' => $this['review_link3_name'],
            'link'              => $this['link'],
            'link_name'         => $this['link_name'],
            'description'       => $this['description'],
            'disclaimer'        => $this['disclaimer'],
            'image_credit'      => $this['image_credit'],
            'image_source'      => $this['image_source'],
            'thumbnail'         => $this['thumbnail'],
            'is_demo'           => $this['is_demo'],
            'parent'            => !empty($this['parent']) ? new AudioResource($this['parent']) : null,
            'children'          => $children,
            'created_at'        => longDateTime($this['created_at']),
            'updated_at'        => longDateTime($this['updated_at']),
            'candidate'         => new CandidateResource($this['owner']),
        ];
    }
}
