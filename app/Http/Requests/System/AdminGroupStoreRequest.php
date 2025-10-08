<?php

namespace App\Http\Requests\System;

use App\Models\AdminTeam;
use App\Models\Owner;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminGroupStoreRequest extends FormRequest
{
    use ModelPermissionsTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->checkDemoMode();

        $this->checkOwner();

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Generate the slug.
        if (!empty($this['name'])) {
            $this->merge([ 'slug' => Str::slug($this['name']) ]);
        }

        return [
            'owner_id '     => ['integer', 'exists:core_db.admins,id'],
            'admin_team_id' => ['integer', 'required', 'exists:core_db.admin_teams,id'],
            'name'          => ['string',
                'required',
                'min:3',
                'max:200',
                Rule::unique('portfolio_db.admin_groups')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('name', $this->name);
                })
            ],
            'slug'          => ['string', 'required', 'min:20', 'max:220', 'unique:core_db.admin_groups,slug'],
            'abbreviation'  => ['string', 'max:20', 'unique:core_db.admin_groups,slug', 'nullable'],
            'description'   => ['nullable'],
            'disabled'      => ['integer', 'between:0,1'],
        ];
    }
}
