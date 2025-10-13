<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Portfolio\Skill;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SkillController extends BaseGuestController
{
    /**
     * Display a listing of skills.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $skills = Skill::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('level', 'desc')->orderBy('name', 'asc')
            ->paginate($perPage);

        return view(themedTemplate('guest.portfolio.skill.index'), compact('skills'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified skill.
     *
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        if (!$skill = Skill::where('slug', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.portfolio.skill.show'), compact('skill'));
    }
}
