<?php

namespace App\Http\Requests\Career;

use App\Models\Career\Company;
use App\Models\Career\CoverLetter;
use App\Models\Career\JobBoard;
use App\Models\Career\Resume;
use App\Models\Country;
use App\Models\Owner;
use App\Models\State;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ApplicationUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return isRootAdmin()
            || (isAdmin() && ($this->application->admin_id == Auth::guard('admin')->user()->id));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     * @throws \Exception
     */
    public function rules(): array
    {
        // Validate the admin_id. (Only root admins can change the admin for an application.)
        if (!empty($this['admin_id']) && !Auth::guard('admin')->user()->root
            && ($this['admin_id'] == !Auth::guard('admin')->user()->id)
        ) {
            throw new \Exception('You are not authorized to change the admin for an application.');
        }

        $ownerIds = isRootAdmin()
            ? Owner::all('id')->pluck('id')->toArray()
            : [ Auth::guard('admin')->user()->id ];

        return [
            'owner_id'             => ['integer', 'filled', Rule::in($ownerIds)],
            'company_id'           => ['integer', 'filled', Rule::in(Company::all('id')->pluck('id')->toArray())],
            'role'                 => ['string', 'required', 'max:255'],
            'job_board_id'         => ['integer', Rule::in(JobBoard::all('id')->pluck('id')->toArray())],
            'resume_id'            => ['integer', Rule::in(Resume::all('id')->pluck('id')->toArray())],
            'rating'               => ['integer', 'between:1,5'],
            'active'               => ['integer', 'between:0,1'],
            'post_date'            => ['date', 'nullable'],
            'apply_date'           => ['date', 'after_or_equal:post_date', 'nullable'],
            'close_date'           => ['date', 'after_or_equal:post_date', 'nullable'],
            'compensation_min'     => ['integer', 'nullable'],
            'compensation_max'     => ['integer', 'nullable'],
            'compensation_unit_id' => ['integer', 'nullable'],
            'duration_id'          => ['integer', 'between:1,5'],  // 1-permanent,2-contract,3-contract-to-hire,4-temporary,5-project
            'office_id'            => ['integer', 'between:1,3'],  // 1-onsite,2-remote,3-hybrid
            'schedule_id'          => ['integer', 'between:1,2'],  // 1-full-time,2-part-time
            'street'               => ['string', 'max:255', 'nullable'],
            'street2'              => ['string', 'max:255', 'nullable'],
            'city'                 => ['string', 'max:100', 'nullable'],
            'state_id'             => ['integer', Rule::in(State::all('id')->pluck('id')->toArray()), 'nullable'],
            'zip'                  => ['string', 'max:20', 'nullable'],
            'country_id'           => ['integer', Rule::in(Country::all('id')->pluck('id')->toArray()), 'nullable'],
            'latitude'             => ['numeric:strict', 'nullable'],
            'longitude'            => ['numeric:strict', 'nullable'],
            'bonus'                => ['string', 'max:255', 'nullable'],
            'w2'                   => ['integer', 'between:0,1'],
            'relocation'           => ['integer', 'between:0,1'],
            'benefits'             => ['integer', 'between:0,1'],
            'vacation'             => ['integer', 'between:0,1'],
            'health'               => ['integer', 'between:0,1'],
            'phone'                => ['string', 'max:50', 'nullable'],
            'phone_label'          => ['string', 'max:255', 'nullable'],
            'alt_phone'            => ['string', 'max:50', 'nullable'],
            'alt_phone_label'      => ['string', 'max:255', 'nullable'],
            'email'                => ['string', 'max:255', 'nullable'],
            'email_label'          => ['string', 'max:255', 'nullable'],
            'alt_email'            => ['string', 'max:255', 'nullable'],
            'alt_email_label'      => ['string', 'max:255', 'nullable'],
            'link'                 => ['string', 'url:http,https', 'max:255', 'nullable'],
            'link_name'            => ['string', 'max:255', 'nullable'],
            'description'          => ['nullable'],
            'image'                => ['string', 'max:255', 'nullable'],
            'image_credit'         => ['string', 'max:255', 'nullable'],
            'image_source'         => ['string', 'max:255', 'nullable'],
            'thumbnail'            => ['string', 'max:255', 'nullable'],
            'sequence'             => ['integer', 'min:0'],
            'public'               => ['integer', 'between:0,1'],
            'readonly'             => ['integer', 'between:0,1'],
            'root'                 => ['integer', 'between:0,1'],
            'disabled'             => ['integer', 'between:0,1'],
        ];
    }
}
