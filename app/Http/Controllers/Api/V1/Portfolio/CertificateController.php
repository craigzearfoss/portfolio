<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Certificate;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class CertificateController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the portfolio certificates for the specified admin.
     *
     * @param string $owner_id
     * @return JsonResponse
     * @throws Exception
     */
    public function show(string $owner_id): JsonResponse
    {
        $perPage = request()->query('per_page', $this->perPage());
        $page    = request()->query('page');

        $query = new Certificate()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Certificate::SEARCH_ORDER_BY))
        ->where('certificates.owner_id', $owner_id);

        if (!empty($page)) {
            $certificates = $query->paginate($perPage)->appends(request()->except('page'));
        } else {
            $certificates = $query->get();
        }

        return response()->json($certificates)->setStatusCode(Response::HTTP_OK);
    }
}
