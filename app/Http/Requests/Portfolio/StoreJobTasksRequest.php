<?php

namespace App\Http\Requests\Portfolio;

use App\Http\Requests\StoreAppBaseRequest;
use App\Models\System\Admin;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

/**
 *
 */
class StoreJobTasksRequest extends StoreAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'portfolio_db',
        'table'        => 'job_tasks',
        'key'          => 'job_task',
        'name'         => 'job-task',
        'label'        => 'job task',
        'class'        => 'App\Models\Portfolio\JobTask',
        'has_owner'    => true,
        'has_user'     => false,
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     * @throws Exception
     */
    public function rules(): array
    {
        return [
            'owner_id'        => [
                'required',
                'integer',
                Rule::in($this->isRootAdmin
                    ? new Admin()->all()->pluck('id')->toArray()
                    : [ $this->ownerId ]
                )
            ],
            'job_id'          => ['required', 'integer', 'exists:portfolio_db.jobs,id'],
            'summary'         => [
                'required',
                'string',
                'max:500',
                Rule::unique('portfolio_db.job_tasks', 'summary')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('job_id', $this['job_id'])
                        ->where('summary', $this['summary']);
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
            'is_public'       => ['integer', 'between:0,1'],
            'is_readonly'     => ['integer', 'between:0,1'],
            'is_root'         => ['integer', 'between:0,1'],
            'is_disabled'     => ['integer', 'between:0,1'],
            'is_demo'         => ['integer', 'between:0,1'],
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
            'owner_id.required' => 'Please select an owner for the task.',
            'owner_id.exists'   => 'The specified owner does not exist.',
            'job_id.required'   => 'Please select a job for the task.',
            'job_id.exists'     => 'The specified job does not exist.',
            'summary.unique'  => '`' . $this['summary'] . '` has already been added.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
    }
}
