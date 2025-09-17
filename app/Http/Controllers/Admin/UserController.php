<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class UserController extends BaseController
{
    /**
     * Display a listing of users.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $users = User::latest()->paginate($perPage);

        return view('admin.user.index', compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new user.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.user.create', compact('referer'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param UserStoreRequest $request
     * @return RedirectResponse
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        $user = User::create($request->validated());

        $referer = $request->headers->get('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $user->username . ' created successfully. User will need to verify email.');
        } else {
            return redirect()->route('admin.user.index')
                ->with('success', $user->username . ' created successfully. User will need to verify email.');
        }
    }

    /**
     * Display the specified user.
     *
     * @param User $user
     * @return View
     */
    public function show(User $user): View
    {
        return view('admin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param User $user
     * @param Request $request
     * @return View
     */
    public function edit(User $user): View
    {
        // admins can only edit any user
        if (!Auth::guard('admin')->check()) {
            // users can only edit themselves
            if ($user->id !== Auth::guard('web')->user()->id) {
                abort(403);
            }
        }

        $referer = $request->headers->get('referer');

        return view('admin.user.edit', compact('user', 'referer'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $user->username . ' updated successfully.');
        } else {
            return redirect()->route('admin.user.index')
                ->with('success', $user->username . ' updated successfully.');
        }
    }

    /**
     * Remove the specified user from storage.
     *
     * @param User $user
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(User $user, Request $request): RedirectResponse
    {
        $user->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $user->name . ' deleted successfully.');
        } else {
            return redirect()->route('admin.user.index')
                ->with('success', $user->name . ' deleted successfully.');
        }
    }

    /**
     * Display the change password page.
     *
     * @param User $user
     * @param Request $request
     * @return RedirectResponse
     */
    public function change_password(User $user, Request $request): View
    {
        $referer = $request->input('referer');

        return view('admin.user.change-password', compact('user', 'referer'));
    }

    /**
     * Update the new password.
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function change_password_submit(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', 'Password for ' . $user->username . ' updated successfully.');
        } else {
            return redirect()->route('admin.user.show', $user)
                ->with('success', 'Password for ' . $user->username . ' updated successfully.');
        }
    }
}
