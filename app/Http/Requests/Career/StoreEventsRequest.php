<?php

namespace App\Http\Requests\Career;

use App\Traits\ModelPermissionsTrait;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEventsRequest extends FormRequest
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
            'owner_id'       => ['required', 'integer', 'exists:system_db.admins,id'],
            'application_id' => ['required', 'integer', 'exists:career_db.applications,id'],
            'name'           => ['required', 'string', 'max:255'],
            'date'           => ['date_format:Y-m-d', 'nullable'],
            'time'           => ['date_format:H:i:s', 'nullable'],
            'location'       => ['string', 'max:255', 'nullable'],
            'attendees'      => ['string', 'max:500', 'nullable'],
            'description'    => ['nullable'],
            'public'         => ['integer', 'between:0,1'],
            'readonly'       => ['integer', 'between:0,1'],
            'root'           => ['integer', 'between:0,1'],
            'disabled'       => ['integer', 'between:0,1'],
            'demo'           => ['integer', 'between:0,1'],
            'sequence'       => ['integer', 'min:0', 'nullable'],
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
            'owner_id.required'       => 'Please select an owner for the event.',
            'owner_id.exists'         => 'The specified owner does not exist.',
            'application_id.required' => 'Please select an application for the event.',
            'application_id.exists'   => 'The specified application does not exist.',
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
