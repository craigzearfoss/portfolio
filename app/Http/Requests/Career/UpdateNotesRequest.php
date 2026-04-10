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
        if (!$note = Note::find($this['note']['id']) ) {
            throw new Exception('Note ' . $this['note']['id'] . ' not found');
        }

        updateGate($note, loggedInAdmin());

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
            'owner_id'       => ['filled', 'integer', 'exists:system_db.admins,id'],
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
            'owner_id.filled'       => 'Please select an owner for the note.',
            'owner_id.exists'       => 'The specified owner does not exist.',
            'application_id.exists' => 'The specified application does not exist.',
            'application_id.filled' => 'Please select an application for the note.',
        ];
    }

    /**
     * Verifies the note exists and the owner is authorized to update it.
     *
     * @return void
     * @throws ValidationException
     */
    protected function validateAuthorization(): void
    {
        // verify the note exists
        if (!Note::find($this['note']['id']) ) {
            throw ValidationException::withMessages([
                'GLOBAL' => 'Note ' . $this['note']['id'] . ' not found.'
            ]);
        }

        // verify the admin is authorized to update the application
        if (!$this->loggedInAdmin['is_root'] || (new Note()->where('owner_id', $this['owner_id'])->get()->isEmpty())) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to update note '. $this['note']['id'] . '.'
                    : 'Unauthorized to update note '. $this['note']['id'] . ' for ' . $this->loggedInAdmin['username'] . '.'
            ]);
        }
    }
}
