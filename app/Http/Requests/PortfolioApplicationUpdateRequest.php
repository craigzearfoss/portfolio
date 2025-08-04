<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioApplicationUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'role'              => ['string', 'min:1', 'max:255'],
            'rating'            => ['integer', 'between:1,5'],
            'active'            => ['integer', 'between:0,1'],
            'post_date'         => ['nullable', 'date'],
            'apply_date'        => ['nullable', 'date', 'after_or_equal:post_date'],
            'close_date'        => ['nullable', 'date', 'after_or_equal:post_date'],
            'compensation'      => ['nullable', 'integer'],
            'compensation_unit' => ['nullable', 'string', 'max:20'],
            'duration'          => ['nullable', 'string', 'max:100'],
            'type'              => ['integer', 'between:0,3'],  // 0-permanent,1-contract,2-contract-to-hire,3-project
            'office'            => ['integer', 'between:0,1'],  // 0-onsite,1-remote,2-hybrid
            'city'              => ['nullable', 'string', 'max:100'],
            'state'             => ['nullable', 'string', 'max:100'],
            'bonus'             => ['nullable', 'string', 'max:255'],
            'w2'                => ['integer', 'between:0,1'],
            'relocation'        => ['integer', 'between:0,1'],
            'benefits'          => ['integer', 'between:0,1'],
            'vacation'          => ['integer', 'between:0,1'],
            'health'            => ['integer', 'between:0,1'],
            'source'            => ['nullable', 'string', 'max:255'],
            'link'              => ['nullable', 'string', 'max:255'],
            'contacts'          => ['nullable', 'string', 'max:255'],
            'phones'            => ['nullable', 'string', 'max:255'],
            'emails'            => ['nullable', 'string', 'max:255'],
            'website'           => ['nullable', 'string', 'max:255'],
            'description'       => ['nullable'],
        ];
    }
}
