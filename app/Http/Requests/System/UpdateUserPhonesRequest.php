<?php

namespace App\Http\Requests\System;

use App\Http\Requests\UpdateAppBaseRequest;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/**
 *
 */
class UpdateUserPhonesRequest extends UpdateAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'portfolio_db',
        'table'        => 'user_phones',
        'key'          => 'user_phone',
        'name'         => 'user-phone',
        'label'        => 'user phone',
        'class'        => 'App\Models\System\UserPhone',
        'has_owner'    => false,
        'has_user'     => true,
    ];

    /**
     * Determine if the admin or user is authorized to make this request and set some class variables.
     *
     * @throws ValidationException
     */
    public function authorize(): bool
    {
        // get the currently logged-in admin and user
        $this->loggedInAdmin = loggedInAdmin();
        $this->loggedInUser  = loggedInUser();

        if ($this->props['has_owner']) {
            if (!$this->ownerId = $this['owner_id'] ?? null) {
                throw ValidationException::withMessages([ 'GLOBAL' => 'No owner_id provided.' ]);
            }
        }

        // verify the resource exists
        $this->resource = $this->props['class']::findOrFail($this[$this->props['key']]['id']);

        if (canUpdate($this->resource, $this->loggedInAdmin)) {

            return true;

        } elseif (canUpdate($this->resource, $this->loggedInUser)) {

            return true;

        } else {

            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to update ' . $this->props['label'] . '.'
                    : 'Unauthorized to update ' . $this->props['label'] . ' ' . $this->resource['id'] . '.'
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
            'phone'        => [
                'filled',
                'string',
                'max:20',
                Rule::unique('system_db.admin_phones', 'phone')->where(function ($query) use ($userId) {
                    return $query->where('user_id', $userId)
                        ->where('phone', $this['phone']);
                })
            ],
            'label'        => ['string', 'max:100', 'nullable'],
            'description'  => ['nullable'],
            'notes'        => ['nullable'],
            'is_public'    => ['integer', 'between:0,1'],
            'is_readonly'  => ['integer', 'between:0,1'],
            'is_root'      => ['integer', 'between:0,1'],
            'is_disabled'  => ['integer', 'between:0,1'],
            'is_demo'      => ['integer', 'between:0,1'],
            'sequence'     => ['integer', 'min:0', 'nullable'],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
    }
}
