<?php

namespace App\Http\Requests\Personal;

use App\Models\Owner;
use App\Models\Personal\Ingredient;
use App\Models\Personal\Recipe;
use App\Models\Personal\Unit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RecipeIngredientStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     * @throws \Exception
     */
    public function rules(): array
    {
        // Validate the admin_id. (Only root admins can change the admin for a recipe ingredient.)
        if (empty($this['admin_id'])) {
            $this->merge(['admin_id' => Auth::guard('admin')->user()->id]);
        }
        if (!Auth::guard('admin')->user()->root && ($this['admin_id'] == !Auth::guard('admin')->user()->id)) {
            throw new \Exception('You are not authorized to change the admin for a recipe ingredient.');
        }

        $ownerIds = isRootAdmin()
            ? Owner::all('id')->pluck('id')->toArray()
            : [ Auth::guard('admin')->user()->id ];

        return [
            'owner_id'      => ['integer', 'required', Rule::in($ownerIds)],
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
            'image'         => ['string', 'max:255', 'nullable'],
            'image_credit'  => ['string', 'max:255', 'nullable'],
            'image_source'  => ['string', 'max:255', 'nullable'],
            'thumbnail'     => ['string', 'max:255', 'nullable'],
            'sequence'      => ['integer', 'min:0'],
            'public'        => ['integer', 'between:0,1'],
            'readonly'      => ['integer', 'between:0,1'],
            'root'          => ['integer', 'between:0,1'],
            'disabled'      => ['integer', 'between:0,1'],
        ];
    }
}
