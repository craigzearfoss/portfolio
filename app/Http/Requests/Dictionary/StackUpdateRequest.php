<?php

namespace App\Http\Requests\Dictionary;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StackUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check() && Auth::guard('admin')->user()->root;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if (!empty($this['name'])) {
            $this->merge([ 'slug' => Str::slug($this['name']) ]);
        }

        return [
            'full_name'    => ['string', 'max:255', 'unique:dictionary_db.stacks,full_name,'.$this->stack->id, 'filled'],
            'name'         => ['string', 'max:255', 'unique:dictionary_db.stacks,name,'.$this->stack->id, 'filled'],
            'slug'         => ['string', 'max:255', 'unique:dictionary_db.stacks,slug,'.$this->stack->id, 'filled'],
            'abbreviation' => ['string', 'max:20', 'nullable'],
            'definition'   => ['string', 'max:255', 'nullable'],
            'open_source'  => ['integer', 'between:0,1'],
            'proprietary'  => ['integer', 'between:0,1'],
            'compiled'     => ['integer', 'between:0,1'],
            'owner'        => ['string', 'max:255', 'nullable'],
            'wikipedia'    => ['string', 'max:255', 'nullable'],
            'link'         => ['string', 'max:255', 'nullable'],
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
