<?php

namespace App\Http\Requests\Personal;

use App\Models\Personal\Ingredient;
use App\Models\Personal\Unit;
use App\Models\System\Admin;
use App\Models\System\Owner;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 *
 */
class UpdateUnitsRequest extends FormRequest
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
        $this->loggedInAdmin = loggedInAdmin();

        // verify the unit exists
        $unit = Unit::query()->findOrFail($this['unit']['id']);

        return boolval($this->loggedInAdmin['is_root']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'         => ['filled', 'max:50', 'unique:' . Unit::class],
            'abbreviation' => ['filled', 'max:20', 'unique:' . Unit::class],
            'system'       => ['string', 'max:10', 'nullable'],
            'description'  => ['nullable'],
            'image'        => ['string', 'max:500', 'nullable'],
            'image_credit' => ['string', 'max:255', 'nullable'],
            'image_source' => ['string', 'max:255', 'nullable'],
            'thumbnail'    => ['string', 'max:500', 'nullable'],
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
            //
        ];
    }
}
