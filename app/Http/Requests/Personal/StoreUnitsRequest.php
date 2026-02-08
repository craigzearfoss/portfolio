<?php

namespace App\Http\Requests\Personal;

use App\Models\Personal\Unit;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreUnitsRequest extends FormRequest
{
    use ModelPermissionsTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return isRootAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'         => ['required', 'string', 'max:50', 'unique:'.Unit::class],
            'abbreviation' => ['required', 'string', 'max:20', 'unique:'.Unit::class],
            'system'       => ['string', 'max:10', 'nullable'],
            'description'  => ['nullable'],
            'image'        => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048', 'nullable'],
            'image_credit' => ['string', 'max:255', 'nullable'],
            'image_source' => ['string', 'max:255', 'nullable'],
            'thumbnail'    => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048', 'nullable'],
            'sequence'     => ['integer', 'min:0', 'nullable'],
        ];
    }

    /**
     * Return error messages.
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            //
        ];
    }
}
