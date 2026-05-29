<?php

namespace App\Http\Controllers\Api\V1\Personal;

use App\Enums\EnvTypes;
use App\Http\Controllers\Controller;
use App\Models\System\AdminResource;
use App\Models\System\Owner;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
    /**
     * Display the personal resources for the specified admin.
     * @throws Exception
     */
    public function show(string $owner_id): JsonResponse
    {
        if (!$owner = new Owner()->newQuery()->find($owner_id)) {

            return response()->json([ 'message' => "Not found." ])->setStatusCode(Response::HTTP_NO_CONTENT);

        } else {

            $personals = new AdminResource()->ownerResources(
                $owner,
                EnvTypes::GUEST,
                'personal_db',
                [ 'menu' => true, 'is_public' => true, 'is_disabled' => false ]
            );
        }

        return response()->json($personals)->setStatusCode(Response::HTTP_OK);
    }
}
