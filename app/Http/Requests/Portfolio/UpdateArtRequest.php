<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Portfolio\Art;
use App\Models\System\Admin;
use App\Models\System\Owner;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateArtRequest extends FormRequest
{
    /**
     * @var Admin|Owner|null
     */
    protected Admin|null|Owner $loggedInAdmin = null;

    /**
     * @var int|null
     */
    protected int|null $ownerId = null;

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        $this->loggedInAdmin = loggedInAdmin();

        if (!$this->ownerId = $this['owner_id'] ?? null) {
            throw ValidationException::withMessages(['GLOBAL' => 'Now owner_id specified']);
        };

        // verify the art exists
        $art = Art::query()->findOrFail($this['art']['id']);

        // verify the admin is authorized to update the art
        if (!$this->loggedInAdmin['is_root'] || (new Art()->where('owner_id', $this['owner_id'])->get()->isEmpty())) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to update art '. $art['id'] . '.'
                    : 'Unauthorized to update art '. $art['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.'
            ]);
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     *
     * @throws Exception
     */
    public function rules(): array
    {
        if (!$ownerId = $this['owner_id']) {
            throw new Exception('No owner_id specified.');
        }

        return [
            'owner_id'     => [
                'filled',
                'integer',
                'exists:system_db.admins,id'
            ],
            'name'         => ['filled', 'string', 'max:255'],
            'artist'       => ['string', 'max:255', 'nullable'],
            'slug'         => [
                'filled',
                'string',
                'max:255',
                Rule::unique('portfolio_db.art', 'slug')->where(function ($query) use ($ownerId) {
                    return $query->where('owner_id', $ownerId)
                        ->where('slug', $this['art']['slug'])
                        ->whereNot('id', $this['art']['id']);
                })
            ],
            'featured'     => ['integer', 'between:0,1'],
            'summary'      => ['string', 'max:500', 'nullable'],
            'year'         => ['integer', 'between:-2000,'.date("Y"), 'nullable'],
            'notes'        => ['nullable'],
            'link'         => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'    => ['string', 'max:255', 'nullable'],
            'description'  => ['nullable'],
            'disclaimer'   => ['string', 'max:500', 'nullable'],
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
            'owner_id.filled' => 'Please select an owner for the art.',
            'owner_id.exists' => 'The specified owner does not exist.',
            'owner_id.in'     => 'Unauthorized to update art.'
                . $this['art']['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     * @throws Exception
     */
    public function prepareForValidation(): void
    {
        if (!$ownerId = $this['owner_id']) {
            throw new Exception('No owner_id specified.');
        }

        // generate the slug
        if (!empty($this['name'])) {
            $this->merge([
                'slug'  => uniqueSlug(
                    $this['name']. (!empty($this['artist']) ? ' by ' . $this['artist'] : ''),
                    'portfolio_db.art',
                    $ownerId
                ),
            ]);
        }
    }
}
