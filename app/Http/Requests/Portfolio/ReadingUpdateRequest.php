<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Admin;
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

        $adminIds = Auth::guard('admin')->user()->root
            ? Admin::all('id')->pluck('id')->toArray()
            : [Auth::guard('admin')->user()->id];

        return [
            'title'            => ['string', 'max:255', 'unique:portfolio_db.readings,name,'.$this->reading->id, 'filled'],
            'author'           => ['string', 'max:255', 'nullable'],
            'slug'             => ['string', 'max:255', 'unique:portfolio_db.readings,slug,'.$this->reading->id, 'filled'],
            'featured'         => ['integer', 'between:0,1'],
            'professional'     => ['integer', 'between:0,1'],
            'personal'         => ['integer', 'between:0,1'],
            'year'             => ['integer', 'between:-3000,'.date("Y"), 'nullable'],
            'publication_year' => ['integer', 'between:-3000,'.date("Y"), 'nullable'],
            'fiction'          => ['integer', 'between:0,1'],
            'nonfiction'       => ['integer', 'between:0,1'],
            'paper'            => ['integer', 'between:0,1'],
            'audio'            => ['integer', 'between:0,1'],
            'wishlist'         => ['wishlist', 'between:0,1'],
            'link'             => ['string', 'url:http,https', 'max:255', 'nullable'],
            'link_name'        => ['string', 'nullable'],
            'description'      => ['nullable'],
            'notes'            => ['nullable'],
            'image'            => ['string', 'max:255', 'nullable'],
            'image_credit'     => ['string', 'max:255', 'nullable'],
            'image_source'     => ['string', 'max:255', 'nullable'],
            'thumbnail'        => ['string', 'max:255', 'nullable'],
            'sequence'         => ['integer', 'min:0'],
            'public'           => ['integer', 'between:0,1'],
            'readonly'         => ['integer', 'between:0,1'],
            'root'             => ['integer', 'between:0,1'],
            'disabled'         => ['integer', 'between:0,1'],
            'admin_id'         => ['integer', Rule::in($adminIds)],
        ];
    }
}
