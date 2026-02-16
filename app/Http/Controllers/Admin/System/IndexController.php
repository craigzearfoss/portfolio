<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\System\Database;
use App\Models\System\Resource;
use Illuminate\View\View;

/**
 *
 */
class IndexController extends BaseAdminController
{
    public function index(): View
    {
        $databaseId = new Database()->where('tag', 'system_db')->first()->id ?? null;

        $query = new Resource()->where('database_id', $databaseId)->orderBy('name');

        if (!$this->isRootAdmin) {
            $query->where('root', false);
        }

        $systems = $query->get();

        return view('admin.system.index', compact('systems'));
    }
}
