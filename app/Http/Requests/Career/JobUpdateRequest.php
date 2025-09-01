<?php

namespace App\Http\Requests\Career;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class obUpdateRequest extends FormRequest
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
            'name'       => ['string', 'max:255', 'unique:portfolio_db.jobs,name,'.$this->job->id, 'filled'],
            'slug'       => ['string', 'max:255', 'unique:portfolio_db.jobs,slug,'.$this->job->id, 'filled'],
            'role'       => ['string', 'max:255',],
            'start_date' => ['date', 'nullable'],
            'end_date'   => ['date', 'after_or_equal:start_date', 'nullable'],
            'sequence'   => ['integer', 'min:0'],
            'public'     => ['integer', 'between:0,1'],
            'readonly'   => ['integer', 'between:0,1'],
            'root'       => ['integer', 'between:0,1'],
            'disabled'   => ['integer', 'between:0,1'],
            'admin_id'   => ['integer', 'in:' . Auth::guard('admin')->user()->id],
        ];
    }
}
