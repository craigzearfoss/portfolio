<?php

namespace App\Http\Requests\Career;

use App\Http\Requests\UpdateAppBaseRequest;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 *
 */
class UpdateEventsRequest extends UpdateAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'career_db',
        'table'        => 'events',
        'key'          => 'event',
        'name'         => 'event',
        'label'        => 'event',
        'class'        => 'App\Models\Career\Event',
        'has_owner'    => true,
        'has_user'     => false,
    ];

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
            'owner_id'       => [
                'filled',
                'integer',
                Rule::in(array_unique(array_merge(
                    new Admin()->where('is_root', true)->get()->pluck('id')->toArray(),
                    [ $this->ownerId ]
                )))
            ],
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
            'event_datetime' => ['date_format:Y-m-d H:i:s', 'nullable'],
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
        return array_merge(
            parent::messages(),
            [
                'application_id.filled' => 'Please select an application for the event.',
                'application_id.exists' => 'The specified application does not exist.',
                'application_id.in'     => 'Application ' . $this['application_id'] . ' does not belong to admin ' . $this['owner_id'] . '.',
            ]
        );
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
    }
}
