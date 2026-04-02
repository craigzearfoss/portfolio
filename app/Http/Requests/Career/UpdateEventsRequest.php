<?php

namespace App\Http\Requests\Career;

use App\Models\Career\Event;
use DateMalformedStringException;
use DateTime;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEventsRequest extends FormRequest
{
    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        if (!$event = Event::query()->find($this['event']['id']) ) {
            throw new Exception('Event ' . $this['event']['id'] . ' not found');
        }

        updateGate($event, loggedInAdmin());

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
            'owner_id'       => ['filled', 'integer', 'exists:system_db.admins,id'],
            'application_id' => ['filled', 'integer', 'exists:career_db.applications,id'],
            'name'           => ['filled', 'string', 'max:255'],
            'datetime'       => ['date _format:Y-m-d H:i:s', 'nullable'],
            'location'       => ['string', 'max:255', 'nullable'],
            'attendees'      => ['string', 'max:500', 'nullable'],
            'description'    => ['nullable'],
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
            'owner_id.filled'       => 'Please select an owner for the event.',
            'owner_id.exists'       => 'The specified owner does not exist.',
            'application_id.filled' => 'Please select an application for the event.',
            'application_id.exists' => 'The specified application does not exist.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     * @throws DateMalformedStringException
     */
    public function prepareForValidation(): void
    {
        $datetime = new DateTime($this['datetime']);
        $this['datetime'] = $datetime->format('Y-m-d H:i:s');
    }
}
