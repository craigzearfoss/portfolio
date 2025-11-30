<?php

namespace App\Http\Requests\Portfolio;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreJobTasksRequest extends FormRequest
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
            'owner_id'        => ['required', 'integer', 'exists:system_db.admins,id'],
            'job_id'          => ['required', 'integer', 'exists:portfolio_db.jobs,id'],
            'summary'         => [
                'required',
                'string',
                'max:500',
                Rule::unique('portfolio_db.job_tasks', 'summary')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('job_id', $this->job_id)
                        ->where('summary', $this->summary);
                })
            ],
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

    public function messages(): array
    {
        return [
            'owner_id.required' => 'Please select an owner for the task.',
            'owner_id.exists'   => 'The specified owner does not exist.',
            'job_id.required'   => 'Please select a job for the task.',
            'job_id.exists'     => 'The specified job does not exist.',
            'summary.unique'  => '`' . $this->summary . '` has already been added.',
        ];
    }
}
