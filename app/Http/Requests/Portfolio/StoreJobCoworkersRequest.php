<?php

namespace App\Http\Requests\Portfolio;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreJobCoworkersRequest extends FormRequest
{
    use ModelPermissionsTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->checkDemoMode();

        $this->checkOwner();

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'owner_id'        => ['required', 'integer', 'exists:system_db.admins,id'],
            'job_id'          => ['required', 'integer', 'exists:portfolio_db.jobs,id'],
            'name'            => [
                'required',
                'string',
                'max:255',
                Rule::unique('portfolio_db.job_coworkers', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('job_id', $this->job_id)
                        ->where('name', $this->name);
                })
            ],
            'title'           => ['string', 'max:100', 'nullable'],
            'level_id'        => ['integer', 'between:1,3'],
            'work_phone'      => ['string', 'max:20', 'nullable'],
            'personal_phone'  => ['string', 'max:20', 'nullable'],
            'work_email'      => ['string', 'max:255', 'nullable'],
            'personal_email'  => ['string', 'max:255', 'nullable'],
            'notes'           => ['nullable'],
            'link'            => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'       => ['string', 'max:255', 'nullable'],
            'description'     => ['nullable'],
            'disclaimer'      => ['string', 'max:500', 'nullable'],
            'image'           => ['string', 'max:500', 'nullable'],
            'image_credit'    => ['string', 'max:255', 'nullable'],
            'image_source'    => ['string', 'max:255', 'nullable'],
            'thumbnail'       => ['string', 'max:500', 'nullable'],
            'public'          => ['integer', 'between:0,1'],
            'readonly'        => ['integer', 'between:0,1'],
            'root'            => ['integer', 'between:0,1'],
            'disabled'        => ['integer', 'between:0,1'],
            'demo'            => ['integer', 'between:0,1'],
            'sequence'        => ['integer', 'min:0', 'nullable'],
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
            'owner_id.required' => 'Please select an owner for the coworker.',
            'owner_id.exists'   => 'The specified owner does not exist.',
            'job_id.required'   => 'Please select a job for the coworker.',
            'job_id.exists'     => 'The specified job does not exist.',
            'name.unique'        => '`' . $this->name . '` has already been added.',
            'level_id.required' => 'Please select a level type for the coworker.',
            'level_id.exists'   => 'The specified level does not exist.',
        ];
    }
}
