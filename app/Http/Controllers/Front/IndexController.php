<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\BaseController;
use App\Http\Requests\UserStoreRequest;
use App\Mail\ForgotUsername;
use App\Mail\ResetPassword;
use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class IndexController extends BaseController
{
    public function index(): View
    {
        return view('front.index');
    }

    public function login(Request $request): RedirectResponse|View
    {
        if ($request->isMethod('post')) {

            $inputs = $request->all();
            $email = $inputs['email'] ?? '';

            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            $data = [
                'email' => $email,
                'password' => $inputs['password'],
            ];

            if (Auth::guard('web')->attempt($data)) {
                return redirect()->route('front.homepage');
            } else {
                $title = 'Login';
                return view('front.login', compact('title'))->withErrors('Invalid login credentials. Please try again.');
            }

        } else {

            $title = 'Login';
            return view('front.login', compact('title'));
        }
    }

    public function logout(): RedirectResponse
    {
        Auth::guard('web')->logout();

        return redirect()->route('front.homepage')->with('error', 'User logout successful.');
    }

    public function forgot_password(Request $request): RedirectResponse|View
    {
        if ($request->isMethod('post')) {

            $request->validate([
                'email' => ['email', 'required']
            ]);

            $email = $request->email ?? '';
            $user = User::where('email', $email)->where('status', 1)->first();
            if (!$user) {
                return view('front.reset-password')->withErrors('User with provided email does not exist.');
            }

            $user->token = hash('sha256', time());
            $user->update();

            $pResetLink = route('front.reset-password', ['token' => $user->token, 'email' => urlencode($email)]);
            $subject = "Reset Password from " . config('app.name');
            $info = [
                'user' => $user->name,
                'email' => $user->email,
                'pResetLink' => $pResetLink
            ];

            Mail::to($request->email)->send(new ResetPassword($subject, $info));

            return redirect()->back()->with('success', 'A reset link has been sent to your email address. Please check your
            email. If you do not find the email in your inbox, please check your spam folder.');

        } else {

            $title = 'Forgot Password';
            return view('front.forgot-password', compact('title'));
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
                return view('front.forgot-username')->withErrors('User with provided username does not exist.');
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

            $title = 'Forgot User Name';
            return view('front.forgot-username', compact('title'));
        }
    }

    public function reset_password($token, $email): RedirectResponse|View
    {
        $user = User::where('email', $email)->where('token', $token)->first();
        if (!$user) {
            return redirect()->route('front.login')->with('error', 'Your reset password token is expired. Please try again.');
        } else {
            $title = 'Reset Password';
            return view('front.reset-password', compact('token', 'email', 'title'));
        }
    }

    public function reset_password_submit(Request $request, $token, $email): RedirectResponse
    {
        $request->validate([
            'password' => ['required'],
            'confirm_password' => ['required', 'same:password']
        ]);

        $user = User::where('email', $email)->where('token', $token)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Your reset password token is expired. Please try again.');
        }

        if (Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', ' You cannot use your old password again.');
        }

        $user->password = Hash::make($request->password);
        $user->token = null;
        $user->update();

        return redirect()->route('front.login')
            ->with('success', 'Your password has been changed. You can login with your new password.');
    }

    public function register(Request $request): RedirectResponse|View
    {
        if ($request->isMethod('post') && config('app.open_enrollment')) {

            $request->validate((new UserStoreRequest())->rules());

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->token = hash('sha256', time());
            $user->status = 0;
            $user->disabled = 1;

            $user->save();

            $verificationLink = route(
                'front.email-verification',
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

            $title = 'Register';
            return view('front.register', compact('title'));
        }
    }

    public function email_verification($token, $email): RedirectResponse
    {
        $user = User::where('email', $email)->where('token', $token)->first();
        if (!$user) {
            return redirect()->route('front.login');
        }

        $user->token = null;
        $user->status = 1;
        $user->disabled = 0;
        $user->update();

        $user->markEmailAsVerified();

        return redirect()->route('front.login')->with('success', 'Your email has been verified. You can now login
        to your account.');
    }

    public function about(): View
    {
        $title = 'About Us';
        return view('front.about', compact('title'));
    }

    public function contact(): View
    {
        $title = 'Contact Us';
        return view('front.contact', compact('title'));
    }

    public function privacy_policy(): View
    {
        $title = 'Privacy Policy';
        return view('front.privacy-policy', compact('title'));
    }

    public function terms_and_conditions(): View
    {
        $title = 'Terms & Conditions';
        return view('front.terms-and-conditions', compact('title'));
    }
}
