<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\EnvTypes;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\System\Owner;
use App\Services\MenuService;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class MenuController extends BaseController
{
    use GuestControllerTrait;

    /**
     * Display the menu for an owner/candidate.
     *
     * @param Owner $owner
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Owner $owner): JsonResponse
    {
        if (!$menuType = strtolower(request()->input('menu_type'))) {
            $menuType = 'left';
        }
        if (!in_array($menuType, [ 'left', 'top' ])) {
            return response()->json([ 'success' => false, 'message' => 'Invalid menu_type: ' . $menuType ]);
        }

        $menuService = new MenuService(EnvTypes::GUEST, $owner);

        return response()->json(json_decode($menuService->getMenu($menuType, true)));
    }
}
