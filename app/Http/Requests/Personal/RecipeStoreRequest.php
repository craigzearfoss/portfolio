<?php

namespace App\Http\Requests\Personal;

use App\Models\Owner;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RecipeStoreRequest extends FormRequest
{
    use ModelPermissionsTrait;

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
        $this->checkDemoMode();

        // Generate the slug.
        if (!empty($this['name'])) {
            $this->merge([ 'slug' => Str::slug($this['name']) ]);
        }

        // Validate the owner_id. (Only root admins can add a recipe for another admin.)
        if (empty($this['owner_id'])) {
            $this->merge(['owner_id' => Auth::guard('admin')->user()->id]);
        }
        if (!isRootAdmin() && ($this->owner_id !== Auth::guard('admin')->user()->id)) {
            throw ValidationException::withMessages([
                'name' => 'You are not authorized to add a recipe for this admin.'
            ]);
        }

        return [
            'owner_id'     => ['integer', 'required', 'exists:core_db.admins,id'],
            'name'         => [
                'string',
                'required',
                'max:255',
                Rule::unique('personal_db.recipes')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('name', $this->name);
                })
            ],
            'slug'         => [
                'string',
                'required',
                'max:255',
                Rule::unique('personal_db.recipes')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('slug', $this->slug);
                })
            ],
            'featured'     => ['integer', 'between:0,1'],
            'summary'      => ['string', 'max:500', 'nullable'],
            'source'       => ['string', 'max:255', 'nullable'],
            'author'       => ['string', 'max:255', 'nullable'],
            'prep_time'    => ['integer', 'min:0'],
            'total_time'   => ['integer', 'min:0'],
            'main'         => ['integer', 'between:0,1'],
            'side'         => ['integer', 'between:0,1'],
            'dessert'      => ['integer', 'between:0,1'],
            'appetizer'    => ['integer', 'between:0,1'],
            'beverage'     => ['integer', 'between:0,1'],
            'breakfast'    => ['integer', 'between:0,1'],
            'lunch'        => ['integer', 'between:0,1'],
            'dinner'       => ['integer', 'between:0,1'],
            'snack'        => ['integer', 'between:0,1'],
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
