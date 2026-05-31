<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Resources\Portfolio\CertificationCollection;
use App\Http\Resources\Portfolio\CertificationResource;
use App\Models\Portfolio\Certification;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;

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

        return new CertificationCollection($certifications)->response();
    }

    /**
     * Display the specified portfolio certification.
     *
     * @param Certification $certification
     * @return JsonResponse
     */
    public function show(Certification $certification): JsonResponse
    {
        return new CertificationResource($certification)->response();
    }
}
