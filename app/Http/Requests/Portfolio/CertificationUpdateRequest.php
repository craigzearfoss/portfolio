<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Admin;
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
            $this->merge([ 'slug' => Str::slug($this['name']) ]);
        }

        // Validate the admin_id. (Only root admins can change the admin for a certification.)
        if (!empty($this['admin_id']) && !Auth::guard('admin')->user()->root
            && ($this['admin_id'] == !Auth::guard('admin')->user()->id)
        ) {
            throw new \Exception('You are not authorized to change the admin for a certification.');
        }

        $adminIds = Auth::guard('admin')->user()->root
            ? Admin::all('id')->pluck('id')->toArray()
            : [Auth::guard('admin')->user()->id];

        return [
            'name'            => ['string', 'max:255', 'unique:portfolio_db.certifications,name,'.$this->certification->id, 'filled'],
            'slug'            => ['string', 'max:255', 'unique:portfolio_db.certifications,slug,'.$this->certification->id, 'filled'],
            'organization'    => ['string', 'max:255', 'nullable'],
            'academy_id'      => ['integer', Rule::in(Academy::all()->pluck('id'))],
            'professional'    => ['integer', 'between:0,1'],
            'personal'        => ['integer', 'between:0,1'],
            'year'            => ['integer', 'between:1980,2050', 'nullable'],
            'received'        => ['date', 'nullable'],
            'expiration'      => ['date', 'nullable'],
            'certificate_url' => ['string', 'url:http,https', 'max:255', 'nullable'],
            'link'            => ['string', 'url:http,https', 'max:255', 'nullable'],
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
            'admin_id'        => ['integer', Rule::in($adminIds)],
        ];
    }
}
