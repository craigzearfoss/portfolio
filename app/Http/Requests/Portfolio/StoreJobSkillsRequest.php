<?php

namespace App\Http\Requests\Portfolio;

use App\Models\System\Admin;
use App\Models\System\Owner;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StoreJobSkillsRequest extends FormRequest
{
    /**
     * @var Admin|Owner|null
     */
    protected Admin|null|Owner $loggedInAdmin = null;

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws ValidationException
     */
    public function authorize(): bool
    {
        $this->loggedInAdmin = loggedInAdmin();

        if (!canCreate('App\Models\Portfolio\JobSkill', $this->loggedInAdmin)) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to create job skill.'
                    : 'Unauthorized to create job skill for admin ' . $this->loggedInAdmin['id'] . '.'
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
        if (!$ownerId = $this['owner_id']) {
            throw new Exception('No owner_id specified.');
        }

        return [
            'owner_id'               => ['required', 'integer', 'exists:system_db.admins,id'],
            'job_id'                 => ['required', 'integer', 'exists:portfolio_db.jobs,id'],
            'name'                   => [
                'required',
                'string',
                'max:255',
                Rule::unique('portfolio_db.job_skills', 'name')->where(function ($query) use ($ownerId) {
                    return $query->where('owner_id', $ownerId)
                        ->where('job_id', $this['job_id'])
                        ->where('name', $this['name']);
                })
            ],
            'type'                   => ['integer', 'between:0,1'],
            'dictionary_category_id' => ['integer', 'exists:dictionary_db.categories,id', 'nullable'],
            'dictionary_id_term_id'  => ['integer', 'nullable'],
            'summary'                => ['string', 'max:500', 'nullable'],
            'notes'                  => ['nullable'],
            'link'                   => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'              => ['string', 'max:255', 'nullable'],
            'description'            => ['nullable'],
            'disclaimer'             => ['string', 'max:500', 'nullable'],
            'image'                  => ['string', 'max:500', 'nullable'],
            'image_credit'           => ['string', 'max:255', 'nullable'],
            'image_source'           => ['string', 'max:255', 'nullable'],
            'thumbnail'              => ['string', 'max:500', 'nullable'],
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
            'owner_id.required'  => 'Please select an owner for the job skill.',
            'owner_id.exists'    => 'The specified owner does not exist.',
            'job_id.required'   => 'Please select a job for the coworker.',
            'job_id.exists'     => 'The specified job does not exist.',
            'name.unique'        => '`' . $this['name'] . '` has already been added.',
            'resource_id.exists' => 'The specified resource does not exist.',
            'category_id.exists' => 'The specified category does not exist.',
        ];
    }
}
