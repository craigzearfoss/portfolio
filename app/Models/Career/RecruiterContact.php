<?php

namespace App\Models\Career;

use Database\Factories\Career\CompanyContactFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class RecruiterContact extends Model
{
    /** @use HasFactoryRecruiterContactFactory> */
    use HasFactory;

    /**
     * @var string
     */
    protected $connection = 'career_db';

    /**
     * @var string
     */
    protected $table = 'recruiter_contact';

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
        'recruiter_id',
        'contact_id',
        'active',
    ];
}
