<?php

namespace App\Http\Requests\Career;

use App\Traits\ModelPermissionsTrait;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCommunicationsRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     * @throws Exception
     */
    public function rules(): array
    {
        return [
            'owner_id'              => ['filled', 'integer', 'exists:system_db.admins,id'],
            'application_id'        => ['filled', 'integer', 'exists:career_db.applications,id'],
            'communication_type_id' => ['filled', 'integer', 'exists:career_db.communication_types,id'],
            'subject'               => ['filled', 'string', 'max:255'],
            'to'                    => ['string', 'max:500', 'nullable'],
            'from'                  => ['string', 'max:500', 'nullable'],
            'date'                  => ['date_format:Y-m-d', 'nullable'],
            'time'                  => ['date_format:H:i:s', 'nullable'],
            'body'                  => ['nullable'],
            'public'                => ['integer', 'between:0,1'],
            'readonly'              => ['integer', 'between:0,1'],
            'root'                  => ['integer', 'between:0,1'],
            'disabled'              => ['integer', 'between:0,1'],
            'demo'                  => ['integer', 'between:0,1'],
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
            'owner_id.filled'              => 'Please select an owner for the communication.',
            'owner_id.exists'              => 'The specified owner does not exist.',
            'application_id.filled'        => 'Please select an application for the communication.',
            'application_id.exists'        => 'The specified application does not exist.',
            'communication_type_id.filled' => 'Please select the type of communication.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation()
    {
        if (!empty($this->time)) {
            $this->merge([
                'time' => $this->time . ':00',
            ]);
        }

        if (!empty($this->time) && (substr_count($this->time, ':') === 3)) {
            // remove milliseconds part of time
            $lastPos = strrpos($this->time, ':');
            $this->merge(['time' => substr($this->time, 0, $lastPos)]);
        }
    }
}
