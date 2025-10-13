<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Portfolio\Publication;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePublicationsRequest extends FormRequest
{
    use ModelPermissionsTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->checkDemoMode();

        $this->checkOwner();

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     * @throws \Exception
     */
    public function rules(): array
    {
        // generate the slug
        if (!empty($this['title'])) {
            $this->merge([
                'slug' => uniqueSlug($this['title'], 'portfolio_db.publications', $this->owner_id)
            ]);
        }

        return [
            'owner_id'       => ['required', 'integer', 'exists:system_db.admins,id'],
            'title'           => [
                'required',
                'string',
                'max:255',
                Rule::unique('portfolio_db.publications')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('title', $this->title);
                })
            ],
            'slug'           => [
                'required',
                'string',
                'max:255',
                Rule::unique('portfolio_db.publications')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('slug', $this->slug);
                })
            ],
            'parent_id'      => [
                'integer',
                Rule::in(Publication::whereNot('id', $this->id)->get('id')->pluck('id')->toArray()),
                'nullable'
            ],
            'featured'          => ['integer', 'between:0,1'],
            'summary'           => ['string', 'max:500', 'nullable'],
            'publication_name'  => ['string', 'max:255', 'nullable'],
            'publisher'         => ['string', 'max:255', 'nullable'],
            'date'              => ['date', 'nullable'],
            'year'              => ['integer', 'between:1980,'.date("Y"), 'nullable'],
            'credit'            => ['nullable'],
            'freelance'         => ['integer', 'between:0,1'],
            'fiction'           => ['integer', 'between:0,1'],
            'nonfiction'        => ['integer', 'between:0,1'],
            'technical'         => ['integer', 'between:0,1'],
            'research'          => ['integer', 'between:0,1'],
            'poetry'            => ['integer', 'between:0,1'],
            'online'            => ['integer', 'between:0,1'],
            'novel'             => ['integer', 'between:0,1'],
            'book'              => ['integer', 'between:0,1'],
            'textbook'          => ['integer', 'between:0,1'],
            'story'             => ['integer', 'between:0,1'],
            'article'           => ['integer', 'between:0,1'],
            'paper'             => ['integer', 'between:0,1'],
            'pamphlet'          => ['integer', 'between:0,1'],
            'publication_url'   => ['string', 'max:500', 'nullable'],
            'review_link1'      => ['string', 'url:http,https', 'max:500', 'nullable'],
            'review_link1_name' => ['string', 'max:255', 'nullable'],
            'review_link2'      => ['string', 'url:http,https', 'max:500', 'nullable'],
            'review_link2_name' => ['string', 'max:255', 'nullable'],
            'review_link3'      => ['string', 'url:http,https', 'max:500', 'nullable'],
            'review_link3_name' => ['string', 'max:255', 'nullable'],
            'notes'             => ['nullable'],
            'link'              => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'         => ['string', 'max:255', 'nullable'],
            'description'       => ['nullable'],
            'image'             => ['string', 'max:500', 'nullable'],
            'image_credit'      => ['string', 'max:255', 'nullable'],
            'image_source'      => ['string', 'max:255', 'nullable'],
            'thumbnail'         => ['string', 'max:500', 'nullable'],
            'sequence'          => ['integer', 'min:0'],
            'public'            => ['integer', 'between:0,1'],
            'readonly'          => ['integer', 'between:0,1'],
            'root'              => ['integer', 'between:0,1'],
            'disabled'          => ['integer', 'between:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'owner_id.required' => 'Please select an owner for the publication.',
            'owner_id.exists'   => 'The specified owner does not exist.',
        ];
    }
}
