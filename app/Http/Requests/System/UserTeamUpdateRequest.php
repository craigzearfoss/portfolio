<?php

namespace App\Http\Requests\System;

use App\Models\Owner;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserTeamUpdateRequest extends FormRequest
{
    use ModelPermissionsTrait;

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
        $this->checkDemoMode();

        // Generate the slug.
        if (!empty($this['name'])) {
            $this->merge([ 'slug' => Str::slug($this['name']) ]);
        }

        // Validate the admin_id. (Only root admins can change the admin for a course.)
        if (!empty($this['admin_id']) && !Auth::guard('admin')->user()->root
            && ($this['admin_id'] == !Auth::guard('admin')->user()->id)
        ) {
            throw new \Exception('You are not authorized to change the admin for a course.');
        }

        return [
            'owner_id'     => ['integer', 'exists:core_db.admins,id'],
            'name'         => [
                'string',
                'filled',
                'min:3',
                'max:200',
                Rule::unique('portfolio_db.user_teams')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('id', '<>', $this->user_team->id)
                        ->where('name', $this->name);
                })
            ],
            'slug'         => ['string', 'filled', 'min:20', 'max:220', 'unique:core_db.user_teams,slug,'.$this->user_team->id],
            'abbreviation' => ['string', 'max:20', 'unique:core_db.user_teams.abbreviation,'.$this->user_team->id, 'nullable'],
            'description'  => ['nullable'],
            'disabled'     => ['integer', 'between:0,1'],
        ];
    }
}
