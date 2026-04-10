<?php

namespace App\Http\Requests\Career;

use App\Models\Career\Communication;
use App\Models\System\Admin;
use App\Models\System\Owner;
use DateMalformedStringException;
use DateTime;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateCommunicationsRequest extends FormRequest
{
    /**
     * @var Admin|Owner|null
     */
    protected Admin|null|Owner $loggedInAdmin = null;

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        if (!$communication = Communication::find($this['communication']['id']) ) {
            throw new Exception('Communication ' . $this['communication']['id'] . ' not found');
        }

        updateGate($communication, loggedInAdmin());

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
            // you CANNOT change the owner for a communication
            'owner_id'               => ['filled', 'integer', 'exists:system_db.admins,id'],
            */
            /*
            // you CANNOT change the application for a communication
            'application_id'         => [
                'filled',
                'integer',
                'exists:career_db.applications,id',
                Rule::in(new Application()->where('owner_id', $this['owner_id'])
                    ->get()->pluck('id')->toArray())
            ],
            */
            'communication_type_id'  => ['filled', 'integer', 'exists:career_db.communication_types,id'],
            'subject'                => ['filled', 'string', 'max:255'],
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
        return [
            'owner_id.filled'              => 'Please select an owner for the communication.',
            'owner_id.exists'              => 'The specified owner does not exist.',
            'application_id.filled'        => 'Please select an application for the communication.',
            'application_id.exists'        => 'The specified application does not exist.',
            'application_id.in'            => 'Application ' . $this['application_id'] . ' does not belong to admin ' . $this['owner_id'] . '.',
            'communication_type_id.filled' => 'Please select the type of communication.',
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
        if (!empty($this['communication_datetime'])) {
            $communication_datetime = new DateTime($this['communication_datetime']);
            $this['communication_datetime'] = $communication_datetime->format('Y-m-d H:i:s');
        }
    }

    /**
     * Verifies the communication exists and the owner is authorized to update it.
     *
     * @return void
     * @throws ValidationException
     */
    protected function validateAuthorization(): void
    {
        // verify the communication exists
        if (!Communication::find($this['communication']['id']) ) {
            throw ValidationException::withMessages([
                'GLOBAL' => 'Communication ' . $this['communication']['id'] . ' not found,'
            ]);
        }

        // verify the admin is authorized to update the communication
        if (!$this->loggedInAdmin['is_root'] || (new Communication()->where('owner_id', $this['owner__id'])->get()->isEmpty())) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to update communication '. $this['communication']['id'] . '.'
                    : 'Unauthorized to update communication '. $this['communication']['id'] . ' for ' . $this->loggedInAdmin['username'] . '.'
            ]);
        }
    }
}
