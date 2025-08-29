<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Certification;
use Illuminate\View\View;

class CertificationController extends Controller
{
    const PER_PAGE = 20;

    /**
     * Display a listing of the certification.
     */
    public function index(int $perPage = self::PER_PAGE): View
    {
        $certifications = Certification::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('sequence', 'asc')
            ->paginate($perPage);

        $title = 'Certifications';
        return view('front.certification.index', compact('certifications', 'title'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified certification.
     */
    public function show(Certification $certification): View
    {
        return view('front.certification.show', compact('certification'));
    }
}
