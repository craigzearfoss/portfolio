<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Enums\EnvTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\System\Database;
use App\Models\System\AdminResource;
use App\Services\ImageService;
use App\Services\PermissionService;
use Illuminate\Support\Facades\Request;
use Illuminate\View\View;

/**
 *
 */
class IndexController extends BaseAdminController
{
    public function index(): View
    {
        $databaseId = new Database()->where('tag', 'portfolio_db')->first()->id ?? null;

        $portfolios = !empty($databaseId)
            ? AdminResource::ownerResources($this->owner->id ?? null, EnvTypes::ADMIN, $databaseId)
            : [];

        return view('admin.portfolio.index', compact('portfolios'));
    }

    public function upload(string $resourceName, string $imageName, Request $request)
    {
        die('@TODO: ???? Controllers\Portfolio\IndexController->upload()');
        new ImageService()->validate($request, $imageName);

        die('VALIDATES');
    }
}
