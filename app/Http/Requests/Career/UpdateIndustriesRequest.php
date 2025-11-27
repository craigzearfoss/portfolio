<?php

namespace App\Http\Requests\Career;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UpdateIndustriesRequest extends FormRequest
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
        // generate the slug
        if (!empty($this['name'])) {
            $this->merge([
                'slug' => uniqueSlug($this['name'], 'career_db.industries')
            ]);
        }

        return [
            'name'         => ['filled', 'string', 'max:50', 'unique:career_db.industries,name,'.$this->industry->id],
            'slug'         => ['filled', 'string', 'max:50', 'unique:career_db.industries,slug,'.$this->industry->id],
            'abbreviation' => ['filled', 'string', 'max:20', 'unique:career_db.industries,abbreviation,'.$this->industry->id],
        ];
    }
}
