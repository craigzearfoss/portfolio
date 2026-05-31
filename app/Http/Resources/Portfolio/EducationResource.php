<?php

namespace App\Http\Resources\Portfolio;

use App\Http\Resources\CandidateResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EducationResource extends JsonResource
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
            'degree_type'        => $this['degreeType']['name'] ?? null,
            'major'              => $this['major'],
            'minor'              => $this['minor'],
            'school'             => !empty($this['school']) ? new SchoolResource($this['school']) : null,
            'slug'               => $this['slug'],
            'featured'           => $this['featured'],
            'summary'            => $this['summary'],
            'enrollment_date'    => $this['enrollment_date'],
            'graduated'          => $this['graduated'] ?? null,
            'graduation_date'    => $this['graduation_date'],
            'currently_enrolled' => $this['currently_enrolled'],
            'link'               => $this['link'],
            'link_name'          => $this['link_name'],
            'description'        => $this['description'],
            'disclaimer'         => $this['disclaimer'],
            'image_credit'       => $this['image_credit'],
            'image_source'       => $this['image_source'],
            'thumbnail'          => $this['thumbnail'],
            'is_demo'            => $this['is_demo'],
            'created_at'         => longDateTime($this['created_at']),
            'updated_at'         => longDateTime($this['updated_at']),
            'owner'              => new CandidateResource($this['owner']),
        ];
    }
}
