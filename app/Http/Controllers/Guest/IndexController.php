<?php

namespace App\Http\Controllers\Guest;

use App\Http\Requests\MessageStoreRequest;
use App\Http\Requests\System\StoreUsersRequest;
use App\Mail\ForgotUsername;
use App\Mail\ResetPassword;
use App\Mail\VerifyEmail;
use App\Models\System\Message;
use App\Models\System\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class IndexController extends BaseGuestController
{
    public function index(): View
    {
        return view('guest.index');
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

            if (Auth::guard('web')->attempt($data)) {
                return redirect()->route('user.dashboard');
            } else {
                return view('guest.login')->withErrors('Invalid login credentials. Please try again.');
            }

        } else {

            return view('guest.login');
        }
    }

    public function logout(): RedirectResponse
    {
        Auth::guard('web')->logout();
        return redirect()->route('guest.homepage')->with('success', 'User logout successful.');
    }

    public function forgot_password(Request $request): RedirectResponse | View
    {
        if ($request->isMethod('post')) {

            $request->validate([
                'email' => ['email', 'required']
            ]);

            $email = $request->email ?? '';
            if (!$user = User::where('email', $email)->where('status', 1)->first()) {
                return view('guest.forgot-password')->withErrors('User with provided email does not exist.');
            }

            $user->token = hash('sha256', time());
            $user->update();

            $pResetLink = route('guest.reset-password', ['token' => $user->token, 'email' => urlencode($email)]);
            $subject = "Reset Password from " . config('app.name');
            $info = [
                'user'       => $user->name,
                'email'      => $user->email,
                'pResetLink' => $pResetLink
            ];

            Mail::to($request->email)->send(new ResetPassword($subject, $info));

            return redirect()->back()->with('success', 'A reset link has been sent to your email address. Please check your
            email. If you do not find the email in your inbox, please check your spam folder.');

        } else {

            return view('guest.forgot-password');
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
                return view('guest.forgot-username')->withErrors('User with provided username does not exist.');
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

            return view('guest.forgot-username');
        }
    }

    public function reset_password($token, $email): RedirectResponse |View
    {
        if (!$user = User::where('email', $email)->where('token', $token)->first()) {
            return redirect()->route('guest.login')->with('error', 'Your reset password token is expired. Please try again.');
        } else {
            return view('guest.reset-password', compact('token', 'email'));
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

        return redirect()->route('guest.login')
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
                'guest.email-verification',
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

            return view('guest.register');
        }
    }

    public function email_verification($token, $email): RedirectResponse
    {
        $user = User::where('email', $email)->where('token', $token)->first();
        if (!$user) {
            return redirect()->route('guest.login');
        }

        $user->token = null;
        $user->status = 1;
        $user->disabled = 0;
        $user->update();

        $user->markEmailAsVerified();

        return redirect()->route('guest.login')->with('success', 'Your email has been verified. You can now login
        to your account.');
    }

    public function about(): View
    {
        $title = 'About Us';
        return view('guest.about', compact('title'));
    }

    public function contact(): View
    {
        $title = 'Contact Us';
        return view('guest.contact', compact('title'));
    }

    /**
     * Store a submitted contact message in storage.
     *
     * @param MessageStoreRequest $messageStoreRequest
     * @return RedirectResponse
     */
    public function storeMessage(MessageStoreRequest $messageStoreRequest): RedirectResponse
    {
        $message = Message::create($messageStoreRequest->validated());

        return redirect(route('guest.homepage'))->with('success', 'Your message has been sent. Thank you!.');
    }

    public function privacy_policy(): View
    {
        $title = 'Privacy Policy';
        return view('guest.privacy-policy', compact('title'));
    }

    public function terms_and_conditions(): View
    {
        $title = 'Terms & Conditions';
        return view('guest.terms-and-conditions', compact('title'));
    }
}
