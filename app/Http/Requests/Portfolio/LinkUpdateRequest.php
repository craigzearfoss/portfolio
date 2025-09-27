<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Owner;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class LinkUpdateRequest extends FormRequest
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

        // Validate the admin_id. (Only root admins can change the admin for a link.)
        if (!empty($this['admin_id']) && !Auth::guard('admin')->user()->root
            && ($this['admin_id'] == !Auth::guard('admin')->user()->id)
        ) {
            throw new \Exception('You are not authorized to change the admin for a link.');
        }

        $ownerIds = isRootAdmin()
            ? Owner::all('id')->pluck('id')->toArray()
            : [ Auth::guard('admin')->user()->id ];

        return [
            'owner_id'     => ['required', 'integer', Rule::in($ownerIds)],
            'name'         => ['string', 'max:255', 'unique:portfolio_db.links,name,'.$this->link->id, 'filled'],
            'slug'         => ['string', 'max:255', 'unique:portfolio_db.links,slug,'.$this->link->id, 'filled'],
            'featured'     => ['integer', 'between:0,1'],
            'url'          => ['string', 'url:http,https', 'max:255', 'required'],
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
