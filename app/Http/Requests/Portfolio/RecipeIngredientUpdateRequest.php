<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Portfolio\Ingredient;
use App\Models\Portfolio\Recipe;
use App\Models\Portfolio\Unit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RecipeIngredientUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'recipe_id'     => [
                'required',
                'integer',
                'in:' . Recipe::where('admin_id', Auth::guard('admin')->user()->id)->get()->pluck('id')->toArray()
            ],
            'ingredient_id' => ['required', 'integer', 'in:' . Ingredient::all()->pluck('id')->toArray()],
            'amount'        => ['required', 'numeric', 'min:0:'],
            'unit_id'       => ['required', 'integer', 'in:' . Unit::all()->pluck('id')->toArray()],
            'description'   => ['nullable'],
            'image'         => ['string', 'max:255', 'nullable'],
            'thumbnail'     => ['string', 'max:255', 'nullable'],
            'sequence'      => ['integer', 'min:0'],
            'public'        => ['integer', 'between:0,1'],
            'readonly'      => ['integer', 'between:0,1'],
            'root'          => ['integer', 'between:0,1'],
            'disabled'      => ['integer', 'between:0,1'],
            'admin_id'      => ['integer', 'in:' . Auth::guard('admin')->user()->id],
        ];
    }
}
