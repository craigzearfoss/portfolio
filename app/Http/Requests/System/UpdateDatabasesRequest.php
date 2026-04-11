<?php

namespace App\Http\Requests\System;

use App\Models\Portfolio\Art;
use App\Models\System\Admin;
use App\Models\System\Database;
use App\Models\System\Owner;
use Dflydev\DotAccessData\Data;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

/**
 *
 */
class UpdateDatabasesRequest extends FormRequest
{
    /**
     * @var Admin|Owner|null
     */
    protected Admin|null|Owner $loggedInAdmin = null;

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        $this->loggedInAdmin = loggedInAdmin();

        // verify the database exists
        $database = Database::query()->findOrFail($this['database']['id']);

        // verify the admin is authorized to update the database
        if (!$this->loggedInAdmin['is_root'] || (new Database()->where('owner_id', $this['owner_id'])->get()->isEmpty())) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to update database '. $database['id'] . '.'
                    : 'Unauthorized to update database '. $database['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.'
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
        if (!$database = Route::current()->parameters()['database']) {
            abort(503, 'No database specified.');
        }

        return [
            'owner_id'       => [
                'filled',
                'integer',
                'exists:system_db.admins,id'
            ],
            'name'           => ['filled', 'string', 'max:50', 'unique:system_db.databases,name,' . $database['id']],
            'database'       => ['filled', 'string', 'max:50', 'unique:system_db.databases,database,' . $database['id']],
            'tag'            => ['filled', 'string', 'max:50', 'unique:system_db.databases,tag,' . $database['id']],
            'title'          => ['filled', 'string', 'max:50'],
            'plural'         => ['filled', 'string', 'max:50'],
            'has_owner'      => ['integer', 'between:0,1'],
            'guest'          => ['integer', 'between:0,1'],
            'user'           => ['integer', 'between:0,1'],
            'admin'          => ['integer', 'between:0,1'],
            'menu'           => ['integer', 'between:0,1'],
            'menu_level'     => ['integer'],
            'menu_collapsed' => ['integer', 'between:0,1'],
            'icon'           => ['string', 'max:50', 'nullable'],
            'is_public'      => ['integer', 'between:0,1'],
            'is_readonly'    => ['integer', 'between:0,1'],
            'is_root'        => ['integer', 'between:0,1'],
            'is_disabled'    => ['integer', 'between:0,1'],
            'is_demo'        => ['integer', 'between:0,1'],
            'sequence'       => ['integer', 'min:0', 'nullable'],
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
            'owner_id.filled' => 'Please select an owner for the database.',
            'owner_id.exists' => 'The specified owner does not exist.',
            'owner_id.in'     => 'Unauthorized to update database.'
                . $this['database']['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.',
        ];
    }
}
