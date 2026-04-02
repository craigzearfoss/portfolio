<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Portfolio\JobTask;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateJobTasksRequest extends FormRequest
{
    private mixed $owner_id;
    private mixed $job_id;
    private mixed $summary;
    private mixed $job_task;

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        if (!$jobTask = JobTask::find($this['job_task']['id']) ) {
            throw new Exception('Job Task ' . $this['job_task']['id'] . ' not found');
        }

        updateGate($jobTask, loggedInAdmin());

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
            'owner_id'        => ['filled','integer', 'exists:system_db.admins,id'],
            'job_id'          => ['filled', 'integer', 'exists:portfolio_db.jobs,id'],
            'summary'         => [
                'filled',
                'string',
                'max:500',
                Rule::unique('portfolio_db.job_tasks', 'summary')->where(function ($query) use ($ownerId) {
                    return $query->where('owner_id', $ownerId)
                        ->where('job_id', $this['job_id'])
                        ->where('summary', $this['summary'])
                        ->whereNot('id', $this['job_task']['id']);
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
            'owner_id.filled' => 'Please select an owner for the task.',
            'owner_id.exists' => 'The specified owner does not exist.',
            'job_id.filled'   => 'Please select a job for the task.',
            'job_id.exists'   => 'The specified job does not exist.',
            'summary.unique'  => '`' . $this['summary'] . '` has already been added.',
        ];
    }
}
