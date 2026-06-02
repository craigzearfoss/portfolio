<?php

namespace App\Http\Resources\Portfolio;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AcademyResource extends JsonResource
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
            'name'            => $this['name'],
            'slug'            => $this['slug'],
            'primary'         => $this['primary'],
            'summary'         => $this['summary'],
            'street'          => $this['street'],
            'street2'         => $this['street2'],
            'city'            => $this['street'],
            'state'           => $this['state']['code'] ?? null,
            'zip'             => $this['zip'],
            'country'         => $this['country']['iso_alpha3'] ?? null,
            'latitude'        => $this['latitude'],
            'longitude'       => $this['longitude'],
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
            'image'           => $this['image'],
            'image_credit'    => $this['image_credit'],
            'image_source'    => $this['image_source'],
            'thumbnail'       => $this['thumbnail'],
            'logo'            => $this['logo'],
            'logo_small'      => $this['logo_small'],
            'created_at'      => longDateTime($this['created_at']),
            'updated_at'      => longDateTime($this['updated_at']),
        ];
    }
}
