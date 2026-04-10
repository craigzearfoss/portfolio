<?php

namespace App\Http\Requests\Career;

use App\Models\Career\Application;
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
            /*
            // you CANNOT change the owner for an event
            'owner_id'       => ['filled', 'integer', 'exists:system_db.admins,id'],
            */
            /*
            // you CANNOT change the application for an event
            'application_id' => [
                'filled',
                'integer',
                'exists:career_db.applications,id',
                Rule::in(new Application()->where('owner_id', $this['owner_id'])
                    ->get()->pluck('id')->toArray())
            ],
            */
            'name'           => ['filled', 'string', 'max:255'],
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
            'owner_id.filled'       => 'Please select an owner for the event.',
            'owner_id.exists'       => 'The specified owner does not exist.',
            'application_id.filled' => 'Please select an application for the event.',
            'application_id.exists' => 'The specified application does not exist.',
            'application_id.in'     => 'Application ' . $this['application_id'] . ' does not belong to admin ' . $this['owner_id'] . '.',
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
        if (!empty($this['event_time'])) {
            $communication_datetime = new DateTime($this['event_time']);
            $this['event_time'] = $communication_datetime->format('H:i:s');
        }
    }
}
