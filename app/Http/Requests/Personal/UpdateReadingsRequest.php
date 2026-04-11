<?php

namespace App\Http\Requests\Personal;

use App\Models\Dictionary\Database;
use App\Models\Personal\Reading;
use App\Models\System\Admin;
use App\Models\System\Owner;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateReadingsRequest extends FormRequest
{
    /**
     * @var Admin|Owner|null
     */
    protected Admin|null|Owner $loggedInAdmin = null;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        $this->loggedInAdmin = loggedInAdmin();

        // verify the reading exists
        $reading = Reading::query()->findOrFail($this['reading']['id']);

        // verify the admin is authorized to update the reading
        if (!$this->loggedInAdmin['is_root'] || (new Reading()->where('owner_id', $this['owner_id'])->get()->isEmpty())) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to update reading '. $reading['id'] . '.'
                    : 'Unauthorized to update reading '. $reading['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.'
            ]);
        }

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
            'owner_id'         => [
                'filled',
                'integer',
                'exists:system_db.admins,id'
            ],
            'title'            => ['filled', 'string', 'max:255', 'unique:personal_db.readings,name,' . $this['reading']['id']],
            'author'           => ['string', 'max:255', 'nullable'],
            'slug'             => [
                'filled',
                'string',
                'max:255',
                Rule::unique('personal_db.readings', 'slug')->where(function ($query) use ($ownerId) {
                    return $query->where('owner_id', $ownerId)
                        ->where('name', $this['slug'])
                        ->whereNot('id', $this['reading']['id']);
                })
            ],
            'featured'         => ['integer', 'between:0,1'],
            'summary'          => ['string', 'max:500', 'nullable'],
            'year'             => ['integer', 'between:-3000,' . date("Y"), 'nullable'],
            'publication_year' => ['integer', 'between:-3000,' . date("Y"), 'nullable'],
            'fiction'          => ['integer', 'between:0,1'],
            'nonfiction'       => ['integer', 'between:0,1'],
            'paper'            => ['integer', 'between:0,1'],
            'audio'            => ['integer', 'between:0,1'],
            'wishlist'         => ['wishlist', 'between:0,1'],
            'notes'            => ['nullable'],
            'link'             => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'        => ['string', 'max:255', 'nullable'],
            'description'      => ['nullable'],
            'disclaimer'       => ['string', 'max:500', 'nullable'],
            'image'            => ['string', 'max:500', 'nullable'],
            'image_credit'     => ['string', 'max:255', 'nullable'],
            'image_source'     => ['string', 'max:255', 'nullable'],
            'thumbnail'        => ['string', 'max:500', 'nullable'],
            'is_public'        => ['integer', 'between:0,1'],
            'is_readonly'      => ['integer', 'between:0,1'],
            'is_root'          => ['integer', 'between:0,1'],
            'is_disabled'      => ['integer', 'between:0,1'],
            'is_demo'          => ['integer', 'between:0,1'],
            'sequence'         => ['integer', 'min:0', 'nullable'],
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
            'owner_id.filled'   => 'Please select an owner for the reading.',
            'owner_id.exists'   => 'The specified owner does not exist.',
            'owner_id.in'       => 'Unauthorized to update reading.'
                . $this['reading']['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.',
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
        if (!empty($this['title'])) {
            $this->merge([
                'slug' => uniqueSlug($this['title'] . (!empty($this['author']) ? '-by-' . $this['author'] : '')),
                'personal_db.readings',
                $ownerId
            ]);
        }
    }
}
