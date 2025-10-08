<?php

namespace App\Http\Requests\Personal;

use App\Models\Owner;
use App\Traits\ModelPermissionsTrait;
use App\Models\Personal\Ingredient;
use App\Models\Personal\Recipe;
use App\Models\Personal\Unit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RecipeIngredientStoreRequest extends FormRequest
{
    use ModelPermissionsTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return isRootAdmin() || ($this->owner_id == Auth::guard('admin')->user()->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     * @throws \Exception
     */
    public function rules(): array
    {
        $this->checkDemoMode();

        // Validate the owner_id. (Only root admins can update a recipe for another admin.)
        if (empty($this['owner_id'])) {
            $this->merge(['owner_id' => Auth::guard('admin')->user()->id]);
        }
        if (!isRootAdmin() && ($this->owner_id !== Auth::guard('admin')->user()->id)) {
            throw ValidationException::withMessages([
                'recipe_id' => 'You are not authorized to update a recipe for this admin.'
            ]);
        }

        return [
            'owner_id'      => ['integer', 'required', 'exists:core_db.admins,id'],
            'recipe_id'     => [
                'integer',
                'required',
                Rule::in(Recipe::where('owner_id', $this->owner_id)->get()->pluck('id')->toArray())
            ],
            'ingredient_id' => ['integer', 'required', Rule::in(Ingredient::all()->pluck('id')->toArray())],
            'amount'        => ['string', 'max:50:', 'nullable'],
            'unit_id'       => ['integer', 'required', Rule::in(Unit::all()->pluck('id')->toArray()), 'nullable'],
            'qualifier'     => ['string', 'max:255:', 'nullable'],
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
