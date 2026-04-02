<?php

namespace App\Http\Requests\Career;

use DateTime;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCommunicationsRequest extends FormRequest
{
    /**
     * Determine if the admin is authorized to make this request.
     */
    public function authorize(): bool
    {
        createGate('App\Models\Career\Communication', loggedInAdmin());

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     * @throws Exception
     */
    public function rules(): array
    {
        return [
            'owner_id'              => ['required', 'integer', 'exists:system_db.admins,id'],
            'application_id'        => ['required', 'integer', 'exists:career_db.applications,id'],
            'communication_type_id' => ['required', 'integer', 'exists:career_db.communication_types,id'],
            'subject'               => ['required', 'string', 'max:255'],
            'to'                    => ['string', 'max:500', 'nullable'],
            'from'                  => ['string', 'max:500', 'nullable'],
            'datetime'              => ['date _format:Y-m-d H:i:s', 'nullable'],
            'body'                  => ['nullable'],
            'is_public'             => ['integer', 'between:0,1'],
            'is_readonly'           => ['integer', 'between:0,1'],
            'is_root'               => ['integer', 'between:0,1'],
            'is_disabled'           => ['integer', 'between:0,1'],
            'is_demo'               => ['integer', 'between:0,1'],
            'sequence'              => ['integer', 'min:0', 'nullable'],
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
            'owner_id.required'              => 'Please select an owner for the communication.',
            'owner_id.exists'                => 'The specified owner does not exist.',
            'application_id.required'        => 'Please select an application for the communication.',
            'application_id.exists'          => 'The specified application does not exist.',
            'communication_type_id.required' => 'Please select the type of communication.',
       ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     * @throws \DateMalformedStringException
     */
    public function prepareForValidation(): void
    {
        $datetime = new DateTime($this['datetime']);
        $this['datetime'] = $datetime->format('Y-m-d H:i:s');
    }
}
