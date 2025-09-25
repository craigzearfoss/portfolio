<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MusicUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     * @throws \Exception
     */
    public function rules(): array
    {
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

        $adminIds = Auth::guard('admin')->user()->root
            ? Admin::all('id')->pluck('id')->toArray()
            : [Auth::guard('admin')->user()->id];

        return [
            'name'           => ['string', 'max:255', 'unique:portfolio_db.music,name,'.$this->music->id, 'filled'],
            'artist'         => ['string', 'max:255', 'nullable'],
            'slug'           => ['string', 'max:255', 'unique:portfolio_db.music,slug,'.$this->music->id, 'filled'],
            'professional'   => ['integer', 'between:0,1'],
            'personal'       => ['integer', 'between:0,1'],
            'featured'       => ['integer', 'between:0,1'],
            'collection'     => ['integer', 'between:0,1'],
            'track'          => ['integer', 'between:0,1'],
            'label'          => ['string', 'max:255', 'nullable'],
            'catalog_number' => ['string', 'max:50', 'nullable'],
            'year'           => ['integer', 'between:1900,'.date("Y"), 'nullable'],
            'release_date'   => ['date', 'nullable'],
            'embed'          => ['nullable'],
            'audio_url'      => ['string', 'url:http,https', 'max:255', 'nullable'],
            'link'           => ['string', 'url:http,https', 'max:255', 'nullable'],
            'link_name'      => ['string', 'nullable'],
            'description'    => ['nullable'],
            'image'          => ['string', 'max:255', 'nullable'],
            'image_credit'   => ['string', 'max:255', 'nullable'],
            'image_source'   => ['string', 'max:255', 'nullable'],
            'thumbnail'      => ['string', 'max:255', 'nullable'],
            'sequence'       => ['integer', 'min:0'],
            'public'         => ['integer', 'between:0,1'],
            'readonly'       => ['integer', 'between:0,1'],
            'root'           => ['integer', 'between:0,1'],
            'disabled'       => ['integer', 'between:0,1'],
            'admin_id'       => ['integer', Rule::in($adminIds)],
        ];
    }
}
