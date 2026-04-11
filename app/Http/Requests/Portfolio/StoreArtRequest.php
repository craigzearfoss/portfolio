<?php

namespace App\Http\Requests\Portfolio;

use App\Http\Requests\StoreAppBaseRequest;
use App\Models\System\Admin;
use App\Models\System\Owner;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StoreArtRequest extends StoreAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'portfolio_db',
        'name'         => 'art',
        'label'        => 'art',
        'class'        => 'App\Models\Portfolio\Art',   // like "App\Models\Portfolio\Skill" or "App\Models\System\AdminEmail"
        'table'        => 'art',
        'has_owner'    => true,
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     * @throws Exception
     */
    public function rules(): array
    {
        return [
            'owner_id'     => ['required', 'integer', 'exists:system_db.admins,id'],
            'name'         => ['required', 'string', 'max:255'],
            'artist'       => ['string', 'max:255', 'nullable'],
            'slug'         => [
                'required',
                'string',
                'max:255',
                Rule::unique('portfolio_db.art', 'slug')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('slug', $this['slug']);
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
     * Prepare the data for validation.
     *
     * @return void
     * @throws Exception
     */
    public function prepareForValidation(): void
    {
        $this->generateSlug();
    }
}
