<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Owner;
use App\Models\Portfolio\Academy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CertificationUpdateRequest extends FormRequest
{
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
        // Generate the slug.
        if (!empty($this['name'])) {
            $this->merge([ 'slug' => Str::slug($this['name']) ]);
        }

        // Validate the admin_id. (Only root admins can change the admin for a certification.)
        if (!empty($this['admin_id']) && !Auth::guard('admin')->user()->root
            && ($this['admin_id'] == !Auth::guard('admin')->user()->id)
        ) {
            throw new \Exception('You are not authorized to change the admin for a certification.');
        }

        return [
            'owner_id'        => ['integer', 'exists:core_db.admins,id'],
            'name'            => ['string',
                'max:255',
                'filled',
                Rule::unique('portfolio_db.certifications')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('id', '<>', $this->certification->id)
                        ->where('name', $this->name);
                })
            ],
            'slug'            => [
                'string',
                'filled',
                'max:255',
                Rule::unique('portfolio_db.certifications')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('id', '<>', $this->certification->id)
                        ->where('slug', $this->slug);
                })
            ],
            'featured'        => ['integer', 'between:0,1'],
            'summary'         => ['string', 'max:500', 'nullable'],
            'organization'    => ['string', 'max:255', 'nullable'],
            'academy_id'      => ['integer', Rule::in(Academy::all()->pluck('id'))],
            'year'            => ['integer', 'between:1980,'.date("Y"), 'nullable'],
            'received'        => ['date', 'nullable'],
            'expiration'      => ['date', 'nullable'],
            'certificate_url' => ['string', 'max:500', 'nullable'],
            'notes'           => ['nullable'],
            'link'            => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'       => ['string', 'nullable'],
            'description'     => ['nullable'],
            'image'           => ['string', 'max:255', 'nullable'],
            'image_credit'    => ['string', 'max:255', 'nullable'],
            'image_source'    => ['string', 'max:255', 'nullable'],
            'thumbnail'       => ['string', 'max:255', 'nullable'],
            'sequence'        => ['integer', 'min:0'],
            'public'          => ['integer', 'between:0,1'],
            'readonly'        => ['integer', 'between:0,1'],
            'root'            => ['integer', 'between:0,1'],
            'disabled'        => ['integer', 'between:0,1'],
        ];
    }
}
