<?php

namespace App\Http\Requests;

use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\User;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;

class StoreAppBaseRequest extends FormRequest
{

    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => '',   // like "system_db","dictionary_db", or "portfolio_db"
        'name'         => '',   // like "award", "admin_mail", or "operating_system"
        'label'        => '',   // like "award", "admin email", or "operating system"
        'class'        => '',   // like "App\Models\Portfolio\Skill" or "App\Models\System\AdminEmail"
        'table'        => '',   // like "awards", "admin_emails", or "operating_systems"
        'has_owner'    => false,    // do resource table entries have owners?
    ];

    /**
     * The currently logged-in admin.
     *
     * @var Admin|Owner|null
     */
    protected Admin|null|Owner $loggedInAdmin = null;

    /**
     * The currently logged-in user.
     *
     * @var User|null
     */
    protected User|null $loggedInUser = null;

    /**
     * The id of the owner of the company.
     *
     * @var int|null
     */
    protected int|null $ownerId = null;

    /**
     * Determine if the admin is authorized to make this request.
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

        if (!canCreate($this->props['class'], $this->loggedInAdmin)) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to create ' . $this->props['name'] . '.'
                    : 'Unauthorized to create ' . $this->props['name']. ' for admin ' . $this->loggedInAdmin['id'] . '.'
            ]);
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
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
            'owner_id.filled'    => 'Please select an owner for the ' . $this->props['name'] . '.',
            'owner_id.exists'    => 'The specified owner does not exist.',
            'owner_id.in'        => 'Unauthorized to create ' . $this[$this->props['name']] . ' for admin ' . $this->loggedInAdmin['id'] . '.',
        ];
    }

    /**
     * Generates the slug column.
     *
     * @return void
     */
    protected function generateSlug(): void
    {
        $baseName = match ($this->props['name']) {
            'art' => $this['name'] . (!empty($this['artist']) ? ' by ' . $this['artist'] : ''),
            default => (isset($this['name']) && !empty($this['name'])) ? $this['name'] : 'empty',
        };

        $slug = uniqueSlug($baseName, $this->props['database_tag'] . '.' . $this->props['table'], $this->ownerId);

        $this->merge([ 'slug' => $slug ]);
    }
}
