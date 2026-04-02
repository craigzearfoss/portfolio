<?php

namespace App\Http\Controllers\Guest\Personal;

use App\Enums\EnvTypes;
use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\System\AdminResource;
use Exception;
use Illuminate\View\View;

/**
 *
 */
class IndexController extends BaseGuestController
{
    /**
     * Display a listing of personal resources.
     *
     * @return View
     * @throws Exception
     */
    public function index(): View
    {
        if (!empty($this->owner)) {

            $personals = new AdminResource()->ownerResources(
                $this->owner,
                EnvTypes::GUEST,
                'personal_db',
                [ 'menu' => true, 'is_public' => true, 'is_disabled' => false ]
            );

        } else {

            $personals = [];
        }

        return view(themedTemplate('guest.personal.index'), compact('personals'));
    }
}
