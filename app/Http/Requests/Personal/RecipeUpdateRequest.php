<?php

namespace App\Http\Requests\Personal;

use App\Models\Owner;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RecipeUpdateRequest extends FormRequest
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
                'slug' => uniqueSlug($this['name'], 'personal_db.recipes', $this->owner_id)
            ]);
        }

        return [
            'owner_id'     => ['filled', 'integer', 'exists:core_db.admins,id'],
            'name'         => [
                'filled',
                'max:255',
                Rule::unique('personal_db.recipes')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('id', '<>', $this->recipe->id)
                        ->where('name', $this->name);
                })
            ],
            'slug'         => [
                'filled',
                'max:255',
                Rule::unique('personal_db.recipes')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('id', '<>', $this->recipe->id)
                        ->where('slug', $this->slug);
                })
            ],
            'featured'     => ['integer', 'between:0,1'],
            'summary'      => ['string', 'max:500', 'nullable'],
            'source'       => ['string', 'max:255', 'nullable'],
            'author'       => ['string', 'max:255', 'nullable'],
            'prep_time'    => ['integer', 'min:0'],
            'total_time'   => ['integer', 'min:0'],
            'main'         => ['integer', 'between:0,1'],
            'side'         => ['integer', 'between:0,1'],
            'dessert'      => ['integer', 'between:0,1'],
            'appetizer'    => ['integer', 'between:0,1'],
            'beverage'     => ['integer', 'between:0,1'],
            'breakfast'    => ['integer', 'between:0,1'],
            'lunch'        => ['integer', 'between:0,1'],
            'dinner'       => ['integer', 'between:0,1'],
            'snack'        => ['integer', 'between:0,1'],
            'notes'        => ['nullable'],
            'link'         => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'    => ['string', 'max:255', 'nullable'],
            'description'  => ['nullable'],
            'image'        => ['string', 'max:500', 'nullable'],
            'image_credit' => ['string', 'max:255', 'nullable'],
            'image_source' => ['string', 'max:255', 'nullable'],
            'thumbnail'    => ['string', 'max:500', 'nullable'],
            'sequence'     => ['integer', 'min:0'],
            'public'       => ['integer', 'between:0,1'],
            'readonly'     => ['integer', 'between:0,1'],
            'root'         => ['integer', 'between:0,1'],
            'disabled'     => ['integer', 'between:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'owner_id.filled' => 'Please select an owner for the recipe.',
            'owner_id.exists' => 'The specified owner does not exist.',
        ];
    }
}
