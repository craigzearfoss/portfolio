<?php

namespace App\Http\Requests\Career;

use App\Models\Career\Application;
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

class StoreCommunicationsRequest extends FormRequest
{
    /**
     * @var Admin|Owner|null
     */
    protected Admin|null|Owner $loggedInAdmin = null;

    /**
     * The id of the owner of the communication.
     *
     * @var int|null
     */
    protected int|null $ownerId = null;

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws ValidationException
     */
    public function authorize(): bool
    {
        $this->loggedInAdmin = loggedInAdmin();

        if (!canCreate('App\Models\Career\Communication', $this->loggedInAdmin)) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to create communication'
                    : 'Unauthorized to create communication for admin ' . $this->loggedInAdmin['id'] . '.'
            ]);

        }

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
            'owner_id'               => ['required', 'integer', 'exists:system_db.admins,id'],
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
        return [
            'owner_id.required'              => 'Please select an owner for the communication.',
            'owner_id.exists'                => 'The specified owner does not exist.',
            'application_id.required'        => 'Please select an application for the communication.',
            'application_id.exists'          => 'The specified application does not exist.',
            'application_id.in'              => 'Application ' . $this['application_id'] . ' does not belong to admin ' . $this['owner_id'] . '.',
            'communication_type_id.required' => 'Please select the type of communication.',
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
}
