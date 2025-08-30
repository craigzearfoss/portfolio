<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Portfolio\Recipe;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RecipeStepUpdateRequest extends FormRequest
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
            'admin_id'    => ['integer', 'in:' . Auth::guard('admin')->user()->id],
            'recipe_id'   => [
                'required',
                'integer',
                'in:' . Recipe::where('admin_id', Auth::guard('admin')->user()->id)->get()->pluck('id')->toArray()
            ],
            'step'        => ['integer', 'min:1'],
            'description' => ['nullable'],
            'image'       => ['string', 'max:255', 'nullable'],
            'thumbnail'   => ['string', 'max:255', 'nullable'],
            'sequence'    => ['integer', 'min:0'],
            'public'      => ['integer', 'between:0,1'],
            'readonly'    => ['integer', 'between:0,1'],
            'root'        => ['integer', 'between:0,1'],
            'disabled'    => ['integer', 'between:0,1'],
        ];
    }
}
