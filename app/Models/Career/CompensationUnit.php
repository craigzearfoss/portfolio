<?php

namespace App\Models\Career;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 */
class CompensationUnit extends Model
{
    use SearchableModelTrait;

    /**
     * @var string
     */
    protected $connection = 'career_db';

    /**
     * @var string
     */
    protected $table = 'compensation_units';

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->predefinedColumns = [];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'abbreviation',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'name', 'abbreviation' ];
    /**
     *
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

    /**
     * Get the career applications for the application compensation unit.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'compensation_unit_id')
            ->orderBy('post_date', 'desc');
    }

    /**
     * Returns the compensation unit name from the compensation unit id.
     *
     * @param int $compensationUnitId
     * @return string|null
     */
    public static function getCompensationUnitName(int $compensationUnitId): string|null
    {
        return match ($compensationUnitId) {
            1 => 'hour',
            2 => 'year',
            3 => 'month',
            4 => 'week',
            5 => 'day',
            6 => 'project',
            default => null,
        };
    }
}
