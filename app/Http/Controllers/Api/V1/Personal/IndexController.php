<?php

namespace App\Http\Controllers\Api\V1\Personal;

use App\Enums\EnvTypes;
use App\Http\Controllers\Controller;
use App\Models\System\AdminResource;
use App\Models\System\Owner;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class IndexController extends Controller
{
    /**
     * Display the personal resources for the specified candidate.
     *
     * @param Owner $owner
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Owner $owner): JsonResponse
    {
        $personals = new AdminResource()->ownerResources(
            $owner,
            EnvTypes::GUEST,
            'personal_db',
            [ 'menu' => true, 'is_public' => true, 'is_disabled' => false ]
        );

        return response()->json($personals);
    }
}
