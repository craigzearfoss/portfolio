<?php

namespace App\Http\Requests\Career;

use App\Models\Career\Event;
use App\Models\Career\Industry;
use App\Models\System\Admin;
use App\Models\System\Owner;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 *
 */
class UpdateIndustriesRequest extends FormRequest
{
    /**
     * @var Admin|Owner|null
     */
    protected Admin|null|Owner $loggedInAdmin = null;

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        $this->loggedInAdmin = loggedInAdmin();

        // verify the industry exists
        $industry = Event::query()->findOrFail($this['industry']['id']);

        return boolval($this->loggedInAdmin['is_root']);
    }

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
        if (!empty($this['name'])) {
            $this->merge([
                'slug' => uniqueSlug($this['name'], 'career_db.industries')
            ]);
        }
    }
}
