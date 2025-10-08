<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Dictionary\Category;
use App\Models\Owner;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SkillUpdateRequest extends FormRequest
{
    use ModelPermissionsTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return isRootAdmin() || ($this->owner_id == Auth::guard('admin')->user()->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     * @throws \Exception
     */
    public function rules(): array
    {
        $this->checkDemoMode();

        // Generate the slug.
        if (!empty($this['name'])) {
            $this->merge([ 'slug' => Str::slug($this['name']
                . (!empty($this['version']) ? '-' . Str::slug($this['version']) : ''))
            ]);
        }

        // Validate the admin_id. (Only root admins can change the admin for a skill.)
        if (!empty($this['admin_id']) && !Auth::guard('admin')->user()->root
            && ($this['admin_id'] == !Auth::guard('admin')->user()->id)
        ) {
            throw new \Exception('You are not authorized to change the admin for a skill.');
        }

        return [
            'owner_id'     => ['integer', 'exists:core_db.admins,id'],
            'name'         => [
                'string',
                'filled',
                'max:255',
                Rule::unique('portfolio_db.skills')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('id', '<>', $this->skill->id)
                        ->where('name', $this->name);
                })
            ],
            'version'      => ['string', 'max:20', 'nullable'],
            'slug'         => [
                'string',
                'filled',
                'max:255',
                Rule::unique('portfolio_db.skills')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('id', '<>', $this->skill->id)
                        ->where('slug', $this->slug);
                })
            ],
            'featured'     => ['integer', 'between:0,1'],
            'summary'      => ['string', 'max:500', 'nullable'],
            'level'        => ['integer', 'between:1,10'],
            'category_id'  => ['integer', 'exists:dictionary_db.categories,id'],
            'start_year'   => ['integer', 'min:1980', 'max:'.date("Y"), 'nullable'],
            'years'        => ['integer', 'min:0'],
            'notes'        => ['nullable'],
            'link'         => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'    => ['string', 'max:255', 'nullable'],
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
}
