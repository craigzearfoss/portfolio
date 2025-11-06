<?php

namespace App\Models\Portfolio;

use App\Models\Portfolio\Certification;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CertificationType extends Model
{
    use SearchableModelTrait;

    protected $connection = 'portfolio_db';

    protected $table = 'certification_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'name'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * Get the certifications for the certification type.
     */
    public function certifications(): HasMany
    {
        return $this->hasMany(Certification::class);
    }
}
