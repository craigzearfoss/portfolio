<?php

namespace App\Http\Requests;

use App\Models\Database;
use App\Models\Owner;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ResourceStoreRequest extends FormRequest
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
            'database_id' => ['required', 'integer', Rule::in(Database::all()->pluck('id')->toArray())],
            'name'        => ['required', 'string', 'max:50', 'unique:resources,name'],
            'table'       => ['required', 'string', 'max:50', 'unique:resources,name'],
            'title'       => ['required', 'string', 'max:50'],
            'plural'      => ['required', 'string', 'max:50'],
            'guest'       => ['integer', 'between:0,1'],
            'user'        => ['integer', 'between:0,1'],
            'admin'       => ['integer', 'between:0,1'],
            'section'     => ['required', 'string', 'max:50'],
            'icon'        => ['string', 'max:50', 'nullable'],
            'sequence'    => ['integer', 'min:0'],
            'public'      => ['integer', 'between:0,1'],
            'readonly'    => ['integer', 'between:0,1'],
            'root'        => ['integer', 'between:0,1'],
            'disabled'    => ['integer', 'between:0,1'],
        ];
    }
}
