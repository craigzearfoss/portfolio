<?php

namespace App\Http\Requests\Career;

use App\Http\Requests\StoreAppBaseRequest;
use App\Models\Career\Application;
use App\Models\System\Admin;
use DateMalformedStringException;
use DateTime;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

/**
 *
 */
class StoreCommunicationsRequest extends StoreAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'career_db',
        'table'        => 'communications',
        'key'          => 'communication',
        'name'         => 'communication',
        'label'        => 'communication',
        'class'        => 'App\Models\Career\Communication',
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
            'owner_id'               => [
                'required',
                'integer',
                Rule::in($this->isRootAdmin
                    ? new Admin()->all()->pluck('id')->toArray()
                    : [ $this->ownerId ]
                )
            ],
            'application_id'         => [
                'required',
                'integer',
                'exists:career_db.applications,id',
                Rule::in(new Application()->where('owner_id', $this['owner_id'])
                    ->get()->pluck('id')->toArray())
            ],
            'communication_type_id'  => ['required', 'integer', 'exists:career_db.communication_types,id'],
            'subject'                => ['required', 'string', 'max:255'],
            'to'                     => ['string', 'max:500', 'nullable'],
            'from'                   => ['string', 'max:500', 'nullable'],
            'communication_datetime' => ['date _format:Y-m-d H:i:s', 'nullable'],
            'body'                   => ['nullable'],
            'notes'                  => ['nullable'],
            'link'                   => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'              => ['string', 'max:255', 'nullable'],
            'description'            => ['nullable'],
            'disclaimer'             => ['string', 'max:500', 'nullable'],
            'is_public'              => ['integer', 'between:0,1'],
            'is_readonly'            => ['integer', 'between:0,1'],
            'is_root'                => ['integer', 'between:0,1'],
            'is_disabled'            => ['integer', 'between:0,1'],
            'is_demo'                => ['integer', 'between:0,1'],
            'sequence'               => ['integer', 'min:0', 'nullable'],
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
                'application_id.required'        => 'Please select an application for the communication.',
                'application_id.exists'          => 'The specified application does not exist.',
                'application_id.in'              => 'Application ' . $this['application_id'] . ' does not belong to admin ' . $this['owner_id'] . '.',
                'communication_type_id.required' => 'Please select the type of communication.',
            ]
        );
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     * @throws DateMalformedStringException
     */
    public function prepareForValidation(): void
    {
        // make sure the communication_datetime is formatted correctly
        if (!empty($this['communication_datetime'])) {
            $communication_datetime = new DateTime($this['communication_datetime']);
            $this['communication_datetime'] = $communication_datetime->format('Y-m-d H:i:s');
        }
    }
}
