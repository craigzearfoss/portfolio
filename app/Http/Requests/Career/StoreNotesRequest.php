<?php

namespace App\Http\Requests\Career;

use App\Models\Career\Application;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNotesRequest extends FormRequest
{
    /**
     * Determine if the admin is authorized to make this request.
     */
    public function authorize(): bool
    {
        createGate('App\Models\Career\Note', loggedInAdmin());

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
