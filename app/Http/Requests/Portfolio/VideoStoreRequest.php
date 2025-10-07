<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Owner;
use App\Models\Portfolio\Video;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class VideoStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
        // Generate the slug.
        if (!empty($this['name'])) {
            $this->merge([ 'slug' => Str::slug($this['name']) ]);
        }

        // Validate the owner_id. (Only root admins can add a video for another admin.)
        if (empty($this['owner_id'])) {
            $this->merge(['owner_id' => Auth::guard('admin')->user()->id]);
        }
        if (!isRootAdmin() && ($this->owner_id !== Auth::guard('admin')->user()->id)) {
            throw ValidationException::withMessages([
                'name' => 'You are not authorized to add a video for this admin.'
            ]);
        }

        return [
            'owner_id'       => ['integer', 'exists:core_db.admins,id'],
            'name'           => [
                'string',
                'required',
                'max:255',
                Rule::unique('portfolio_db.videos')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('name', $this->name);
                })
            ],
            'slug'           => [
                'string',
                'required',
                'max:255',
                Rule::unique('portfolio_db.videos')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('slug', $this->slug);
                })
            ],
            'parent_id'      => [
                'integer',
                Rule::in(Video::whereNot('id', $this->id)->get('id')->pluck('id')->toArray()),
                'nullable'
            ],
            'featured'       => ['integer', 'between:0,1'],
            'summary'        => ['string', 'max:500', 'nullable'],
            'full_episode'   => ['integer', 'between:0,1'],
            'clip'           => ['integer', 'between:0,1'],
            'public_access'  => ['integer', 'between:0,1'],
            'source_footage' => ['integer', 'between:0,1'],
            'date'           => ['date', 'nullable'],
            'year'           => ['integer', 'between:1980,'.date("Y"), 'nullable'],
            'company'        => ['string', 'max:255', 'nullable'],
            'credit'         => ['nullable'],
            'show'           => ['string', 'max:255', 'nullable'],
            'location'       => ['string', 'max:255', 'nullable'],
            'embed'          => ['nullable'],
            'video_url'      => ['string', 'max:500', 'nullable'],
            'notes'          => ['nullable'],
            'link'           => ['string', 'url:http,https', 'max:255', 'nullable'],
            'link_name'      => ['string', 'max:255', 'nullable'],
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
        ];
    }
}
