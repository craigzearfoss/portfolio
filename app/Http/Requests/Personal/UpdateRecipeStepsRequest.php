<?php

namespace App\Http\Requests\Personal;

use App\Models\Personal\Recipe;
use App\Models\Personal\RecipeStep;
use App\Models\System\Admin;
use App\Models\System\Owner;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateRecipeStepsRequest extends FormRequest
{
    /**
     * @var Admin|Owner|null
     */
    protected Admin|null|Owner $loggedInAdmin = null;

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        if (!$recipe_step = RecipeStep::query()->find($this['recipe_step']['id']) ) {
            throw new Exception('Recipe step ' . $this['recipe_step']['id'] . ' not found');
        }

        updateGate($recipe_step, loggedInAdmin());

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
            'owner_id'    => ['filled', 'integer', 'exists:system_db.admins,id'],
            'recipe_id'   => [
                'filled',
                'integer',
                Rule::in(new Recipe()->where('owner_id', $ownerId)->get()->pluck('id')->toArray()),
            ],
            'step'         => ['integer', 'min:1'],
            'description'  => ['nullable'],
            'image'        => ['string', 'max:500', 'nullable'],
            'image_credit' => ['string', 'max:255', 'nullable'],
            'image_source' => ['string', 'max:255', 'nullable'],
            'thumbnail'    => ['string', 'max:500', 'nullable'],
            'is_public'    => ['integer', 'between:0,1'],
            'is_readonly'  => ['integer', 'between:0,1'],
            'is_root'      => ['integer', 'between:0,1'],
            'is_disabled'  => ['integer', 'between:0,1'],
            'is_demo'      => ['integer', 'between:0,1'],
            'sequence'     => ['integer', 'min:0', 'nullable'],
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
            'owner_id.filled'  => 'Please select an owner.',
            'owner_id.exists'  => 'The specified owner does not exist.',
            'recipe_id.filled' => 'Please select a recipe.',
        ];
    }

    /**
     * Verifies the recipe step exists and the owner is authorized to update it.
     *
     * @return void
     * @throws ValidationException
     */
    protected function validateAuthorization(): void
    {
        // verify the recipe step exists
        if (!Recipe::find($this['recipe_step']['id']) ) {
            throw ValidationException::withMessages([
                'GLOBAL' => 'Recipe step ' . $this['recipe_step']['id'] . ' not found.'
            ]);
        }

        // verify the admin is authorized to update the recipe
        if (!$this->loggedInAdmin['is_root'] || (new RecipeStep()->where('owner_id', $this['owner_id'])->get()->isEmpty())) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to update recipe step '. $this['recipe_step']['id'] . '.'
                    : 'Unauthorized to update recipe step '. $this['recipe_step']['id'] . ' for ' . $this->loggedInAdmin['username'] . '.'
            ]);
        }
    }
}
