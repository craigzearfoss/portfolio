<?php

namespace App\Models\Career;

use Database\Factories\Career\CompanyContactFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class CompanyContact extends Model
{
    /** @use HasFactory<CompanyContactFactory> */
    use HasFactory;

    protected $connection = 'career_db';

    protected $table = 'company_contact';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'company_id',
        'contact_id',
        'active',
    ];
}
