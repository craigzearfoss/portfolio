<?php

namespace App\Http\Resources\Portfolio;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MusicParentResource extends JsonResource
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
            'artist'         => $this['artist'],
            'slug'           => $this['slug'],
            'featured'       => $this['featured'],
            'summary'        => $this['summary'],
            'collection'     => $this['collection'],
            'track'          => $this['track'],
            'label'          => $this['label'],
            'catalog_number' => $this['catalog_number'],
            'music_year'     => $this['music_year'],
            'release_date'   => $this['release_date'],
            'embed'          => $this['embed'],
            'audio_url'      => $this['audio_url'],
            'link'           => $this['link'],
            'link_name'      => $this['link_name'],
            'description'    => $this['description'],
            'disclaimer'     => $this['disclaimer'],
            'image_credit'   => $this['image_credit'],
            'image_source'   => $this['image_source'],
            'thumbnail'      => $this['thumbnail'],
            'is_demo'        => $this['is_demo'],
            'parent'         => !empty($this['parent']) ? new MusicParentResource($this['parent']) : null,
            'created_at'     => longDateTime($this['created_at']),
            'updated_at'     => longDateTime($this['updated_at']),
        ];
    }
}
