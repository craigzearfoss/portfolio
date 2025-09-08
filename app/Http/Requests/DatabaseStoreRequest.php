<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DatabaseStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check() && Auth::guard('admin')->user()->root;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:50', 'unique:databases,name'],
            'database' => ['required', 'string', 'max:50', 'unique:databases,database'],
            'tag'      => ['required', 'string', 'max:50'],
            'title'    => ['required', 'string', 'max:50'],
            'plural'   => ['required', 'string', 'max:50'],
            'guest'    => ['integer', 'between:0,1'],
            'user'     => ['integer', 'between:0,1'],
            'admin'    => ['integer', 'between:0,1'],
            'icon'     => ['string', 'max:50', 'nullable'],
            'sequence' => ['integer', 'min:0'],
            'public'   => ['integer', 'between:0,1'],
            'readonly' => ['integer', 'between:0,1'],
            'root'     => ['integer', 'between:0,1'],
            'disabled' => ['integer', 'between:0,1'],
            'admin_id' => ['integer', 'in:' . Auth::guard('admin')->user()->id],
        ];
    }
}
