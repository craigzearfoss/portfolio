<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Owner;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProjectUpdateRequest extends FormRequest
{
    use ModelPermissionsTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->checkDemoMode();

        $this->checkOwner();

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     * @throws \Exception
     */
    public function rules(): array
    {
        // generate the slug
        if (!empty($this['name'])) {
            $this->merge([
                'slug' => uniqueSlug($this['name'], 'portrait_db.projects', $this->owner_id)
            ]);
        }

        return [
            'owner_id'         => ['filled', 'integer', 'exists:core_db.admins,id'],
            'name'             => [
                'filled',
                'string',
                'max:255',
                Rule::unique('portfolio_db.projects')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('id', '<>', $this->project->id)
                        ->where('name', $this->name);
                })
            ],
            'slug'             => [
                'filled',
                'string',
                'max:255',
                Rule::unique('portfolio_db.projects')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('id', '<>', $this->project->id)
                        ->where('slug', $this->slug);
                })
            ],
            'featured'         => ['integer', 'between:0,1'],
            'summary'          => ['string', 'max:500', 'nullable'],
            'year'             => ['integer', 'between:1980,'.date("Y"), 'nullable'],
            'language'         => ['string', 'max:50', 'nullable'],
            'language_version' => ['string', 'max:20', 'nullable'],
            'repository_url'   => ['string', 'max:255', 'nullable'],
            'repository_name'  => ['string', 'max:255', 'nullable'],
            'notes'            => ['nullable'],
            'link'             => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'        => ['string', 'max:255', 'nullable'],
            'description'      => ['nullable'],
            'image'            => ['string', 'max:500', 'nullable'],
            'image_credit'     => ['string', 'max:255', 'nullable'],
            'image_source'     => ['string', 'max:255', 'nullable'],
            'thumbnail'        => ['string', 'max:500', 'nullable'],
            'sequence'         => ['integer', 'min:0'],
            'public'           => ['integer', 'between:0,1'],
            'readonly'         => ['integer', 'between:0,1'],
            'root'             => ['integer', 'between:0,1'],
            'disabled'         => ['integer', 'between:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'owner_id.filled' => 'Please select an owner for the project.',
            'owner_id.exists' => 'The specified owner does not exist.',
        ];
    }
}
