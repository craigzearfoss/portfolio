<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ResourceStoreRequest extends FormRequest
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
            'admin_id'    => ['required', 'integer', 'in:' . Auth::guard('admin')->user()->id],
            'database_id' => ['required', 'integer', 'min:1','filled'],
            'type'        => ['required', 'string', 'max:50'],
            'name'        => ['required', 'string', 'max:50'],
            'plural'      => ['required', 'string', 'max:50'],
            'section'     => ['required', 'string', 'max:50'],
            'icon'        => ['string', 'max:50', 'nullable'],
            'sequence'    => ['integer', 'min:0'],
            'public'      => ['integer', 'between:0,1'],
            'disabled'    => ['integer', 'between:0,1'],
        ];
    }
}
