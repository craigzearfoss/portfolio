<?php

namespace App\Http\Requests\Personal;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReadingsRequest extends FormRequest
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
                'slug' => uniqueSlug($this['title'] . (!empty($this['author']) ? '-by-' . $this['author'] : '')),
                'personal_db.readings',
                $this->owner_id
            ]);
        }

        return [
            'owner_id'         => ['required', 'integer', 'exists:system_db.admins,id'],
            'title'            => ['required', 'string', 'max:255', 'unique:personal_db.readings,name'],
            'author'           => ['string', 'max:255', 'nullable'],
            'slug'             => [
                'required',
                'string',
                'max:255',
                Rule::unique('personal_db.readings')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('slug', $this->slug);
                })
            ],
            'featured'         => ['integer', 'between:0,1'],
            'summary'          => ['string', 'max:500', 'nullable'],
            'year'             => ['integer', 'between:-3000,'.date("Y"), 'nullable'],
            'publication_year' => ['integer', 'between:-3000,'.date("Y"), 'nullable'],
            'fiction'          => ['integer', 'between:0,1'],
            'nonfiction'       => ['integer', 'between:0,1'],
            'paper'            => ['integer', 'between:0,1'],
            'audio'            => ['integer', 'between:0,1'],
            'wishlist'         => ['wishlist', 'between:0,1'],
            'notes'            => ['nullable'],
            'link'             => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'        => ['string', 'max:255', 'nullable'],
            'description'      => ['nullable'],
            'disclaimer'       => ['string', 'max:500', 'nullable'],
            'image'            => ['string', 'max:500', 'nullable'],
            'image_credit'     => ['string', 'max:255', 'nullable'],
            'image_source'     => ['string', 'max:255', 'nullable'],
            'thumbnail'        => ['string', 'max:500', 'nullable'],
            'public'           => ['integer', 'between:0,1'],
            'readonly'         => ['integer', 'between:0,1'],
            'root'             => ['integer', 'between:0,1'],
            'disabled'         => ['integer', 'between:0,1'],
            'demo'             => ['integer', 'between:0,1'],
            'sequence'         => ['integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'owner_id.required' => 'Please select an owner for the reading.',
            'owner_id.exists'   => 'The specified owner does not exist.',
        ];
    }
}
