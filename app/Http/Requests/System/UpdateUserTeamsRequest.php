<?php

namespace App\Http\Requests\System;

use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\User;
use App\Models\System\UserPhone;
use App\Models\System\UserTeam;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateUserTeamsRequest extends FormRequest
{
    /**
     * @var Admin|Owner|null
     */
    protected Admin|null|Owner $loggedInAdmin = null;

    /**
     * @var User|null
     */
    protected User|null $loggedInUser = null;

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        $this->loggedInAdmin = loggedInAdmin();
        $this->loggedInUser  = loggedInUser();

        // verify the user team exists
        $userTeam = UserTeam::query()->findOrFail($this['user_team']['id']);

        if (canUpdate($userTeam, $this->loggedInAdmin)) {

            return true;

        } elseif (canUpdate($userTeam, $this->loggedInUser)) {

            return true;

        } else {

            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to update user phone ' . $userTeam['id'] . '.'
                    : 'Unauthorized to update user phone ' . $userTeam['id'] . ' for user ' . $this->loggedInUser['id'] . '.'
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     * @throws Exception
     */
    public function rules(): array
    {
        if (!$userId = $this['user_id']) {
            throw new Exception('No user_id specified.');
        }

        return [
            'user_id'      => ['filled', 'integer', 'exists:system_db.users,id'],
            'name'         => [
                'filled',
                'string',
                'min:3',
                'max:100',
                Rule::unique('system_db.user_teams', 'name')->where(function ($query) use ($userId) {
                    return $query->where('user_id', $userId)
                        ->where('name', $this['name'])
                        ->whereNot('id', $this['user_team']['id']);
                })
            ],
            'slug'          => [
                'filled',
                'string',
                'min:3',
                'max:100',
                Rule::unique('system_db.user_teams', 'name')->where(function ($query) use ($userId) {
                    return $query->where('user_id', $userId)
                        ->where('slug', $this['slug'])
                        ->whereNot('id', $this['user_team']['id']);
                })
            ],
            'abbreviation'  => [
                'filled',
                'string',
                'max:20',
                Rule::unique('system_db.user_teams', 'name')->where(function ($query) use ($userId) {
                    return $query->where('user_id', $userId)
                        ->where('abbreviation', $this['abbreviation'])
                        ->whereNot('id', $this['user_team']['id']);
                }),
                'nullable',
            ],
            'description'  => ['nullable'],
            'image'        => ['string', 'max:500', 'nullable'],
            'image_credit' => ['string', 'max:255', 'nullable'],
            'image_source' => ['string', 'max:255', 'nullable'],
            'thumbnail'    => ['string', 'max:500', 'nullable'],
            'logo'         => ['string', 'max:500', 'nullable'],
            'logo_small'   => ['string', 'max:500', 'nullable'],
            'is_public'    => ['integer', 'between:0,1'],
            'is_readonly'  => ['integer', 'between:0,1'],
            'is_root'      => ['integer', 'between:0,1'],
            'is_disabled'  => ['integer', 'between:0,1'],
            'is_demo'      => ['integer', 'between:0,1'],
            'sequence'     => ['integer', 'min:0', 'nullable'],
        ];
    }

    /**
     * Return error messages.
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'owner_id.filled' => 'Please select an owner for the user team.',
            'owner_id.exists' => 'The specified owner does not exist.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     * @throws Exception
     */
    protected function prepareForValidation(): void
    {
        if (!$userId = $this['user_id']) {
            throw new Exception('No user_id specified.');
        }

        // generate the slug
        if (!empty($this['name'])) {
            $this->merge([
                'slug' => uniqueSlug($this['name'], 'system_db.user_teams', $userId)
            ]);
        }
    }
}
