<?php

namespace App\Http\Requests;

use App\Models\Owner;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminTeamUpdateRequest extends FormRequest
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

        $ownerIds = isRootAdmin()
            ? Owner::all('id')->pluck('id')->toArray()
            : [ Auth::guard('admin')->user()->id ];

        return [
            'owner_id'     => ['required', 'integer', Rule::in($ownerIds)],
            'name'         => ['string', 'min:3', 'max:200', 'unique:core_db.admin_teams,name,'.$this->admin_team->id, 'filled'],
            'slug'         => ['string', 'min:20', 'max:220', 'unique:core_db.admin_teams,slug,'.$this->admin_team->id, 'filled'],
            'abbreviation' => ['string', 'max:20', 'unique:core_db.admin_teams.abbreviation,'.$this->admin_team->id, 'nullable'],
            'description'  => ['nullable'],
            'disabled'     => ['integer', 'between:0,1'],
        ];
    }
}
