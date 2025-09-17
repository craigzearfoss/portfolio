<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\BaseController;
use App\Models\Portfolio\Certification;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CertificationController extends BaseController
{
    /**
     * Display a listing of certifications.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

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
