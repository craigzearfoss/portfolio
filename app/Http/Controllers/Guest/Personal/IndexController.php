<?php

namespace App\Http\Controllers\Guest\Personal;

use App\Http\Controllers\Controller;
use App\Models\Database;
use App\Models\Resource;
use Illuminate\View\View;

class IndexController extends Controller
{
    public function index(): View
    {

        $resources = (new Resource())->bySequence('user');

        $resources = Database::getResources(config('app.personal_db'), [ 'public' => true, 'disabled' => false ]);

        return view('guest.personal', compact('resources'));
    }
}
