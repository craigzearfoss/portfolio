<?php

namespace App\Http\Requests\System;

use App\Http\Requests\StoreAppBaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 *
 */
class StoreBackupsRequest extends StoreAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'portfolio_db',
        'table'        => 'backups',
        'key'          => 'backup',
        'name'         => 'backup',
        'label'        => 'backup',
        'class'        => 'App\Models\System\Backup',
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
            'name'        => ['required', 'string', 'min:3'],
            'description' => ['nullable' ],
            'filepath'    => ['required', 'string'],
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
