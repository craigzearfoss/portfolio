<?php

namespace App\Http\Requests\Personal;

use App\Models\Personal\Recipe;
use App\Traits\ModelPermissionsTrait;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRecipeStepsRequest extends FormRequest
{
    use ModelPermissionsTrait;

    /**
     * Determine if the admin is authorized to make this request.
     */
    public function authorize(): bool
    {
        createGate('App\Models\Personal\RecipeStep', loggedInAdmin());

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     * @throws Exception
     */
    public function rules(): array
    {
        if (!$ownerId = $this['owner_id']) {
            throw new Exception('No owner_id specified.');
        }

        return [
            'owner_id'    => ['required', 'integer', 'exists:system_db.admins,id'],
            'recipe_id'   => [
                'required',
                'integer',
                Rule::in(new Recipe()->where('owner_id', $ownerId)->get()->pluck('id')->toArray())
            ],
            'step'         => ['integer', 'min:1'],
            'description'  => ['nullable'],
            'image'        => ['string', 'max:500', 'nullable'],
            'image_credit' => ['string', 'max:255', 'nullable'],
            'image_source' => ['string', 'max:255', 'nullable'],
            'thumbnail'    => ['string', 'max:500', 'nullable'],
            'is_public'    => ['integer', 'between:0,1'],
            'is_readonly'  => ['integer', 'between:0,1'],
            'is_root'      => ['integer', 'between:0,1'],
            'is_disabled'  => ['integer', 'between:0,1'],
            'is_demo'      => ['integer', 'between:0,1'],
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
            'owner_id.required'  => 'Please select an owner.',
            'owner_id.exists'    => 'The specified owner does not exist.',
            'recipe_id.required' => 'Please select a recipe.',
        ];
    }
}
