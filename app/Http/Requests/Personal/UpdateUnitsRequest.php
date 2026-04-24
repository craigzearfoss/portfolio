<?php

namespace App\Http\Requests\Personal;

use App\Http\Requests\UpdateAppBaseRequest;
use App\Models\Personal\Unit;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 *
 */
class UpdateUnitsRequest extends UpdateAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'personal_db',
        'table'        => 'units',
        'key'          => 'unit',
        'name'         => 'unit',
        'label'        => 'unit',
        'class'        => 'App\Models\Personal\Unit',
        'has_owner'    => false,
        'has_user'     => false,
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'         => ['filled', 'max:50', 'unique:' . Unit::class],
            'abbreviation' => ['filled', 'max:20', 'unique:' . Unit::class],
            'system'       => ['string', 'max:10', 'nullable'],
            'description'  => ['nullable'],
            'image'        => ['string', 'max:500', 'nullable'],
            'image_credit' => ['string', 'max:255', 'nullable'],
            'image_source' => ['string', 'max:255', 'nullable'],
            'thumbnail'    => ['string', 'max:500', 'nullable'],
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

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
    }
}
