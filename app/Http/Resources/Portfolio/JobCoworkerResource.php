<?php

namespace App\Http\Resources\Portfolio;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobCoworkerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this['id'],
            'owner_id'        => $this['owner_id'],
            'job_id'          => $this['job_id'],
            'name'            => $this['name'],
            'title'           => $this['title'],
            'featured'        => $this['featured'],
            'summary'         => $this['summary'],
            'level'           => $this['level']['name'] ?? null,
            'phone'           => $this['phone'],
            'phone_label'     => $this['phone_label'],
            'alt_phone'       => $this['alt_phone'],
            'alt_phone_label' => $this['alt_phone_label'],
            'email'           => $this['email'],
            'email_label'     => $this['email_label'],
            'alt_email'       => $this['alt_email'],
            'alt_email_label' => $this['alt_email_label'],
            'link'            => $this['link'],
            'link_name'       => $this['link_name'],
            'description'     => $this['description'],
            'disclaimer'      => $this['disclaimer'],
            'image_credit'    => $this['image_credit'],
            'image_source'    => $this['image_source'],
            'thumbnail'       => $this['thumbnail'],
            'is_demo'         => $this['is_demo'],
            'created_at'      => longDateTime($this['created_at']),
            'updated_at'      => longDateTime($this['updated_at']),
        ];
    }
}
