<?php

namespace App\Http\Requests\Career;

use App\Models\Country;
use App\Models\State;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RecruiterUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return isRootAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Generate the slug.
        if (!empty($this['name'])) {
            $this->merge([ 'slug' => Str::slug($this['name']) ]);
        }

        return [
            'name'            => ['string', 'max:255', 'unique:career_db.recruiters,name,'.$this->recruiter->id, 'filled'],
            'slug'            => ['string', 'max:255', 'unique:career_db.recruiters,slug,'.$this->recruiter->id, 'filled'],
            'postings_url'    => ['string', 'max:255', 'nullable'],
            'local'           => ['integer', 'between:0,1'],
            'regional'        => ['integer', 'between:0,1'],
            'national'        => ['integer', 'between:0,1'],
            'international'   => ['integer', 'between:0,1'],
            'street'          => ['string', 'max:255', 'nullable'],
            'street2'         => ['string', 'max:255', 'nullable'],
            'city'            => ['string', 'max:100', 'nullable'],
            'state_id'        => ['integer', Rule::in(State::all('id')->pluck('id')->toArray()), 'nullable'],
            'zip'             => ['string', 'max:20', 'nullable'],
            'country_id'      => ['integer', Rule::in(Country::all('id')->pluck('id')->toArray()), 'nullable'],
            'latitude'        => ['numeric:strict', 'nullable'],
            'longitude'       => ['numeric:strict', 'nullable'],
            'phone'           => ['string', 'max:20', 'nullable'],
            'phone_label'     => ['string', 'max:255', 'nullable'],
            'alt_phone'       => ['string', 'max:20', 'nullable'],
            'alt_phone_label' => ['string', 'max:255', 'nullable'],
            'email'           => ['string', 'max:255', 'nullable'],
            'email_label'     => ['string', 'max:255', 'nullable'],
            'alt_email'       => ['string', 'max:255', 'nullable'],
            'alt_email_label' => ['string', 'max:255', 'nullable'],
            'link'            => ['string', 'url:http,https', 'max:255', 'nullable'],
            'link_name'       => ['string', 'max:255', 'nullable'],
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
