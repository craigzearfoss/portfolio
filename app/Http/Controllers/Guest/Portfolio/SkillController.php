<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Portfolio\Skill;
use App\Models\System\Admin;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SkillController extends BaseGuestController
{
    /**
     * Display a listing of skills.
     * NOTE: $this->owner is set in the BaseController->initialize() method.
     *
     * @param Admin $admin
     * @param Request $request
     * @return View
     */
    public function index(Admin $admin, Request $request): View
    {
        $perPage = 50; //$request->query('per_page', $this->perPage());

        $skills = Skill::where('owner_id', $this->owner->id)
            ->orderBy('level', 'desc')->orderBy('name', 'asc')
            ->paginate($perPage)->appends(request()->except('page'));

        return view(themedTemplate('guest.portfolio.skill.index'), compact('skills'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified skill.
     * NOTE: $this->owner is set in the BaseController->initialize() method.
     *
     * @param Admin $admin
     * @param string $slug
     * @return View
     */
    public function show(Admin $admin, string $slug): View
    {
        if (!$skill = Skill::where('owner_id', $this->owner->id)->where('slug', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.portfolio.skill.show'), compact('skill'));
    }
}
