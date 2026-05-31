<?php

namespace App\Http\Resources\Portfolio;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CertificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                 => $this['id'],
            'name'               => $this['name'],
            'slug'               => $this['slug'],
            'abbreviation'       => $this['abbreviation'],
            'certification_type' => $this['certificationType']['name'],
            'organization'       => $this['organization'],
            'link'               => $this['link'],
            'link_name'          => $this['link_name'],
            'description'        => $this['description'],
            'image'              => $this['image'],
            'image_credit'       => $this['image_credit'],
            'image_source'       => $this['image_source'],
            'thumbnail'          => $this['thumbnail'],
            'logo'               => $this['logo'],
            'logo_small'         => $this['logo_small'],
            'created_at'         => longDateTime($this['created_at']),
            'updated_at'         => longDateTime($this['updated_at']),
        ];
    }
}
