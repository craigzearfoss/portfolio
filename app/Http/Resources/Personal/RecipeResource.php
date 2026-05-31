<?php

namespace App\Http\Resources\Personal;

use App\Http\Resources\CandidateResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this['id'],
            'name'         => $this['name'],
            'slug'         => $this['slug'],
            'featured'     => $this['featured'],
            'summary'      => $this['publication_year'],
            'source'       => $this['fiction'],
            'author'       => $this['nonfiction'],
            'prep_time'    => $this['prep_time'],
            'total_time'   => $this['total_time'],
            'main'         => $this['main'],
            'side'         => $this['side'],
            'dessert'      => $this['dessert'],
            'appetizer'    => $this['appetizer'],
            'beverage'     => $this['beverage'],
            'breakfast'    => $this['breakfast'],
            'lunch'        => $this['lunch'],
            'dinner'       => $this['dinner'],
            'snack'        => $this['snack'],
            'link'         => $this['link'],
            'link_name'    => $this['link_name'],
            'description'  => $this['description'],
            'disclaimer'   => $this['disclaimer'],
            'image_credit' => $this['image_credit'],
            'image_source' => $this['image_source'],
            'thumbnail'    => $this['thumbnail'],
            'is_demo'      => $this['is_demo'],
            'created_at'   => longDateTime($this['created_at']),
            'updated_at'   => longDateTime($this['updated_at']),
            'candidate'    => new CandidateResource($this['owner']),
        ];
    }
}
