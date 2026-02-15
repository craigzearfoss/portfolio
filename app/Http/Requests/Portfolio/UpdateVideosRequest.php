<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Portfolio\Video;
use App\Traits\ModelPermissionsTrait;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVideosRequest extends FormRequest
{
    use ModelPermissionsTrait;

    private mixed $owner_id;
    private mixed $name;
    private mixed $video;
    private mixed $id;

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
     * @return array<string, ValidationRule|array|string>
     * @throws Exception
     */
    public function rules(): array
    {
        return [
            'owner_id'          => ['filled', 'integer', 'exists:system_db.admins,id'],
            'name'              => [
                'filled',
                'string',
                'max:255',
                Rule::unique('portfolio_db.videos', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('name', $this->name)
                        ->whereNot('id', $this->video->id);
                })
            ],
            'slug'              => [
                'filled',
                'string',
                'max:255',
                Rule::unique('portfolio_db.videos', 'slug')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('slug', $this->slug)
                        ->whereNot('id', $this->video->id);
                })
            ],
            'parent_id'         => [
                'integer',
                Rule::in(new Video()->whereNot('id', $this->id)->get('id')->pluck('id')->toArray()),
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
            'video_url'         => ['string', 'max:500', 'nullable'],
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
            'public'            => ['integer', 'between:0,1'],
            'readonly'          => ['integer', 'between:0,1'],
            'root'              => ['integer', 'between:0,1'],
            'disabled'          => ['integer', 'between:0,1'],
            'demo'              => ['integer', 'between:0,1'],
            'sequence'          => ['integer', 'min:0', 'nullable'],
        ];
    }

    /**
     * Return error messages.
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'owner_id.filled' => 'Please select an owner for the video.',
            'owner_id.exists' => 'The specified owner does not exist.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation()
    {
        // generate the slug
        if (!empty($this['name'])) {
            $this->merge([
                'slug' => uniqueSlug($this['name'], 'portfolio_db.videos', $this->owner_id)
            ]);
        }
    }
}
