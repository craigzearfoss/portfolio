<?php

namespace App\Http\Requests;

use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;

/**
 *
 */
class UpdateAppBaseRequest extends FormRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => '',       // like "system_db","dictionary_db", or "portfolio_db"
        'table'        => '',       // like "awards", "admin_emails", or "operating_systems"
        'key'          => '',       // like "award", "admin_email", or "operating_system"
        'name'         => '',       // like "award", "admin_mail", or "operating_system"
        'label'        => '',       // like "award", "admin email", or "operating system"
        'class'        => '',       // like "App\Models\Portfolio\Skill" or "App\Models\System\AdminEmail"
        'has_owner'    => false,    // do resource table entries have owners?
    ];

    /**
     * The currently logged-in admin.
     *
     * @var Admin|Owner|null
     */
    protected Admin|null|Owner $loggedInAdmin = null;

    /**
     * Does the currently logged-in admin have root privileges?
     *
     * @var bool
     */
    protected bool $isRootAdmin = false;

    /**
     * The currently logged-in user.
     *
     * @var User|null
     */
    protected User|null $loggedInUser = null;

    /**
     * The admin id of the owner of the resource.
     *
     * @var int|null
     */
    protected int|null $ownerId = null;

    /**
     * The user id of the owner of the resource. (This is for things like user_teams, user_groups, user_emails, and user_phones)
     *
     * @var int|null
     */
    protected int|null $userId = null;

    /**
     * The resource being updated.
     *
     * @var mixed
     */
    protected mixed $resource = null;

    /**
     * Determine if the admin is authorized to make this request and set some class variables.
     *
     * @throws ValidationException
     */
    public function authorize(): bool
    {
        // get the currently logged-in admin and user
        $this->loggedInAdmin = loggedInAdmin();
        $this->loggedInUser  = loggedInUser();

        // is this a root admin?
        $this->isRootAdmin = !empty($this->loggedInAdmin) && !empty($this->loggedInAdmin->is_root);

        // get the admin id of the owner of the resource (this will be null if there is no owner)
        if ($this->props['has_owner']) {
            if (!$this->ownerId = $this['owner_id'] ?? null) {
                throw ValidationException::withMessages([ 'GLOBAL' => 'No owner_id provided.' ]);
            }
        }

        // get the user id of the owner of the resource (this only applies to resources like user_teams,
        // user_groups, user_emails, and email phones
        if ($this->props['has_user']) {
            if (!$this->userId = $this['user_id'] ?? null) {
                throw ValidationException::withMessages([ 'GLOBAL' => 'No user_id provided.' ]);
            }
        }

        // verify the resource exists
        $this->resource = $this->props['class']::findOrFail($this[$this->props['key']]['id']);

        if (!canUpdate($this->resource, $this->loggedInAdmin)) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to update ' . $this->props['label'] . '.'
                    : 'Unauthorized to update ' . $this->props['label'] . ' ' . $this->resource->id . '.'
            ]);
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
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
            'owner_id.filled' => 'Please select an owner for the ' . $this->props['name'] . '.',
            'owner_id.exists' => 'The specified owner does not exist.',
            'owner_id.in'     => 'Unauthorized to create ' . $this->props['name'] . ' for admin ' .
                $this->loggedInAdmin['id'] . ' in ' . get_class($this) .'.',
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
            'art', 'music' => $this['name'] . (!empty($this['artist']) ? ' by ' . $this['artist'] : ''),
            'award' => (!empty($this['year']) ? $this['year'] . ' ': '') . $this['name']
                . (!empty($this['category']) ? ' for ' . $this['category'] : ''),
            'job' => $this['company'] . (!empty($this['role']) ? ' (' . $this['role'] : ')'),
            'publication' => $this['title'],
            'reading' => $this['title'] . (!empty($this['author']) ? ' by ' . $this['author'] : ''),
            'skill' =>  $this['name'] . (!empty($this['version']) ? '-' . $this['version'] : ''),
            default => (isset($this['name']) && !empty($this['name'])) ? $this['name'] : 'no-name',
        };

        $slug = uniqueSlug(
            $baseName,
            $this->props['database_tag'] . '.' . $this->props['table'],
            $this->ownerId
        );

        $this->merge([ 'slug' => $slug ]);
    }
}
