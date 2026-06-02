<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Enums\EnvTypes;
use App\Http\Controllers\Controller;
use App\Models\System\AdminResource;
use App\Models\System\Owner;
use Exception;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Display the portfolio resources for the specified candidate.
     *
     * @param Owner $owner
     * @throws Exception
     */
    public function show(Owner $owner): JsonResponse
    {
        $portfolios = new AdminResource()->ownerResources(
            $owner,
            EnvTypes::GUEST,
            'portfolio_db',
            [ 'menu' => true, 'is_public' => true, 'is_disabled' => false ]
        );

        return response()->json($portfolios);
    }
}
