<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Portfolio\Ingredient;
use App\Models\Portfolio\Recipe;
use App\Models\Portfolio\Unit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
     */
    public function rules(): array
    {
        // Attach the admin_id.
        $this->merge([ 'admin_id' => Auth::guard('admin')->user()->id ]);

        return [
            'recipe_id'     => [
                'required',
                'integer',
                'in:' . Recipe::where('admin_id', Auth::guard('admin')->user()->id)->get()->pluck('id')->toArray()
            ],
            'ingredient_id' => ['required', 'integer', 'in:' . Ingredient::all()->pluck('id')->toArray()],
            'amount'        => ['string', 'max:50:', 'nullable'],
            'unit_id'       => ['integer', 'in:' . Unit::all()->pluck('id')->toArray(), 'nullable'],
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
            'admin_id'      => ['required', 'integer', 'in:' . Auth::guard('admin')->user()->id],
        ];
    }
}
