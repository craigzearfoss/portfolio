<?php

namespace App\Http\Requests\Personal;

use App\Models\Owner;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ReadingUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return isRootAdmin() || ($this->reading->owner_id == Auth::guard('admin')->user()->id);
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
        if (!empty($this['title'])) {
            $this->merge([ 'slug' => Str::slug($this['title']
                . (!empty($this['author']) ? '-by-' . $this['author'] : ''))
            ]);
        }

        // Validate the admin_id. (Only root admins can change the admin for a reading.)
        if (!empty($this['admin_id']) && !Auth::guard('admin')->user()->root
            && ($this['admin_id'] == !Auth::guard('admin')->user()->id)
        ) {
            throw new \Exception('You are not authorized to change the admin for a reading.');
        }

        return [
            'owner_id'         => ['integer', 'filled', 'exists:core_db.admins,id'],
            'title'            => ['string', 'filled', 'max:255', 'unique:personal_db.readings,name,'.$this->reading->id],
            'author'           => ['string', 'max:255', 'nullable'],
            'slug'             => [
                'string',
                'filled',
                'max:255',
                Rule::unique('personal_db.readings')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('id', '<>', $this->reading->id)
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
            'image'            => ['string', 'max:500', 'nullable'],
            'image_credit'     => ['string', 'max:255', 'nullable'],
            'image_source'     => ['string', 'max:255', 'nullable'],
            'thumbnail'        => ['string', 'max:500', 'nullable'],
            'sequence'         => ['integer', 'min:0'],
            'public'           => ['integer', 'between:0,1'],
            'readonly'         => ['integer', 'between:0,1'],
            'root'             => ['integer', 'between:0,1'],
            'disabled'         => ['integer', 'between:0,1'],
        ];
    }
}
