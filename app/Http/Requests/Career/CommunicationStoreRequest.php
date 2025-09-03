<?php

namespace App\Http\Requests\Career;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CommunicationStoreRequest extends FormRequest
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
            'subject'   => ['required', 'string', 'max:255'],
            'date'      => ['required', 'date_format:Y-m-d'],
            'time'      => ['required', 'date_format:H:i:s'],
            'body'      => ['required'],
            'sequence'  => ['integer', 'min:0'],
            'public'    => ['integer', 'between:0,1'],
            'readonly'  => ['integer', 'between:0,1'],
            'root'      => ['integer', 'between:0,1'],
            'disabled'  => ['integer', 'between:0,1'],
            'admin_id'  => ['required', 'integer', 'in:' . Auth::guard('admin')->user()->id],
        ];
    }
}
