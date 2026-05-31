<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Resources\Portfolio\SkillResource;
use App\Models\Portfolio\Skill;
use App\Models\System\Owner;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class SkillController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the specified portfolio skill.
     *
     * @param Skill $skill
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Skill $skill): JsonResponse
    {
        return new SkillResource($skill)->response();
    }
}
