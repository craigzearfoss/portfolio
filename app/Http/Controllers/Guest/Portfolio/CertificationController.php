<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\BaseController;
use App\Models\Portfolio\Certification;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
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
        return view('guest.portfolio.certification.index', compact('certifications', 'title'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified certification.
     *
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        if (!$certification = Certification::where('slug', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view('guest.certification.show', compact('certification'));
    }
}
