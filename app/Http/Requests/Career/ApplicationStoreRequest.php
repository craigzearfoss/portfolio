<?php

namespace App\Http\Requests\Career;

use App\Models\Admin;
use App\Models\Career\Company;
use App\Models\Career\CoverLetter;
use App\Models\Career\Resume;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ApplicationStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return isAdmin();
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
        if (empty($this['admin_id'])) {
            $this->merge(['admin_id' => Auth::guard('admin')->user()->id]);
        }
        if (!Auth::guard('admin')->user()->root && ($this['admin_id'] == !Auth::guard('admin')->user()->id)) {
            throw new \Exception('You are not authorized to change the admin for an application.');
        }

        $adminIds = Auth::guard('admin')->user()->root
            ? Admin::all('id')->pluck('id')->toArray()
            : [Auth::guard('admin')->user()->id];

        return [
            'company_id'        => ['integer', Rule::in(Company::all('id')->pluck('id')->toArray())],
            'cover_letter_id'   => ['integer', Rule::in(CoverLetter::all('id')->pluck('id')->toArray())],
            'resume_id'         => ['integer', Rule::in(Resume::all('id')->pluck('id')->toArray())],
            'role'              => ['required', 'string', 'max:255'],
            'rating'            => ['integer', 'between:1,5'],
            'active'            => ['integer', 'between:0,1'],
            'post_date'         => ['date', 'nullable'],
            'apply_date'        => ['date', 'after_or_equal:post_date', 'nullable'],
            'close_date'        => ['date', 'after_or_equal:post_date', 'nullable'],
            'compensation'      => ['integer', 'nullable'],
            'compensation_unit' => ['string', 'max:20', 'nullable'],
            'duration'          => ['string', 'max:100', 'nullable'],
            'type_id'           => ['integer', 'between:1,5'],  // 1-permanent,2-contract,3-contract-to-hire,4-temporary,5-project
            'office_id'         => ['integer', 'between:1,3'],  // 1-onsite,2-remote,3-hybrid
            'street'            => ['string', 'max:255', 'nullable'],
            'street2'           => ['string', 'max:255', 'nullable'],
            'city'              => ['string', 'max:100', 'nullable'],
            'state'             => ['string', 'max:20', 'nullable'],
            'zip'               => ['string', 'max:20', 'nullable'],
            'country'           => ['string', 'max:100', 'nullable'],
            'latitude'          => ['numeric:strict', 'nullable'],
            'longitude'         => ['numeric:strict', 'nullable'],
            'bonus'             => ['string', 'max:255', 'nullable'],
            'w2'                => ['integer', 'between:0,1'],
            'relocation'        => ['integer', 'between:0,1'],
            'benefits'          => ['integer', 'between:0,1'],
            'vacation'          => ['integer', 'between:0,1'],
            'health'            => ['integer', 'between:0,1'],
            'job_board_id'      => ['integer', 'nullable'],
            'phone'             => ['string', 'max:20', 'nullable'],
            'phone_label'       => ['string', 'max:255', 'nullable'],
            'alt_phone'         => ['string', 'max:20', 'nullable'],
            'alt_phone_label'   => ['string', 'max:255', 'nullable'],
            'email'             => ['string', 'max:255', 'nullable'],
            'email_label'       => ['string', 'max:255', 'nullable'],
            'alt_email'         => ['string', 'max:255', 'nullable'],
            'alt_email_label'   => ['string', 'max:255', 'nullable'],
            'link'              => ['string', 'url:http,https', 'max:255', 'nullable'],
            'link_name'         => ['string', 'max:255', 'nullable'],
            'description'       => ['nullable'],
            'image'             => ['string', 'max:255', 'nullable'],
            'image_credit'      => ['string', 'max:255', 'nullable'],
            'image_source'      => ['string', 'max:255', 'nullable'],
            'thumbnail'         => ['string', 'max:255', 'nullable'],
            'sequence'          => ['integer', 'min:0'],
            'public'            => ['integer', 'between:0,1'],
            'readonly'          => ['integer', 'between:0,1'],
            'root'              => ['integer', 'between:0,1'],
            'disabled'          => ['integer', 'between:0,1'],
            'admin_id'          => ['required', 'integer', Rule::in($adminIds)],
        ];
    }
}
