<?php

namespace App\Http\Requests;

use App\Models\Career\Company;
use App\Models\Career\CoverLetter;
use App\Models\Career\Resume;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CareerApplicationStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'admin_id'          => ['required', 'integer', 'in:' . Auth::guard('admin')->user()->id],
            'company_id'        => ['integer', 'in:' . implode(',', Company::all('id')->pluck('id')->toArray())],
            'cover_letter_id'   => ['integer', 'in:' . implode(',', CoverLetter::all('id')->pluck('id')->toArray())],
            'resume_id'         => ['integer', 'in:' . implode(',', Resume::all('id')->pluck('id')->toArray())],
            'role'              => ['required', 'string', 'max:255', 'filled'],
            'rating'            => ['integer', 'between:1,5'],
            'active'            => ['integer', 'between:0,1'],
            'post_date'         => ['date', 'nullable'],
            'apply_date'        => ['date', 'after_or_equal:post_date', 'nullable'],
            'close_date'        => ['date', 'after_or_equal:post_date', 'nullable'],
            'compensation'      => ['integer', 'nullable'],
            'compensation_unit' => ['string', 'max:20', 'nullable'],
            'duration'          => ['string', 'max:100', 'nullable'],
            'type'              => ['integer', 'between:0,3'],  // 0-permanent,1-contract,2-contract-to-hire,3-project
            'office'            => ['integer', 'between:0,1'],  // 0-onsite,1-remote,2-hybrid
            'city'              => ['string', 'max:100', 'nullable'],
            'state'             => ['string', 'max:100', 'nullable'],
            'bonus'             => ['string', 'max:255', 'nullable'],
            'w2'                => ['integer', 'between:0,1'],
            'relocation'        => ['integer', 'between:0,1'],
            'benefits'          => ['integer', 'between:0,1'],
            'vacation'          => ['integer', 'between:0,1'],
            'health'            => ['integer', 'between:0,1'],
            'source'            => ['string', 'max:255', 'nullable'],
            'link'              => ['string', 'max:255', 'nullable'],
            'contacts'          => ['string', 'max:255', 'nullable'],
            'phones'            => ['string', 'max:255', 'nullable'],
            'emails'            => ['string', 'max:255', 'nullable'],
            'website'           => ['string', 'max:255', 'nullable'],
            'description'       => ['nullable'],
            'sequence'          => ['integer', 'min:0'],
            'public'            => ['integer', 'between:0,1'],
            'disabled'          => ['integer', 'between:0,1'],
        ];
    }
}
