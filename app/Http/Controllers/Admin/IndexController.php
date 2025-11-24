<?php

namespace App\Http\Controllers\Admin;

use App\Mail\ResetPassword;
use App\Models\System\Admin;
use App\Models\System\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class IndexController extends BaseAdminController
{
    public function index(): View
    {
        if (Auth::guard('admin')->check()) {
            return view(themedTemplate('admin.dashboard'));
        } else {
            return view(themedTemplate('admin.index'));
        }
    }

    public function dashboard(): View
    {
        return view(themedTemplate('admin.dashboard'));
    }

    public function login(Request $request): RedirectResponse | View
    {
        if (isAdmin()) {
            // admin is already logged in
            return redirect()->route('admin.dashboard');
        }

        if ($request->isMethod('post')) {

            $inputs = $request->all();
            $username = $inputs['username'] ?? '';

            if ($username == config('app.demo_admin_username') && !config('app.demo_admin_enabled')) {
                return view(themedTemplate('admin.login'))
                    ->withErrors('demo-admin has been disabled.');
            }

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
                return view(themedTemplate('admin.login'))
                    ->withErrors('Invalid login credentials. Please try again.');
            }
        } else {

            return view(themedTemplate('admin.login'));
        }
    }

    public function logout(): RedirectResponse
    {
        Auth::guard('admin')->logout();
        return redirect()->route('system.index')->with('success', 'Admin logout successful.');
    }

    public function forgot_password(Request $request): RedirectResponse | View
    {
        if ($request->isMethod('post')) {

            $request->validate([
                'email' => ['email', 'required']
            ]);

            $email = $request->email ?? '';
            if (!$admin = Admin::where('email', $email)->first()) {
                return view(themedTemplate('admin.forgot-password'))
                    ->withErrors('Admin with provided email does not exist.');
            }

            $admin->token = hash('sha256', time());
            $admin->update();

            $pResetLink = route(
                'admin.reset-password',
                ['token' => $admin->token , 'email' => urlencode($email)]
            );
            $subject = "Reset Password from " . config('app.name');
            $info = [
                'user'       => $admin->username,
                'email'      => $email,
                'pResetLink' => $pResetLink
            ];

            Mail::to($request->email)->send(new ResetPassword($subject, $info));

            return redirect()->back()->with('success', 'A reset link has been sent to your email address. Please check your
            email. If you do not find the email in your inbox, please check your spam folder.');

        } else {

            return view(themedTemplate('admin.forgot-password'));
        }
    }

    public function reset_password($token, $email): RedirectResponse | View
    {
        if (!$admin = Admin::where('email', $email)->where('token', $token)->first()) {
            return redirect()->route('admin.login')
                ->with('error', 'Your reset password token is expired. Please try again.');
        } else {
            return view(themedTemplate('admin.reset-password'), compact('token', 'email'));
        }
    }

    public function reset_password_submit(Request $request, $token, $email): RedirectResponse
    {
        $request->validate([
            'password' => ['required'],
            'confirm_password' => ['required', 'same:password']
        ]);

        if (!$admin = Admin::where('email', $email)->where('token', $token)->first()) {
            return redirect()->back()->with('error', 'Your reset password token is expired. Please try again.');
        }

        if (Hash::check($request->password, $admin->password)) {
            return redirect()->back()->with('error', ' You cannot use your old password again.');
        }

        $admin->password = Hash::make($request->password);
        $admin->token = null;
        $admin->update();

        return redirect()->route('admin.login')
            ->with('success', 'Your password has been changed. You can login with your new password.');
    }
}
