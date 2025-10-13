<?php

namespace App\Http\Requests\Career;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContactsRequest extends FormRequest
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
            'owner_id'        => ['required', 'integer', 'exists:system_db.admins,id'],
            'name'            => [
                'required',
                'string',
                'max:255',
                Rule::unique('career_db.contacts')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('name', $this->name);
                })
            ],
            'slug'            => [
                'required',
                'string',
                'max:255',
                Rule::unique('career_db.contacts')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('slug', $this->slug);
                })
            ],
            'title'           => ['string', 'max:20', 'nullable'],
            'job_title'       => ['string', 'max:100', 'nullable'],
            'street'          => ['string', 'max:255', 'nullable'],
            'street2'         => ['string', 'max:255', 'nullable'],
            'city'            => ['string', 'max:100', 'nullable'],
            'state_id'        => ['integer', 'exists:system_db.states,id', 'nullable'],
            'zip'             => ['string', 'max:20', 'nullable'],
            'country_id'      => ['integer', 'exists:system_db.countries,id', 'nullable'],
            'latitude'        => ['numeric:strict', 'nullable'],
            'longitude'       => ['numeric:strict', 'nullable'],
            'phone'           => ['string', 'max:50', 'nullable'],
            'phone_label'     => ['string', 'max:255', 'nullable'],
            'alt_phone'       => ['string', 'max:50', 'nullable'],
            'alt_phone_label' => ['string', 'max:255', 'nullable'],
            'email'           => ['email:rfc,dns', 'max:255', 'nullable'],
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

    public function messages(): array
    {
        return [
            'owner_id.required' => 'Please select an owner for the contact.',
            'owner_id.exists'   => 'The specified owner does not exist.',
            'state_id.exists'   => 'The specified state does not exist.',
            'country_id.exists' => 'The specified country does not exist.',
        ];
    }
}
