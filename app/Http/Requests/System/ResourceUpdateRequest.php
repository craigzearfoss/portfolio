<?php

namespace App\Http\Requests;

use App\Models\Database;
use App\Models\Owner;
use App\Models\Resource;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ResourceUpdateRequest extends FormRequest
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
            'owner_id'    => ['integer', 'filled', Rule::in($ownerIds)],
            'database_id' => ['integer', 'filled', Rule::in(Database::all()->pluck('id')->toArray())],
            'name'        => ['string', 'filled', 'max:50', 'unique:resources,name,'.$this->resources->id],
            'parent_id'   => ['integer', Rule::in(Resource::where('id', '<>', $this->id)->all()->pluck('id')->toArray()), 'nullable'],            'table'       => ['string', 'filled', 'max:50', 'unique:resources,table,'.$this->resources->id],
            'title'       => ['string', 'filled', 'max:50'],
            'plural'      => ['string', 'filled', 'max:50'],
            'guest'       => ['integer', 'between:0,1'],
            'user'        => ['integer', 'between:0,1'],
            'admin'       => ['integer', 'between:0,1'],
            'icon'        => ['string', 'max:50', 'nullable'],
            'level'       => ['integer'],
            'sequence'    => ['integer', 'min:0'],
            'public'      => ['integer', 'between:0,1'],
            'readonly'    => ['integer', 'between:0,1'],
            'root'        => ['integer', 'between:0,1'],
            'disabled'    => ['integer', 'between:0,1'],
        ];
    }
}
