<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Owner;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MusicUpdateRequest extends FormRequest
{
    use ModelPermissionsTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return isRootAdmin() || ($this->owner_id == Auth::guard('admin')->user()->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     * @throws \Exception
     */
    public function rules(): array
    {
        $this->checkDemoMode();

        // Generate the slug.
        if (!empty($this['name'])) {
            $this->merge([ 'slug' => Str::slug($this['name']
                . (!empty($this['artist']) ? '-by-' . $this['artist'] : ''))
            ]);
        }

        // Validate the admin_id. (Only root admins can change the admin for music.)
        if (!empty($this['admin_id']) && !Auth::guard('admin')->user()->root
            && ($this['admin_id'] == !Auth::guard('admin')->user()->id)
        ) {
            throw new \Exception('You are not authorized to change the admin for music.');
        }

        $maxYear = intval(date("Y")) + 1;

        return [
            'owner_id'      => ['integer', 'exists:core_db.admins,id'],
            'name'           => ['string', 'filled', 'max:255', 'unique:portfolio_db.music,name,'.$this->music->id],
            'artist'         => ['string', 'max:255', 'nullable'],
            'slug'           => [
                'string',
                'filled',
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
}
