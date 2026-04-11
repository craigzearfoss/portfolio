<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Portfolio\JobTask;
use App\Models\System\Admin;
use App\Models\System\Owner;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateJobTasksRequest extends FormRequest
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

        // verify the job task exists
        $jobTask = JobTask::query()->findOrFail($this['job_task']['id']);

        // verify the admin is authorized to update the job_task
        if (!$this->loggedInAdmin['is_root'] || (new JobTask()->where('owner_id', $this['owner_id'])->get()->isEmpty())) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to update job task '. $jobTask['id'] . '.'
                    : 'Unauthorized to update job task '. $jobTask['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.'
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
            'owner_id'        => [
                'filled',
                'integer',
                'exists:system_db.admins,id'
            ],
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
            'owner_id.filled' => 'Please select an owner for the job task.',
            'owner_id.exists' => 'The specified owner does not exist.',
            'owner_id.in'     => 'Unauthorized to update job task.'
                . $this['job_task']['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.',
            'job_id.filled'   => 'Please select a job for the task.',
            'job_id.exists'   => 'The specified job does not exist.',
            'summary.unique'  => '`' . $this['summary'] . '` has already been added.',
        ];
    }

    /**
     * Verifies the job task exists and the owner is authorized to update it.
     *
     * @return void
     * @throws ValidationException
     */
    protected function validateAuthorization(): void
    {
        // verify the job_task exists
        if (!JobTask::find($this['job_task']['id']) ) {
            throw ValidationException::withMessages([
                'GLOBAL' => 'Job task ' . $this['job_task']['id'] . ' not found.'
            ]);
        }

        // verify the admin is authorized to update the job_task
        if (!$this->loggedInAdmin['is_root'] || (new JobTask()->where('owner_id', $this['owner_id'])->get()->isEmpty())) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to update job task '. $this['job_task']['id'] . '.'
                    : 'Unauthorized to update job task '. $this['job_task']['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.'
            ]);
        }
    }
}
