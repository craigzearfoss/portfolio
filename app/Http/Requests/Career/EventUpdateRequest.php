<?php

namespace App\Http\Requests\Career;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EventUpdateRequest extends FormRequest
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
            'name'        => ['string', 'max:255', 'filled'],
            'date'        => ['required', 'date_format:Y-m-d'],
            'time'        => ['required', 'date_format:H:i:s'],
            'location'    => ['string', 'max:255', 'nullable'],
            'description' => ['nullable'],
            'sequence'    => ['integer', 'min:0'],
            'public'      => ['integer', 'between:0,1'],
            'readonly'    => ['integer', 'between:0,1'],
            'root'        => ['integer', 'between:0,1'],
            'disabled'    => ['integer', 'between:0,1'],
            'admin_id'    => ['required', 'integer', 'in:' . Auth::guard('admin')->user()->id],
        ];
    }
}
