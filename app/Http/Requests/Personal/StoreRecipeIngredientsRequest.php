<?php

namespace App\Http\Requests\Personal;

use App\Models\Personal\Ingredient;
use App\Models\Personal\Recipe;
use App\Models\Personal\Unit;
use App\Traits\ModelPermissionsTrait;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRecipeIngredientsRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     * @throws Exception
     */
    public function rules(): array
    {
        return [
            'owner_id'      => ['required', 'integer', 'exists:system_db.admins,id'],
            'recipe_id'     => [
                'required',
                'integer',
                Rule::in(new Recipe()->where('owner_id', $this->owner_id)->get()->pluck('id')->toArray())
            ],
            'ingredient_id' => ['required', 'integer', Rule::in(Ingredient::all()->pluck('id')->toArray())],
            'amount'        => ['string', 'max:50:', 'nullable'],
            'unit_id'       => ['required', 'integer', 'exists:personal_db.units,id', 'nullable'],
            'qualifier'     => ['string', 'max:255:', 'nullable'],
            'description'   => ['nullable'],
            'image'         => ['string', 'max:500', 'nullable'],
            'image_credit'  => ['string', 'max:255', 'nullable'],
            'image_source'  => ['string', 'max:255', 'nullable'],
            'thumbnail'     => ['string', 'max:500', 'nullable'],
            'public'        => ['integer', 'between:0,1'],
            'readonly'      => ['integer', 'between:0,1'],
            'root'          => ['integer', 'between:0,1'],
            'disabled'      => ['integer', 'between:0,1'],
            'demo'          => ['integer', 'between:0,1'],
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
            'owner_id.required'      => 'Please select an owner.',
            'owner_id.exists'        => 'The specified owner does not exist.',
            'recipe_id.required'     => 'Please select a recipe.',
            'ingredient_id.required' => 'Please select an ingredient.',
            'unit_id.required'       => 'Please select a unit.',
        ];
    }
}
