<?php

namespace App\Http\Requests\Personal;

use App\Models\Personal\Ingredient;
use App\Models\Personal\Recipe;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRecipeIngredientsRequest extends FormRequest
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
        return [
            'owner_id'      => ['filled', 'integer', 'exists:system_db.admins,id'],
            'recipe_id'     => [
                'filled',
                'integer',
                Rule::in(Recipe::where('owner_id', $this->owner_id)->get()->pluck('id')->toArray()),
            ],
            'ingredient_id' => ['filled', 'integer', Rule::in(Ingredient::all()->pluck('id')->toArray())],
            'amount'        => ['string', 'max:50:', 'nullable'],
            'unit_id'       => ['filled', 'integer', 'exists:personal_db.units,id'],
            'qualifier'     => ['string', 'max:255:', 'nullable'],
            'description'   => ['nullable'],
            'disclaimer'    => ['string', 'max:500', 'nullable'],
            'image'         => ['string', 'max:500', 'nullable'],
            'image_credit'  => ['string', 'max:255', 'nullable'],
            'image_source'  => ['string', 'max:255', 'nullable'],
            'thumbnail'     => ['string', 'max:500', 'nullable'],
            'sequence'      => ['integer', 'min:0'],
            'public'        => ['integer', 'between:0,1'],
            'readonly'      => ['integer', 'between:0,1'],
            'root'          => ['integer', 'between:0,1'],
            'disabled'      => ['integer', 'between:0,1'],
            'demo'          => ['integer', 'between:0,1'],
        ];
    }

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
