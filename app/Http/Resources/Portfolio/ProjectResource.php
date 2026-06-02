<?php

namespace App\Http\Resources\Portfolio;

use App\Http\Resources\CandidateResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'name'             => $this['name'],
            'slug'             => $this['slug'],
            'featured'         => $this['featured'],
            'summary'          => $this['summary'],
            'project_year'     => $this['project_year'],
            'language'         => $this['language'],
            'language_version' => $this['language_version'],
            'repository_url'   => $this['repository_url'],
            'repository_name'  => $this['repository_name'],
            'link'             => $this['link'],
            'link_name'        => $this['link_name'],
            'description'      => $this['description'],
            'disclaimer'       => $this['disclaimer'],
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
