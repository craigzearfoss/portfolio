<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Certification;
use App\Models\System\Owner;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class CertificationController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display a listing of the portfolio certifications.
     * @throws Exception
     */
    public function index(): JsonResponse
    {
        $perPage = request()->query('per_page', $this->perPage());
        $page    = request()->query('page');

        $query = new Certification()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Certification::SEARCH_ORDER_BY));

        if (!empty($page)) {
            $certifications = $query->paginate($perPage)->appends(request()->except('page'));
        } else {
            $certifications = $query->get();
        }

        return response()->json($certifications)->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Display the specified portfolio certification.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        if (!new Owner()->newQuery()->find($id)) {
            return response()->json([ 'message' => "Certification `{$id}` not found." ])->setStatusCode(Response::HTTP_NO_CONTENT);
        } else {
            $certification = Certification::query()->where('id', '=', $id)->get();
            return response()->json($certification)->setStatusCode(Response::HTTP_OK);
        }
    }
}
