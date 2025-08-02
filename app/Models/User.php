<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'token',
        'status',
        'disabled'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    const STATUSES = [
        'pending',
        'active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Returns an array of options for a select list for statuses.
     *
     * @param bool $includeBlank
     * @param bool $codesAsKey
     * @return array|string[]
     */
    public static function statusListOptions(bool $includeBlank = false, bool $codesAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options = $codesAsKey ? [ '' => '' ] : [ 0 => '' ];
        }

        foreach (self::STATUSES as $i=>$status) {
            $options[$codesAsKey ? $status : $i] = $status;
        }

        return $options;
    }

    /**
     * Returns the status name for the giving index or null if not found.
     *
     * @param integer $index
     * @return string|null
     */
    public static function statusName($index): string | null
    {
        return self::STATUSES[$index] ?? null;
    }

    /**
     * Returns the status index for the giving name or null if not found.
     *
     * @param string $name
     * @return int|null
     */
    public static function statusIndex($name): integer | null
    {
        $key = array_search($name, self::STATUSES);

        return self::STATUSES[$key] ?? null;
    }
}
