<?php

namespace App\Http\Controllers\Guest\Career;

use App\Http\Controllers\Guest\BaseGuestController;
use Illuminate\View\View;

/**
 *
 */
class IndexController extends BaseGuestController
{
    /**
     * Display a listing of portfolio resources.
     *
     * @return View
     */
    public function analyzeJob(): View
    {

        return view('guest.career.analyze-job');
    }
}
