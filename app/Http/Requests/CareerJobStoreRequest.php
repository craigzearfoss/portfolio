<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CareerJobStoreRequest extends FormRequest
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
            'admin_id' => ['required', 'integer', 'exists:admins,id'],
            'name'     => ['required', 'string', 'max:255', 'unique:portfolio_db.jobs,name', 'filled'],
            'slug'         => ['required', 'string', 'max:255', 'unique:portfolio_db.jobs,slug', 'filled'],
            'sequence' => ['integer', 'min:0'],
            'public'   => ['integer', 'between:0,1'],
            'disabled' => ['integer', 'between:0,1'],
        ];
    }
}
