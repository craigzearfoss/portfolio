<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidateResource extends JsonResource
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
            'username'          => $this['username'],
            'name'              => $this['name'],
            'label'             => $this['label'],
            'salutation'        => $this['salutation'],
            'title'             => $this['title'],
            'role'              => $this['role'],
            'employer'          => $this['employer'],
            'employment_status' => !empty($this['employmentStatus']) ? $this['employmentStatus']['name'] : null,
            'bio'               => $this['bio'],
            'link'              => $this['link'],
            'link_name'         => $this['link_name'],
            'image'             => $this['image'],
            'image_credit'      => $this['image_credit'],
            'image_source'      => $this['image_source'],
            'thumbnail'         => $this['thumbnail'],
            'logo'              => $this['logo'],
            'logo_small'        => $this['logo_small'],
            'created_at'        => longDateTime($this['created_at']),
            'updated_at'        => longDateTime($this['updated_at']),
        ];
    }
}
