<?php

namespace App\Http\Requests;

use App\Models\Owner;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DatabaseUpdateRequest extends FormRequest
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
        $ownerIds = isRootAdmin()
            ? Owner::all('id')->pluck('id')->toArray()
            : [ Auth::guard('admin')->user()->id ];

        return [
            'owner_id'    => ['required', 'integer', Rule::in($ownerIds)],
            'name'        => ['string', 'max:50', 'unique:databases,name,'.$this->databases->id, 'filled'],
            'database'    => ['string', 'max:50', 'unique:databases,database,'.$this->databases->id, 'filled'],
            'tag'         => ['string', 'max:50', 'filled'],
            'title'       => ['string', 'max:50', 'filled'],
            'plural'      => ['string', 'max:50', 'filled'],
            'front'       => ['integer', 'between:0,1'],
            'user'        => ['integer', 'between:0,1'],
            'admin'       => ['integer', 'between:0,1'],
            'icon'        => ['string', 'max:50', 'nullable'],
            'sequence'    => ['integer', 'min:0'],
            'public'      => ['integer', 'between:0,1'],
            'readonly'    => ['integer', 'between:0,1'],
            'root'        => ['integer', 'between:0,1'],
            'disabled'    => ['integer', 'between:0,1'],
        ];
    }
}
