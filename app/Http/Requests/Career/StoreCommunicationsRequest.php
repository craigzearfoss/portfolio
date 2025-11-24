<?php

namespace App\Http\Requests\Career;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;

class StoreCommunicationsRequest extends FormRequest
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
        return [
            'owner_id'       => ['required', 'integer', 'exists:system_db.admins,id'],
            'application_id' => ['required', 'integer', 'exists:career_db.applications,id'],
            'subject'        => ['required', 'string', 'max:255'],
            'date'           => ['date_format:Y-m-d', 'nullable'],
            'time'           => ['date_format:H:i:s', 'nullable'],
            'body'           => ['nullable'],
            'sequence'       => ['integer', 'min:0'],
            'public'         => ['integer', 'between:0,1'],
            'readonly'       => ['integer', 'between:0,1'],
            'root'           => ['integer', 'between:0,1'],
            'disabled'       => ['integer', 'between:0,1'],
            'demo'           => ['integer', 'between:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'owner_id.required'       => 'Please select an owner for the communication.',
            'owner_id.exists'         => 'The specified owner does not exist.',
            'application_id.required' => 'Please select an application for the communication.',
            'application_id.exists'   => 'The specified application does not exist.',
       ];
    }

    public function prepareForValidation()
    {
        if (!empty($this->time)) {
            $this->merge([
                'time' => $this->time . ':00',
            ]);
        }
    }
}
