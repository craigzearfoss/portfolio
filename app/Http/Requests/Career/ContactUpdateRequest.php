<?php

namespace App\Http\Requests\Career;

use App\Models\Country;
use App\Models\Owner;
use App\Models\State;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ContactUpdateRequest extends FormRequest
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
                'slug' => uniqueSlug($this['name'], 'career_db.contacts', $this->owner_id)
            ]);
        }

        return [
            'owner_id'        => ['filled', 'integer', 'exists:core_db.admins,id'],
            'name'            => [
                'filled',
                'string',
                'max:255',
                Rule::unique('career_db.contacts')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('id', '<>', $this->contact->id)
                        ->where('name', $this->name);
                })
            ],
            'slug'            => [
                'filled',
                'string',
                'max:255',
                Rule::unique('career_db.contacts')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('id', '<>', $this->contact->id)
                        ->where('slug', $this->slug);
                })
            ],
            'title'           => ['string', 'max:20', 'nullable'],
            'job_title'       => ['string', 'max:100', 'nullable'],
            'street'          => ['string', 'max:255', 'nullable'],
            'street2'         => ['string', 'max:255', 'nullable'],
            'city'            => ['string', 'max:100', 'nullable'],
            'state_id'        => ['integer', 'exists:core_db.states,id', 'nullable'],
            'zip'             => ['string', 'max:20', 'nullable'],
            'country_id'      => ['integer', 'exists:core_db.countries,id', 'nullable'],
            'latitude'        => ['numeric:strict', 'nullable'],
            'longitude'       => ['numeric:strict', 'nullable'],
            'phone'           => ['string', 'max:50', 'nullable'],
            'phone_label'     => ['string', 'max:255', 'nullable'],
            'alt_phone'       => ['string', 'max:50', 'nullable'],
            'alt_phone_label' => ['string', 'max:255', 'nullable'],
            'email'           => ['string', 'max:255', 'nullable'],
            'email_label'     => ['string', 'max:255', 'nullable'],
            'alt_email'       => ['string', 'max:255', 'nullable'],
            'alt_email_label' => ['string', 'max:255', 'nullable'],
            'birthday'        => ['date', 'nullable'],
            'link'            => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'       => ['string', 'max:255', 'nullable'],
            'description'     => ['nullable'],
            'image'           => ['string', 'max:500', 'nullable'],
            'image_credit'    => ['string', 'max:255', 'nullable'],
            'image_source'    => ['string', 'max:255', 'nullable'],
            'thumbnail'       => ['string', 'max:500', 'nullable'],
            'sequence'        => ['integer', 'min:0'],
            'public'          => ['integer', 'between:0,1'],
            'readonly'        => ['integer', 'between:0,1'],
            'root'            => ['integer', 'between:0,1'],
            'disabled'        => ['integer', 'between:0,1'],
        ];
    }
}
