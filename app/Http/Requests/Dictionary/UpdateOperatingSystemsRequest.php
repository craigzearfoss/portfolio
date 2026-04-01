<?php

namespace App\Http\Requests\Dictionary;

use App\Models\Dictionary\OperatingSystem;
use App\Traits\ModelPermissionsTrait;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 *
 */
class UpdateOperatingSystemsRequest extends FormRequest
{
    use ModelPermissionsTrait;

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        if (!$operating_system = OperatingSystem::find($this['operating_system']['id']) ) {
            throw new Exception('Operating system ' . $this['operating_system']['id'] . ' not found');
        }

        updateGate($operating_system, loggedInAdmin());

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'full_name'    => ['filled', 'string', 'max:255', 'unique:dictionary_db.operating_systems,full_name,' . $this['operating_system']['id']],
            'name'         => ['filled', 'string', 'max:255', 'unique:dictionary_db.operating_systems,name,' . $this['operating_system']['id']],
            'slug'         => ['filled', 'string', 'max:255', 'unique:dictionary_db.operating_systems,slug,' . $this['operating_system']['id']],
            'abbreviation' => ['string', 'max:20', 'nullable'],
            'definition'   => ['string', 'max:500', 'nullable'],
            'open_source'  => ['integer', 'between:0,1'],
            'proprietary'  => ['integer', 'between:0,1'],
            'compiled'     => ['integer', 'between:0,1'],
            'owner'        => ['string', 'max:255', 'nullable'],
            'wikipedia'    => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link'         => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'    => ['string', 'max:255', 'nullable'],
            'description'  => ['nullable'],
            'image'        => ['string', 'max:500', 'nullable'],
            'image_credit' => ['string', 'max:255', 'nullable'],
            'image_source' => ['string', 'max:255', 'nullable'],
            'thumbnail'    => ['string', 'max:500', 'nullable'],
            'is_public'    => ['integer', 'between:0,1'],
            'is_readonly'  => ['integer', 'between:0,1'],
            'is_root'      => ['integer', 'between:0,1'],
            'is_disabled'  => ['integer', 'between:0,1'],
            'is_demo'      => ['integer', 'between:0,1'],
            'sequence'     => ['integer', 'min:0', 'nullable'],
        ];
    }

    /**
     * Return error messages.
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            //
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     * @throws Exception
     */
    public function prepareForValidation(): void
    {
        if (!$ownerId = $this['owner_id']) {
            throw new Exception('No owner_id specified.');
        }

        // generate the slug
        if (!empty($this['name'])) {
            $this->merge([
                'slug' => uniqueSlug($this['name'], 'dictionary_db.operating_systems ', $ownerId)
            ]);
        }
    }
}
