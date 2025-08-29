<?php

namespace App\Http\Requests\Career;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CareerJobUpdateRequest extends FormRequest
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
            'admin_id' => ['integer', 'in:' . Auth::guard('admin')->user()->id],
            'name'     => ['string', 'max:255', 'unique:portfolio_db.jobs,name,'.$this->job->id, 'filled'],
            'slug'     => ['string', 'max:255', 'unique:portfolio_db.jobs,slug,'.$this->job->id, 'filled'],
            'sequence' => ['integer', 'min:0'],
            'public'   => ['integer', 'between:0,1'],
            'readonly' => ['integer', 'between:0,1'],
            'root'     => ['integer', 'between:0,1'],
            'disabled' => ['integer', 'between:0,1'],
        ];
    }
}
