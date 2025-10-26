<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\System\StoreUsersRequest;
use App\Mail\ForgotUsername;
use App\Mail\ResetPassword;
use App\Mail\VerifyEmail;
use App\Models\System\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class IndexController extends BaseUserController
{
    public function index(): View
    {
        if (Auth::guard('user')->check()) {
            return view('user.dashboard');
        } else {
            return view(themedTemplate('system.index'));
        }
    }

    public function dashboard()
    {
        return view(themedTemplate('user.dashboard'));
    }

    /**
     * Update the new password.
     *
     * @param Request $request
     * @return RedirectResponse|View
     */
    public function login(Request $request): RedirectResponse|View
    {
        if (isUser()) {
            // user is already logged in
            return redirect()->route('user.dashboard');
        }

        if ($request->isMethod('post')) {

            $inputs = $request->all();
            $username = $inputs['username'] ?? '';

            $request->validate([
                'username' => ['required'],
                'password' => ['required'],
            ]);

            $data = [
                'username' => $username,
                'password' => $inputs['password'],
            ];

            if (Auth::guard('user')->attempt($data)) {
                return redirect()->route('user.dashboard');
            } else {
                return view(themedTemplate('user.login'))
                    ->withErrors('Invalid login credentials. Please try again.');
            }

        } else {

            return view(themedTemplate('user.login'));
        }
    }

    public function logout(): RedirectResponse
    {
        Auth::guard('user')->logout();
        return redirect()->route('system.index')->with('success', 'User logout successful.');
    }

    public function forgot_password(Request $request): RedirectResponse | View
    {
        if ($request->isMethod('post')) {

            $request->validate([
                'email' => ['email', 'required']
            ]);

            $email = $request->email ?? '';
            if (!$user = User::where('email', $email)->where('status', 1)->first()) {
                return view(themedTemplate('user.forgot-password'))
                    ->withErrors('User with provided email does not exist.');
            }

            $user->token = hash('sha256', time());
            $user->update();

            $pResetLink = route(
                'user.reset-password',
                ['token' => $user->token, 'email' => urlencode($email)]
            );
            $subject = "Reset Password from " . config('app.name');
            $info = [
                'user'       => $user->name,
                'email'      => $user->email,
                'pResetLink' => $pResetLink
            ];

            Mail::to($request->email)->send(new ResetPassword($subject, $info));

            return redirect()->back()->with('success', 'A reset link has been sent to your email address. Please check
            your email. If you do not find the email in your inbox, please check your spam folder.');

        } else {

            return view(themedTemplate('user.forgot-password'));
        }
    }

    public function forgot_username(Request $request): RedirectResponse|View
    {
        if ($request->isMethod('post')) {

            $request->validate([
                'username' => ['username', 'required']
            ]);

            $username = $request->username ?? '';
            $user = User::where('username', $username)->where('status', 1)->first();
            if (!$user) {
                return view(themedTemplate('user.forgot-username'))
                    ->withErrors('User with provided username does not exist.');
            }

            $user->token = hash('sha256', time());
            $user->update();

            $subject = "Forgot user name from " . config('app.name');
            $info = [
                'user'     => $user->name,
                'username' => $user->username,
            ];

            Mail::to($request->email)->send(new ForgotUsername($subject, $info));

            return redirect()->back()->with('success', 'An email with your username has been sent to your email address.
            Please check your email. If you do not find the email in your inbox, please check your spam folder.');

        } else {

            return view(themedTemplate('user.forgot-username'));
        }
    }

    public function reset_password($token, $email): RedirectResponse |View
    {
        if (!$user = User::where('email', $email)->where('token', $token)->first()) {
            return redirect()->route('user.login')
                ->with('error', 'Your reset password token is expired. Please try again.');
        } else {
            return view(themedTemplate('user.reset-password'), compact('token', 'email'));
        }
    }

    public function reset_password_submit(Request $request, $token, $email): RedirectResponse
    {
        $request->validate([
            'password' => ['required'],
            'confirm_password' => ['required', 'same:password']
        ]);

        if (!$user = User::where('email', $email)->where('token', $token)->first()) {
            return redirect()->back()->with('error', 'Your reset password token is expired. Please try again.');
        }

        if (Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', ' You cannot use your old password again.');
        }

        $user->password = Hash::make($request->password);
        $user->token = null;
        $user->update();

        return redirect()->route('user.login')
            ->with('success', 'Your password has been changed. You can login with your new password.');
    }

    public function register(Request $request): RedirectResponse|View
    {
        if ($request->isMethod('post') && config('app.open_enrollment')) {

            $request->validate((new StoreUsersRequest())->rules());

            $user = new User();
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->password = Hash::make($request->password);
            $user->token    = hash('sha256', time());
            $user->status   = 0;
            $user->disabled = 1;

            $user->save();

            $verificationLink = route(
                'user.email-verification',
                ['token' => $user->token, 'email' => urlencode($request->email)]
            );
            $subject = "Email Verification from " . config('app.name');
            $info = [
                'name' => $user->name,
                'verificationLink' => $verificationLink
            ];

            Mail::to($request->email)->send(new VerifyEmail($subject, $info));

            return redirect()->back()->with('success', 'You need to verify your email to complete your registration.
            We have sent a verification link to your email. If you cannot find the email in your inbox, please check
            your spam folder.');

        } else {

            return view(themedTemplate('user.register'));
        }
    }

    public function email_verification($token, $email): RedirectResponse
    {
        $user = User::where('email', $email)->where('token', $token)->first();
        if (!$user) {
            return redirect()->route('user.login');
        }

        $user->token = null;
        $user->status = 1;
        $user->disabled = 0;
        $user->update();

        $user->markEmailAsVerified();

        return redirect()->route('user.login')
            ->with('success', 'Your email has been verified. You can now login to your account.');
    }

}
