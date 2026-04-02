<?php

namespace App\Http\Requests\Personal;

use App\Models\Personal\Ingredient;
use App\Models\Personal\RecipeIngredient;
use App\Models\Personal\Recipe;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRecipeIngredientsRequest extends FormRequest
{
    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        if (!$recipe_ingredient = RecipeIngredient::find($this['recipe_ingredient']['id']) ) {
            throw new Exception('Recipe ingredient ' . $this['recipe_ingredient']['id'] . ' not found');
        }

        updateGate($recipe_ingredient, loggedInAdmin());

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
            'owner_id'      => ['filled', 'integer', 'exists:system_db.admins,id'],
            'recipe_id'     => [
                'filled',
                'integer',
                Rule::in(new Recipe()->where('owner_id', $ownerId)->get()->pluck('id')->toArray()),
            ],
            'ingredient_id' => ['filled', 'integer', Rule::in(Ingredient::all()->pluck('id')->toArray())],
            'amount'        => ['string', 'max:50:', 'nullable'],
            'unit_id'       => ['filled', 'integer', 'exists:personal_db.units,id', 'nullable'],
            'qualifier'     => ['string', 'max:255:', 'nullable'],
            'description'   => ['nullable'],
            'image'         => ['string', 'max:500', 'nullable'],
            'image_credit'  => ['string', 'max:255', 'nullable'],
            'image_source'  => ['string', 'max:255', 'nullable'],
            'thumbnail'     => ['string', 'max:500', 'nullable'],
            'is_public'     => ['integer', 'between:0,1'],
            'is_readonly'   => ['integer', 'between:0,1'],
            'is_root'       => ['integer', 'between:0,1'],
            'is_disabled'   => ['integer', 'between:0,1'],
            'is_demo'       => ['integer', 'between:0,1'],
            'sequence'      => ['integer', 'min:0', 'nullable'],
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
            'owner_id.filled'      => 'Please select an owner.',
            'owner_id.exists'      => 'The specified owner does not exist.',
            'recipe_id.filled'     => 'Please select a recipe.',
            'ingredient_id.filled' => 'Please select an ingredient.',
            'unit_id.filled'       => 'Please select a unit.',
        ];
    }
}
