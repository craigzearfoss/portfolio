<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class IndexController extends Controller
{
    public function index(): View
    {
        if (Auth::guard('admin')->check()) {
            return view('admin.dashboard');
        } else {
            return view('admin.index');
        }
    }

    public function dashboard(): View
    {
        return view('admin.dashboard');
    }

    public function login(Request $request): RedirectResponse | View
    {
        if ($request->isMethod('post')) {

            $inputs= $request->all();
            $username = $inputs['username'] ?? '';

            $request->validate([
                'username' => ['required'],
                'password' => ['required'],
            ]);

            $data = [
                'username' => $username,
                'password' => $inputs['password'],
            ];

            if (Auth::guard('admin')->attempt($data)) {
                return redirect()->route('admin.dashboard');
            } else {
                return view('admin.login')->withErrors('Invalid login credentials. Please try again.');
            }
        } else {

            return view('admin.login');
        }
    }

    public function logout(): RedirectResponse
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'Admin logout successfully.');
    }

    public function forgot_password(Request $request): RedirectResponse | View

    {
        if ($request->isMethod('post')) {

            $request->validate([
                'email' => ['email', 'required']
            ]);

            $email = $request->email ?? '';
            $admin = Admin::where('email', $email)->first();
            if (!$admin) {
                return view('admin.forgot_password')->withErrors('Admin with provided email does not exist.');
            }

            $admin->token = hash('sha256', time());
            $admin->update();

            $pResetLink = route('admin_reset_password', ['token' => $admin->token , 'email' => urlencode($email)]);
            $subject = "Reset Password from " . config('app.name');
            $info = [
                'user' => $admin->username,
                'email' => $email,
                'pResetLink' => $pResetLink
            ];

            Mail::to($request->email)->send(new ResetPassword($subject, $info));

            return redirect()->back()->with('success', 'A reset link has been sent to your email address. Please check your
            email. If you do not find the email in your inbox, please check your spam folder.');

        } else {

            return view('admin.forgot_password');
        }
    }

    public function reset_password($token, $email): RedirectResponse | View
    {
        $admin = Admin::where('email', $email)->where('token', $token)->first();
        if (!$admin) {
            return redirect()->route('admin.login')->with('error', 'Your reset password token is expired. Please try again.');
        } else {
            return view('admin.reset_password', compact('token', 'email'));
        }
    }

    public function reset_password_submit(Request $request, $token, $email): RedirectResponse
    {
        $request->validate([
            'password' => ['required'],
            'confirm_password' => ['required', 'same:password']
        ]);

        $admin = Admin::where('email', $email)->where('token', $token)->first();
        if (!$admin) {
            return redirect()->back()->with('error', 'Your reset password token is expired. Please try again.');
        }

        if (Hash::check($request->password, $admin->password)) {
            return redirect()->back()->with('error', ' You cannot use your old password again.');
        }

        $admin->password = Hash::make($request->password);
        $admin->token = null;
        $admin->update();

        return redirect()->route('admin.login')->with('success', 'Your password has been changed. You can login
        with your new password.');
    }

    /**
     * Display the current admin.
     */
    public function profile(): View
    {
        $admin = Auth::guard('admin')->user();

        $title = $admin->username;
        return view('admin.profile', compact('admin', 'title'));
    }

    /**
     * Show the form for editing the current admin.
     */
    public function profile_edit(): View
    {
        $admin = Auth::guard('admin')->user();

        $title = 'Edit My Profile';
        return view('admin.profile-edit', compact('admin', 'title'));
    }

    /**
     * Update the current user in storage.
     */
    public function profile_update(Request $request): RedirectResponse
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'username' => ['string', 'min:6', 'max:200', 'unique:admins,username,'.$admin->id],
            'email'    => ['email', 'max:255', 'unique:admins,email,'.$admin->id],
        ]);

        $admin->username = $request->username;
        $admin->email    = $request->email;
        $admin->save();

        return redirect()->route('admin.profile')
            ->with('success', 'Profile updated successfully.');
    }
}
