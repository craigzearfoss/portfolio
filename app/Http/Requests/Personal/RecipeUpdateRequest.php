<?php

namespace App\Http\Requests\Personal;

use App\Http\Requests\Portfolio\Str;
use App\Models\Owner;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RecipeUpdateRequest extends FormRequest
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
     * @throws \Exception
     */
    public function rules(): array
    {
        // Generate the slug.
        if (!empty($this['name'])) {
            $this->merge([ 'slug' => Str::slug($this['name']) ]);
        }

        // Validate the admin_id. (Only root admins can change the admin for a recipe.)
        if (!empty($this['admin_id']) && !Auth::guard('admin')->user()->root
            && ($this['admin_id'] == !Auth::guard('admin')->user()->id)
        ) {
            throw new \Exception('You are not authorized to change the admin for a recipe.');
        }

        $ownerIds = isRootAdmin()
            ? Owner::all('id')->pluck('id')->toArray()
            : [ Auth::guard('admin')->user()->id ];

        return [
            'owner_id'     => ['required', 'integer', Rule::in($ownerIds)],
            'name'         => ['string', 'max:255', 'unique:personal_db.recipes,name,'.$this->recipe->id, 'filled'],
            'slug'         => ['string', 'max:255', 'unique:personal_db.recipes,slug,'.$this->recipe->id, 'filled'],
            'featured'     => ['integer', 'between:0,1'],
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
            'link'         => ['string', 'url:http,https', 'max:255', 'nullable'],
            'link_name'    => ['string', 'nullable'],
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
