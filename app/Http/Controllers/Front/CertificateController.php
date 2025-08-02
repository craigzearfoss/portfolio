<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Career\Certificate;
use Illuminate\View\View;

class CertificateController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of the certificate.
     */
    public function index(): View
    {
        $certificates = Certificate::where('disabled', 0)->orderBy('seq')->paginate(self::NUM_PER_PAGE);

        $title = 'Certificates';
        return view('front.certificate.index', compact('certificates', 'title'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }
}
