<?php

namespace App\Http\Requests\Career;

use App\Models\Career\Application;
use App\Models\System\Admin;
use App\Models\System\Owner;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StoreNotesRequest extends FormRequest
{
    /**
     * @var Admin|Owner|null
     */
    protected Admin|null|Owner $loggedInAdmin = null;

    /**
     * The id of the owner of the note.
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

        if (!canCreate('App\Models\Career\Note', $this->loggedInAdmin)) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to create note.'
                    : 'Unauthorized to create note for admin ' . $this->loggedInAdmin['id'] . '.'
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
            'owner_id'       => ['required', 'integer', 'exists:system_db.admins,id'],
            'application_id'         => [
                'required',
                'integer',
                'exists:career_db.applications,id',
                Rule::in(new Application()->where('owner_id', $this['owner_id'])
                    ->get()->pluck('id')->toArray())
            ],
            'subject'        => ['required', 'string', 'max:255'],
            'body'           => ['nullable'],
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
            'owner_id.required'       => 'Please select an owner for the note.',
            'owner_id.exists'         => 'The specified owner does not exist.',
            'application_id.required' => 'Please select an application for the note.',
            'application_id.exists'   => 'The specified application does not exist.',
            'application_id.in'       => 'Application ' . $this['application_id'] . ' does not belong to admin ' . $this['owner_id'] . '.',
        ];
    }
}
