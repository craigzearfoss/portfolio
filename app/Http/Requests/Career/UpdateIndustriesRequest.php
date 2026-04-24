<?php

namespace App\Http\Requests\Career;

use App\Http\Requests\UpdateAppBaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 *
 */
class UpdateIndustriesRequest extends UpdateAppBaseRequest
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
            'name'         => ['filled', 'string', 'max:50', 'unique:career_db.industries,name,' . $this['industry']['id']],
            'slug'         => ['filled', 'string', 'max:50', 'unique:career_db.industries,slug,' . $this['industry']['id']],
            'abbreviation' => ['filled', 'string', 'max:20', 'unique:career_db.industries,abbreviation,' . $this['industry']['id']],
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
