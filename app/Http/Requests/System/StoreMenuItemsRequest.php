<?php

namespace App\Http\Requests\System;

use App\Models\System\MenuItem;
use App\Rules\CaseInsensitiveNotIn;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreMenuItemsRequest extends FormRequest
{
    use ModelPermissionsTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return isRootAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'parent_id'   => [
                'integer',
                Rule::in(MenuItem::whereNot('id', $this->id)->get('id')->pluck('id')->toArray()),
                'nullable'
            ],
            'database_id' => ['integer', 'exists:core_db.databases,id', 'nullable'],
            'resource_id' => ['integer', 'exists:core_db.resources,id', 'nullable'],
            'name'        => ['string', 'max:255'],
            'route'       => ['string', 'max:255', 'nullable'],
            'icon'        => ['string', 'max:50', 'nullable'],
            'guest'       => ['integer', 'between:0,1'],
            'user'        => ['integer', 'between:0,1'],
            'admin'       => ['integer', 'between:0,1'],
            'level'       => ['integer'],
            'sequence'    => ['integer', 'min:0'],
            'public'      => ['integer', 'between:0,1'],
            'readonly'    => ['integer', 'between:0,1'],
            'root'        => ['integer', 'between:0,1'],
            'disabled'    => ['integer', 'between:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'database_id.exists' => 'The specified database does not exist.',
            'resource_id.exists' => 'The specified resource does not exist.',
        ];
    }
}
