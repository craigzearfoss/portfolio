<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyContact extends Model
{
    /** @use HasFactory<\Database\Factories\Career\CompanyContactFactory> */
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
        'company_id',
        'contact_id',
        'active',
    ];
}
