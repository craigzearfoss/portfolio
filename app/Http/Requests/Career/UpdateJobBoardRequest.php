<?php

namespace App\Http\Requests\Career;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UpdateJobBoardRequest extends FormRequest
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
                'slug' => uniqueSlug($this['name'], 'career_db.job_boards')
            ]);
        }

        return [
            'name'          => ['filled','string', 'max:100', 'unique:career_db.job_boards,name,'.$this->jobBoard->id],
            'slug'          => ['filled', 'string', 'max:100', 'unique:career_db.job_boards,slug,'.$this->jobBoard->id],
            'primary'       => ['integer', 'between:0,1'],
            'local'         => ['integer', 'between:0,1'],
            'regional'      => ['integer', 'between:0,1'],
            'national'      => ['integer', 'between:0,1'],
            'international' => ['integer', 'between:0,1'],
            'link'          => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'     => ['string', 'max:255', 'nullable'],
            'description'   => ['nullable'],
            'image'         => ['string', 'max:500', 'nullable'],
            'image_credit'  => ['string', 'max:255', 'nullable'],
            'image_source'  => ['string', 'max:255', 'nullable'],
            'thumbnail'     => ['string', 'max:500', 'nullable'],
            'sequence'      => ['integer', 'min:0'],
            'public'        => ['integer', 'between:0,1'],
            'readonly'      => ['integer', 'between:0,1'],
            'root'          => ['integer', 'between:0,1'],
            'disabled'      => ['integer', 'between:0,1'],
        ];
    }
}
