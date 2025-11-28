<?php

namespace App\Http\Requests\Career;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEventsRequest extends FormRequest
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
        if (!empty($this->time) && (substr_count($this->time, ':') === 3)) {
            // remove milliseconds part of time
            $lastPos = strrpos($this->time, ':');
            $this->merge(['time' => substr($this->time, 0, $lastPos)]);
        }

        return [
            'owner_id'       => ['filled', 'integer', 'exists:system_db.admins,id'],
            'application_id' => ['filled', 'integer', 'exists:career_db.applications,id'],
            'name'           => ['filled', 'string', 'max:255'],
            'date'           => ['date_format:Y-m-d', 'nullable'],
            'time'           => ['date_format:H:i:s', 'nullable'],
            'location'       => ['string', 'max:255', 'nullable'],
            'description'    => ['nullable'],
            'public'         => ['integer', 'between:0,1'],
            'readonly'       => ['integer', 'between:0,1'],
            'root'           => ['integer', 'between:0,1'],
            'disabled'       => ['integer', 'between:0,1'],
            'demo'           => ['integer', 'between:0,1'],
            'sequence'       => ['integer', 'min:0', 'nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'owner_id.filled'       => 'Please select an owner for the event.',
            'owner_id.exists'       => 'The specified owner does not exist.',
            'application_id.filled' => 'Please select an application for the event.',
            'application_id.exists' => 'The specified application does not exist.',
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
