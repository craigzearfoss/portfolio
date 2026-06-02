<?php

namespace App\Http\Resources\Portfolio;

use App\Http\Resources\CandidateResource;
use App\Models\Career\JobEmploymentType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this['id'],
            'company'             => $this['company'],
            'role'                => $this['role'],
            'slug'                => $this['slug'],
            'featured'            => $this['featured'],
            'summary'             => $this['summary'],
            'start_date'          => $this['start_date'],
            'end_date'            => $this['end_date'],
            'completion_date'     => $this['completion_date'],
            'job_employment_type' => $this['employmentType'] ?? null,
            'job_location_type'   => $this['locationType'] ?? null,
            'street'              => $this['street'],
            'street2'             => $this['street2'],
            'city'                => $this['street'],
            'state'               => $this['state']['code'] ?? null,
            'zip'                 => $this['zip'],
            'country'             => $this['country']['iso_alpha3'] ?? null,
            'latitude'            => $this['latitude'],
            'longitude'           => $this['longitude'],
            'link'                => $this['link'],
            'link_name'           => $this['link_name'],
            'description'         => $this['description'],
            'disclaimer'          => $this['disclaimer'],
            'image_credit'        => $this['image_credit'],
            'image_source'        => $this['image_source'],
            'thumbnail'           => $this['thumbnail'],
            'is_demo'             => $this['is_demo'],
            'coworkers'           => new JobCoworkerCollection($this['coworkers']),
            'tasks'               => new JobTaskCollection($this['tasks']),
            'skills'              => new JobSkillCollection($this['skills']),
            'created_at'          => longDateTime($this['created_at']),
            'updated_at'          => longDateTime($this['updated_at']),
            'owner'               => new CandidateResource($this['owner']),
        ];
    }
}
