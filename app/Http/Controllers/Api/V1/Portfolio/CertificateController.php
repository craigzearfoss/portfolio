<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Resources\Portfolio\CertificateCollection;
use App\Http\Resources\Portfolio\CertificateResource;
use App\Models\Portfolio\Certificate;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class CertificateController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the specified portfolio certificate.
     *
     * @param Certificate $certificate
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Certificate $certificate): JsonResponse
    {
        return new CertificateResource($certificate)->response();
    }
}
