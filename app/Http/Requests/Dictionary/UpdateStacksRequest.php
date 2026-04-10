<?php

namespace App\Http\Requests\Dictionary;

use App\Models\Dictionary\Stack;
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
class UpdateStacksRequest extends FormRequest
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
        if (!$stack = Stack::find($this['stack']['id']) ) {
            throw new Exception('Stack ' . $this['stack']['id'] . ' not found');
        }

        updateGate($stack, loggedInAdmin());

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
            'full_name'    => ['filled','string', 'max:255', 'unique:dictionary_db.stacks,full_name,' . $this['stack']['id']],
            'name'         => ['filled', 'string', 'max:255', 'unique:dictionary_db.stacks,name,' . $this['stack']['id']],
            'slug'         => ['filled', 'string', 'max:255', 'unique:dictionary_db.stacks,slug,' . $this['stack']['id']],
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
                'slug' => uniqueSlug($this['name'], 'dictionary_db.stacks ', $ownerId)
            ]);
        }
    }

    /**
     * Verifies the dictionary stack exists and the owner is authorized to update it.
     *
     * @return void
     * @throws ValidationException
     */
    protected function validateAuthorization(): void
    {
        // verify the dictionary stack exists
        if (!Stack::find($this['stack']['id']) ) {
            throw ValidationException::withMessages([
                'GLOBAL' => 'Dictionary stack ' . $this['stack']['id'] . ' not found.'
            ]);
        }

        // verify the admin is authorized to update the dictionary stack
        if (!$this->loggedInAdmin['is_root'] || (new Stack()->where('owner_id', $this['owner_id'])->get()->isEmpty())) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to update dictionary stack '. $this['stack']['id'] . '.'
                    : 'Unauthorized to update dictionary stack '. $this['stack']['id'] . ' for ' . $this->loggedInAdmin['username'] . '.'
            ]);
        }
    }
}
