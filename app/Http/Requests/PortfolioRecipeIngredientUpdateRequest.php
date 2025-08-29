<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PortfolioRecipeIngredientUpdateRequest extends FormRequest
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
            'name'        => ['string', 'max:255', 'unique:portfolio_db.recipe_ingredients,name,'.$this->recipe_ingredient->id, 'filled'],
            'slug'        => ['string', 'max:255', 'unique:portfolio_db.recipe_ingredients,slug,'.$this->recipe_ingredient->id, 'filled'],
            'description' => ['nullable'],
            'image'       => ['string', 'max:255', 'nullable'],
            'thumbnail'   => ['string', 'max:255', 'nullable'],
        ];
    }
}
