<?php

namespace App\Http\Requests\Portfolio;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;

class StoreJobTaskRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'owner_id'        => ['required', 'integer', 'exists:core_db.admins,id'],
            'job_id'          => ['required', 'integer', 'exists:portfolio_db.jobs,id'],
            'summary'         => ['required','string', 'max:500'],
            'notes'           => ['nullable'],
            'link'            => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'       => ['string', 'max:255', 'nullable'],
            'description'     => ['nullable'],
            'image'           => ['string', 'max:500', 'nullable'],
            'image_credit'    => ['string', 'max:255', 'nullable'],
            'image_source'    => ['string', 'max:255', 'nullable'],
            'thumbnail'       => ['string', 'max:500', 'nullable'],
            'sequence'        => ['integer', 'min:0'],
            'public'          => ['integer', 'between:0,1'],
            'readonly'        => ['integer', 'between:0,1'],
            'root'            => ['integer', 'between:0,1'],
            'disabled'        => ['integer', 'between:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'owner_id.required' => 'Please select an owner for the task.',
            'owner_id.exists'   => 'The specified owner does not exist.',
            'job_id.required'   => 'Please select a job for the task.',
            'job_id.exists'     => 'The specified job does not exist.',
        ];
    }
}
