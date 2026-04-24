<?php

namespace App\Http\Requests\Career;

use App\Http\Requests\StoreAppBaseRequest;
use App\Models\Career\Industry;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 *
 */
class StoreIndustriesRequest extends StoreAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'career_db',
        'table'        => 'industries',
        'key'          => 'industry',
        'name'         => 'industry',
        'label'        => 'industry',
        'class'        => 'App\Models\Career\Industry',
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
            'name'         => ['required', 'string', 'max:50', 'unique:' . Industry::class],
            'slug'         => ['required', 'string', 'max:50', 'unique:' . Industry::class],
            'abbreviation' => ['required', 'string', 'max:20', 'unique:' . Industry::class],
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
        // generate the slug
        $this->generateSlug();
    }
}
