<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Company extends Model
{
    /** @use HasFactory<\Database\Factories\Career\CompanyFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $connection = 'career_db';

    protected $table = 'companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'street',
        'street2',
        'city',
        'state',
        'zip',
        'phone',
        'phone_label',
        'alt_phone',
        'alt_phone_label',
        'email',
        'email_label',
        'alt_email',
        'alt_email_label',
        'website',
        'description',
        'disabled',
    ];

    /**
     * The company belongs to many application.
     */
    public function applications(): BelongsToMany
    {
        return $this->belongsToMany(Application::class, 'application_company', 'company_id', 'application_id');
    }

    /**
     * The company hase many contacts.
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Returns an array of options for a select list.
     *
     * @param bool $includeBlank
     * @param bool $nameAsKey
     * @return array|string[]
     */
    public static function listOptions(bool $includeBlank = false, bool $nameAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options = [ '' => '' ];
        }

        foreach (self::select('id', 'name')->orderBy('name', 'asc')->get() as $row) {
            $options[$nameAsKey ? $row->name : $row->id] = $row->name;
        }

        return $options;
    }
}
