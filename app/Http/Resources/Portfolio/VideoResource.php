<?php

namespace App\Http\Resources\Portfolio;

use App\Http\Resources\CandidateResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $children = $this['children'];
        foreach ($this['children'] as $child) {
            $children[] = new VideoChildResource($child);
        }

        return [
            'id'                => $this['id'],
            'name'              => $this['name'],
            'slug'              => $this['slug'],
            'featured'          => $this['featured'],
            'summary'           => $this['summary'],
            'full_episode'      => $this['full_episode'],
            'clip'              => $this['clip'],
            'public_access'     => $this['public_access'],
            'source_recording'  => $this['source_recording'],
            'video_date'        => $this['video_date'],
            'video_year'        => $this['video_year'],
            'company'           => $this['company'],
            'credit'            => $this['credit'],
            'show'              => $this['show'],
            'location'          => $this['location'],
            'embed'             => $this['embed'],
            'video_url'         => $this['video_url'],
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
            'parent'            => !empty($this['parent']) ? new MusicParentResource($this['parent']) : null,
            'children'          => $children,
            'created_at'        => longDateTime($this['created_at']),
            'updated_at'        => longDateTime($this['updated_at']),
            'candidate'         => new CandidateResource($this['owner']),
        ];
    }
}
