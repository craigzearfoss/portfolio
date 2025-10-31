<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Portfolio\Audio;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAudiosRequest extends FormRequest
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
                'slug' => uniqueSlug($this['name'], 'portfolio_db.audios', $this->owner_id)
            ]);
        }

        return [
            'owner_id'          => ['filled', 'integer', 'exists:system_db.admins,id'],
            'name'              => [
                'filled',
                'string',
                'max:255',
                Rule::unique('portfolio_db.audios')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('id', '<>', $this->audio->id)
                        ->where('name', $this->name);
                })
            ],
            'slug'              => [
                'filled',
                'string',
                'max:255',
                Rule::unique('portfolio_db.audios')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('id', '<>', $this->audio->id)
                        ->where('slug', $this->slug);
                })
            ],
            'parent_id'         => [
                'integer',
                Rule::in(Audio::whereNot('id', $this->id)->get('id')->pluck('id')->toArray()),
                'nullable'
            ],
            'featured'          => ['integer', 'between:0,1'],
            'summary'           => ['string', 'max:500', 'nullable'],
            'full_episode'      => ['integer', 'between:0,1'],
            'clip'              => ['integer', 'between:0,1'],
            'public_access'     => ['integer', 'between:0,1'],
            'source_recording'  => ['integer', 'between:0,1'],
            'date'              => ['date', 'nullable'],
            'year'              => ['integer', 'between:1980,'.date("Y"), 'nullable'],
            'company'           => ['string', 'max:255', 'nullable'],
            'credit'            => ['nullable'],
            'show'              => ['string', 'max:255', 'nullable'],
            'location'          => ['string', 'max:255', 'nullable'],
            'embed'             => ['nullable'],
            'audio_url'         => ['string', 'max:500', 'nullable'],
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
            'disclaimer'        => ['string', 'max:500', 'nullable'],
            'image'             => ['string', 'max:500', 'nullable'],
            'image_credit'      => ['string', 'max:255', 'nullable'],
            'image_source'      => ['string', 'max:255', 'nullable'],
            'thumbnail'         => ['string', 'max:500', 'nullable'],
            'sequence'          => ['integer', 'min:0'],
            'public'            => ['integer', 'between:0,1'],
            'readonly'          => ['integer', 'between:0,1'],
            'root'              => ['integer', 'between:0,1'],
            'disabled'          => ['integer', 'between:0,1'],
            'demo'              => ['integer', 'between:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'owner_id.filled' => 'Please select an owner for the audio.',
            'owner_id.exists' => 'The specified owner does not exist.',
        ];
    }
}
