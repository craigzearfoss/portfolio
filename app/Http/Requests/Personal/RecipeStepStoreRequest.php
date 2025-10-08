<?php

namespace App\Http\Requests\Personal;

use App\Models\Owner;
use App\Traits\ModelPermissionsTrait;
use App\Models\Personal\Recipe;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RecipeStepStoreRequest extends FormRequest
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
            'owner_id'    => ['required', 'integer', 'exists:core_db.admins,id'],
            'recipe_id'   => [
                'required',
                'integer',
                Rule::in(Recipe::where('owner_id', $this->owner_id)->get()->pluck('id')->toArray())
            ],
            'step'         => ['integer', 'min:1'],
            'description'  => ['nullable'],
            'image'        => ['string', 'max:500', 'nullable'],
            'image_credit' => ['string', 'max:255', 'nullable'],
            'image_source' => ['string', 'max:255', 'nullable'],
            'thumbnail'    => ['string', 'max:500', 'nullable'],
            'sequence'     => ['integer', 'min:0'],
            'public'       => ['integer', 'between:0,1'],
            'readonly'     => ['integer', 'between:0,1'],
            'root'         => ['integer', 'between:0,1'],
            'disabled'     => ['integer', 'between:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'owner_id.required'  => 'Please select an owner.',
            'owner_id.exists'    => 'The specified owner does not exist.',
            'recipe_id.required' => 'Please select a recipe.',
        ];
    }
}
