<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

class UserController extends Controller
{
    const PER_PAGE = 20;

    /**
     * Display a listing of users.
     */
    public function index(int $perPage = self::PER_PAGE): View
    {
        $users = User::latest()->paginate($perPage);

        return view('admin.user.index', compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        User::create($request->validated());

        return redirect()->route('admin.user.index')
            ->with('success', 'User created successfully. User will need to verify email.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user): View
    {
        return view('admin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
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

        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        return redirect()->route('admin.user.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('admin.user.index')
            ->with('success', 'User deleted successfully');
    }

    /**
     * Display the change password page.
     */
    public function change_password(User $user): View
    {
        return view('admin.user.change_password', compact('user'));
    }

    /**
     * Update the new password.
     */
    public function change_password_submit(UserUpdateRequest $request, User $user): RedirectResponse|View
    {
        $user->update($request->validated());

        return redirect()->route('admin.user.show', $user)
            ->with('success', 'User password updated successfully');
    }
}
