<?php

namespace App\Http\Requests\Career;

use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEventsRequest extends FormRequest
{
    /**
     * Determine if the admin is authorized to make this request.
     */
    public function authorize(): bool
    {
        createGate('App\Models\Career\Event', loggedInAdmin());

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
            'event_date'     => ['date_format:Y-m-d', 'nullable'],
            'event_time'     => ['date_format:H:i:s', 'nullable'],
            'location'       => ['string', 'max:255', 'nullable'],
            'attendees'      => ['string', 'max:500', 'nullable'],
            'notes'          => ['nullable'],
            'link'           => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'      => ['string', 'max:255', 'nullable'],
            'description'    => ['nullable'],
            'disclaimer'     => ['string', 'max:500', 'nullable'],
            'is_public'      => ['integer', 'between:0,1'],
            'is_readonly'    => ['integer', 'between:0,1'],
            'is_root'        => ['integer', 'between:0,1'],
            'is_disabled'    => ['integer', 'between:0,1'],
            'is_demo'        => ['integer', 'between:0,1'],
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
    public function prepareForValidation(): void
    {
        if (!empty($this['event_time'])) {
            $parts = explode(':', $this['event_time']);
            $parts[] = '00';
            $parts[] = '00';
            $this['event_time'] = implode(':', array_slice($parts, 0, 3));
        }
    }
}
