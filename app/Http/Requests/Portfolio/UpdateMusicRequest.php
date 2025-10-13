<?php

namespace App\Http\Requests\Portfolio;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMusicRequest extends FormRequest
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
        if (!empty($this['name'])) {
            $this->merge([
                'slug' => uniqueSlug(
                    $this['name'] . (!empty($this['artist']) ? '-by-' . $this['artist'] : ''),
                    'portfolio_db.music',
                    $this->owner_id
                )
            ]);
        }

        $maxYear = intval(date("Y")) + 1;

        return [
            'owner_id'       => ['filled', 'integer', 'exists:system_db.admins,id'],
            'name'           => ['filled', 'string', 'max:255', 'unique:portfolio_db.music,name,'.$this->music->id],
            'artist'         => ['string', 'max:255', 'nullable'],
            'slug'           => [
                'filled',
                'string',
                'max:255',
                Rule::unique('portfolio_db.music')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('id', '<>', $this->music->id)
                        ->where('slug', $this->slug);
                })
            ],
            'featured'       => ['integer', 'between:0,1'],
            'summary'        => ['string', 'max:500', 'nullable'],
            'collection'     => ['integer', 'between:0,1'],
            'track'          => ['integer', 'between:0,1'],
            'label'          => ['string', 'max:255', 'nullable'],
            'catalog_number' => ['string', 'max:50', 'nullable'],
            'year'           => ['integer', 'between:1900,'.$maxYear, 'nullable'],
            'release_date'   => ['date', 'nullable'],
            'embed'          => ['nullable'],
            'audio_url'      => ['string', 'max:500', 'nullable'],
            'notes'          => ['nullable'],
            'link'           => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'      => ['string', 'max:255', 'nullable'],
            'description'    => ['nullable'],
            'image'          => ['string', 'max:500', 'nullable'],
            'image_credit'   => ['string', 'max:255', 'nullable'],
            'image_source'   => ['string', 'max:255', 'nullable'],
            'thumbnail'      => ['string', 'max:500', 'nullable'],
            'sequence'       => ['integer', 'min:0'],
            'public'         => ['integer', 'between:0,1'],
            'readonly'       => ['integer', 'between:0,1'],
            'root'           => ['integer', 'between:0,1'],
            'disabled'       => ['integer', 'between:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'owner_id.filled' => 'Please select an owner for the music.',
            'owner_id.exists' => 'The specified owner does not exist.',
        ];
    }
}
