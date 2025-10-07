<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Owner;
use App\Models\Portfolio\Job;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class JobCoworkerStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return isRootAdmin() || ($this->owner_id == Auth::guard('admin')->user()->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Validate the owner_id. (Only root admins can add a coworker for another admin.)
        if (empty($this['owner_id'])) {
            $this->merge(['owner_id' => Auth::guard('admin')->user()->id]);
        }
        if (!isRootAdmin() && ($this->owner_id !== Auth::guard('admin')->user()->id)) {
            throw ValidationException::withMessages([
                'job_id' => 'You are not authorized to add a coworker for this admin.'
            ]);
        }

        return [
            'owner_id'        => ['integer', 'exists:core_db.admins,id'],
            'job_id'          => ['integer', 'required', 'exists:portfolio_db.jobs,id'],
            'name'            => [
                'string',
                'required',
                'max:255',
                Rule::unique('portfolio_db.job_coworkers')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('name', $this->name);
                })
            ],
            'job_title'       => ['string', 'max:100', 'nullable'],
            'level_id'        => ['integer', 'between:1,3'],
            'work_phone'      => ['string', 'max:50', 'nullable'],
            'personal_phone'  => ['string', 'max:50', 'nullable'],
            'work_email'      => ['string', 'max:255', 'nullable'],
            'personal_email'  => ['string', 'max:255', 'nullable'],
            'notes'           => ['nullable'],
            'link'            => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'       => ['string', 'max:255', 'nullable'],
            'description'     => ['nullable'],
            'image'           => ['string', 'max:255', 'nullable'],
            'image_credit'    => ['string', 'max:255', 'nullable'],
            'image_source'    => ['string', 'max:255', 'nullable'],
            'thumbnail'       => ['string', 'max:255', 'nullable'],
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
            'job_id'  => 'Please select a company.',
            'between' => 'Please select a level.'
        ];
    }
}
