<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Owner;
use App\Models\Dictionary\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SkillStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
        // Generate the slug.
        if (!empty($this['name'])) {
            $this->merge([ 'slug' => Str::slug($this['name']) ]);
        }

        // Validate the owner_id. (Only root admins can add a skill for another admin.)
        if (empty($this['owner_id'])) {
            $this->merge(['owner_id' => Auth::guard('admin')->user()->id]);
        }
        if (!isRootAdmin() && ($this->owner_id !== Auth::guard('admin')->user()->id)) {
            throw ValidationException::withMessages([
                'name' => 'You are not authorized to add a skill for this admin.'
            ]);
        }

        return [
            'owner_id'     => ['integer', 'exists:core_db.admins,id'],
            'name'         => [
                'string',
                'required',
                'max:255',
                Rule::unique('portfolio_db.skills')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('name', $this->name);
                })
            ],
            'version'      => ['string', 'max:20', 'nullable'],
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
            'image'        => ['string', 'max:255', 'nullable'],
            'image_credit' => ['string', 'max:255', 'nullable'],
            'image_source' => ['string', 'max:255', 'nullable'],
            'thumbnail'    => ['string', 'max:255', 'nullable'],
            'sequence'     => ['integer', 'min:0'],
            'public'       => ['integer', 'between:0,1'],
            'readonly'     => ['integer', 'between:0,1'],
            'root'         => ['integer', 'between:0,1'],
            'disabled'     => ['integer', 'between:0,1'],
        ];
    }
}
