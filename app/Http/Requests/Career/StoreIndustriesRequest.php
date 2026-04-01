<?php

namespace App\Http\Requests\Career;

use App\Models\Career\Industry;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 *
 */
class StoreIndustriesRequest extends FormRequest
{
    use ModelPermissionsTrait;

    /**
     * Determine if the admin is authorized to make this request.
     */
    public function authorize(): bool
    {
        createGate('App\Models\Career\CompanyContact', loggedInAdmin());

        return true;
    }

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
        if (!empty($this['name'])) {
            $this->merge([
                'slug' => uniqueSlug($this['name'], 'career_db.industries')
            ]);
        }
    }
}
