<?php

namespace App\Models\System;

use App\Models\System\AdminResource;
use App\Models\System\Resource;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuItem extends Model
{
    use SearchableModelTrait;

    protected $connection = 'system_db';

    protected $table = 'menu_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'parent_id',
        'database_id',
        'resource_id',
        'name',
        'icon',
        'route',
        'guest',
        'user',
        'admin',
        'menu_level',
        'public',
        'readonly',
        'root',
        'disabled',
        'demo',
        'sequence',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'parent_id', 'database_id', 'resource_id', 'name', 'icon', 'route', 'guest', 'user',
        'admin', 'menu_level', 'sequence', 'public', 'readonly', 'root', 'disabled', 'demo'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * Get the parent of the menu item.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    /**
     * Get the system database of the menu item.
     */
    public function database(): BelongsTo
    {
        return $this->belongsTo(Database::class, 'database_id');
    }

    /**
     * Get the system database of the menu item.
     */
    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class, 'resource_id');
    }
/*
    public function getAdminMenuItems($adminId = null): array
    {
        self::where('admin', 1)
            ->orderBy('sequence', 'asc')
            //->orderBy('parent_id', 'asc')
            ->orderBy('menu_level', 'asc')
            ->get();
    }
*/
    /**
     * @param $adminId
     * @return Collection
     */
    public static function getGuestMenuItems($adminId = null): Collection
    {$adminId = 4;
        if (!empty($adminId)) {
            $query = AdminResource::select('menu_items.*')
                ->leftjoin('menu_items', 'menu_items.id', '=', 'admin_menu_item.menu_item_id')
                ->where('admin_menu_item.admin_id', $adminId)
                ->where('menu_items.guest', 1)
                ->where('menu_items.public', 1)
                ->orderBy('menu_items.sequence', 'asc')->ddRawSql();
        } else {
            $query = Resource::select('menu_items.*')
                ->leftJoin('menu_items', 'menu_items.resource_id', '=', 'resources.id')
                ->where('resources.guest', 1)
                ->where('resources.public', 1)
                ->where('menu_items.guest', 1)
                ->where('menu_items.public', 1)
                ->orderBy('menu_items.sequence', 'asc');
        }

        return $query->get();
    }
}
