<?php

namespace App\Models\Career;

use Database\Factories\Career\CompanyContactFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class CompanyReference extends Model
{
    /** @use HasFactory<CompanyRefertenceFactory> */
    use HasFactory;

    /**
     * @var string
     */
    protected $connection = 'career_db';

    /**
     * @var string
     */
    protected $table = 'company_reference';

    /**
     * @var bool
     */
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
