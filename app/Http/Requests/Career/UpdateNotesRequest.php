<?php

namespace App\Http\Requests\Career;

use App\Models\Career\Note;
use App\Models\System\Admin;
use App\Models\System\Owner;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;
use Mockery\Matcher\Not;

class UpdateNotesRequest extends FormRequest
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
        $this->loggedInAdmin = loggedInAdmin();

        // verify the note exists
        $note = Note::query()->findOrFail($this['note']['id']);

        // verify the admin is authorized to update the note
        if (!$this->loggedInAdmin['is_root'] || (new Note()->where('owner_id', $this['owner_id'])->get()->isEmpty())) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to update note '. $note['id'] . '.'
                    : 'Unauthorized to update note '. $note['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.'
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
            /*
            // you CANNOT change the owner for a note
            'owner_id'       => [
                'filled',
                'integer',
                'exists:system_db.admins,id'
            ],
            */
            /*
            // you CANNOT change the application for a note
            'application_id' => [
                'filled',
                'integer',
                'exists:career_db.applications,id',
                Rule::in(new Application()->where('owner_id', $this['owner_id'])
                    ->get()->pluck('id')->toArray())
            ],
            */
            'subject'        => ['filled', 'string', 'max:255'],
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
            'owner_id.filled'       => 'Please select an owner for the event.',
            'owner_id.exists'       => 'The specified owner does not exist.',
            'owner_id.in'           => 'Unauthorized to update event '
                . $this['communication']['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.',
            'application_id.filled' => 'Please select an application for the event.',
            'application_id.exists' => 'The specified application does not exist.',
            'application_id.in'     => 'Application ' . $this['application_id'] . ' does not belong to admin ' . $this['owner_id'] . '.',
        ];
    }
}
