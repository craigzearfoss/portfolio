<?php

namespace App\Http\Requests\Dictionary;

use App\Models\Dictionary\Language;
use App\Models\System\Admin;
use App\Models\System\Owner;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;

/**
 *
 */
class UpdateLanguagesRequest extends FormRequest
{
    /**
     * @var Admin|Owner|null
     */
    protected Admin|null|Owner $loggedInAdmin = null;

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        $this->loggedInAdmin = loggedInAdmin();

        // verify the dictionary language exists
        $language = Language::query()->findOrFail($this['language']['id']);

        return boolval($this->loggedInAdmin['is_root']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'full_name'    => ['filled', 'string', 'max:255', 'unique:dictionary_db.languages,full_name,' . $this['language']['id']],
            'name'         => ['filled', 'string', 'max:255', 'unique:dictionary_db.languages,name,' . $this['language']['id']],
            'slug'         => ['filled', 'string', 'max:255', 'unique:dictionary_db.languages,slug,' . $this['language']['id']],
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
            'owner_id.filled'   => 'Please select an owner for the dictionary language.',
            'owner_id.exists'   => 'The specified owner does not exist.',
            'owner_id.in'       => 'Unauthorized to update dictionary language '
                . $this['language']['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
        // generate the slug
        if (!empty($this['name'])) {
            $this->merge([
                'slug' => uniqueSlug($this['name'], 'dictionary_db.languages ', $this->loggedInAdmin['id'])
            ]);
        }
    }
}
