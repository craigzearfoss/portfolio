<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ResourceUpdateRequest extends FormRequest
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
            'admin_id'             => ['integer', 'in:' . Auth::guard('admin')->user()->id],
            'type'                 => ['string', 'max:50', 'filled'],
            'name'                 => ['string', 'max:50', 'filled'],
            'plural'               => ['string', 'max:50', 'filled'],
            'icon'                 => ['string', 'max:50', 'nullable'],
            'resource_database_id' => ['string', 'max:50', 'filled'],
            'sequence'             => ['integer', 'min:0'],
            'public'               => ['integer', 'between:0,1'],
            'disabled'             => ['integer', 'between:0,1'],
        ];
    }
}
