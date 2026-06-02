<?php

namespace App\Http\Resources\Portfolio;

use App\Http\Resources\CandidateResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicationResource extends JsonResource
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
            'title'             => $this['title'],
            'slug'              => $this['slug'],
            'featured'          => $this['featured'],
            'summary'           => $this['summary'],
            'publication_name'  => $this['publication_name'],
            'publisher'         => $this['publisher'],
            'publication_date'  => $this['publication_date'],
            'publication_year'  => $this['publication_year'],
            'credit'            => $this['credit'],
            'fiction'           => $this['fiction'],
            'nonfiction'        => $this['nonfiction'],
            'technical'         => $this['technical'],
            'research'          => $this['research'],
            'freelance'         => $this['freelance'],
            'online'            => $this['online'],
            'novel'             => $this['novel'],
            'book'              => $this['book'],
            'textbook'          => $this['textbook'],
            'story'             => $this['story'],
            'article'           => $this['article'],
            'paper'             => $this['paper'],
            'pamphlet'          => $this['pamphlet'],
            'poetry'            => $this['poetry'],
            'publication_url'   => $this['publication_url'],
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
            'created_at'        => longDateTime($this['created_at']),
            'updated_at'        => longDateTime($this['updated_at']),
            'candidate'         => new CandidateResource($this['owner']),
        ];
    }
}
