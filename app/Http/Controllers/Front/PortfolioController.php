<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Database;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {

        $resources = (new Resource())->bySequence('user');

        $resources = Database::getResources(config('app.portfolio_db'), [ 'public' => true, 'disabled' => false ]);

        return view('front.portfolio', compact('resources'));
    }
}
