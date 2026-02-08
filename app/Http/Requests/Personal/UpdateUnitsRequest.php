<?php

namespace App\Http\Requests\Personal;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUnitsRequest extends FormRequest
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
            'name'         => ['filled', 'max:50', 'unique:personal_db.units,name,'.$this->unit->id],
            'abbreviation' => ['filled', 'max:20', 'unique:personal_db.units,abbreviation,'.$this->unit->id],
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
