<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MessageStoreRequest;
use App\Mail\ResetPassword;
use App\Models\System\Admin;
use App\Models\System\Message;
use App\Traits\RecaptchaValidation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class IndexController extends BaseAdminController
{
    use RecaptchaValidation;
    /**
     * Display the admin index page.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        if (Auth::guard('admin')->check()) {

            $owners = \App\Models\System\Admin::where('disabled', 0)
                ->orderBy('username', 'asc')
                ->paginate($perPage)->appends(request()->except('page'));

            return view(themedTemplate('admin.dashboard'), compact('owners'));

        } else {

            return view(themedTemplate('admin.index'));
        }
    }

    /**
     * Display the admin dashboard.
     *
     * @param Request $request
     * @return View
     */
    public function dashboard(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $owners = \App\Models\System\Admin::where('disabled', 0)
            ->orderBy('username', 'asc')->paginate($perPage)->appends(request()->except('page'));

        return view(themedTemplate('admin.dashboard'), compact('owners'));
    }

    /**
     * Login an admin.
     *
     * @param Request $request
     * @return RedirectResponse|View
     */
    public function login(Request $request): RedirectResponse|View
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
                    ->with('username', $username)
                    ->withErrors('Demo Admin account has been disabled.');
            }

            $request->validate([
                'username' => ['required'],
                'password' => ['required'],
            ]);

            if (config('app.captcha_enabled')) {
                $request->validate([
                    'g-recaptcha-response' => 'required|string',
                ]);

                // Validate reCAPTCHA
                $this->validateRecaptchaOrFail(
                    $request->input('g-recaptcha-response'),
                    'LOGIN'
                );
            }

            $data = [
                'username' => $username,
                'password' => $inputs['password'],
            ];

            if (Auth::guard('admin')->attempt($data)) {
                $admin = Auth::guard('admin')->user();
                if ($admin->disabled) {
                    return view(themedTemplate('admin.login'))
                        ->with('username', $username)
                        ->withErrors($admin->username . ' account has been disabled.');
                } else {
                    return redirect()->route('admin.dashboard');
                }
            } else {
                return view(themedTemplate('admin.login'))
                    ->with('username', $username)
                    ->withErrors(['GLOBAL' => 'Incorrect login information.<br>Double-check the username and password and try signing in again.']);
            }

        } else {

            return view(themedTemplate('admin.login'));
        }
    }

    /**
     * Logout an admin.
     *
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        Auth::guard('admin')->logout();
        return redirect()->route('guest.index')->with('success', 'Admin logout successful.');
    }

    /**
     * Display the forgot admin password page.
     *
     * @param Request $request
     * @return RedirectResponse|View
     */
    public function forgot_password(Request $request): RedirectResponse|View
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

    /**
     * Display the reset admin password play.
     *
     * @param $token
     * @param $email
     * @return RedirectResponse|View
     */
    public function reset_password($token, $email): RedirectResponse | View
    {
        if (!$admin = Admin::where('email', $email)->where('token', $token)->first()) {
            return redirect()->route('admin.login')
                ->with('error', 'Your reset password token is expired. Please try again.');
        } else {
            return view(themedTemplate('admin.reset-password'), compact('token', 'email'));
        }
    }

    /**
     * Submit the reset admin password.
     *
     * @param Request $request
     * @param $token
     * @param $email
     * @return RedirectResponse
     */
    public function reset_password_submit(Request $request, $token, $email): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()->letters()->numbers()->symbols()],
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

    public function about(): View
    {
        return view(themedTemplate('system.about'));
    }

    public function contact(): View
    {
        return view(themedTemplate('system.contact'));
    }

    /**
     * Store a submitted contact message in storage.
     *
     * @param MessageStoreRequest $messageStoreRequest
     * @return RedirectResponse
     */
    public function storeMessage(MessageStoreRequest $messageStoreRequest): RedirectResponse
    {
        die('@TODO: ???? Controllers\Admin\IndexController->storeMessage');
        $message = Message::create($messageStoreRequest->validated());

        return redirect(route('admin.dashboard'))
            ->with('success', 'Your message has been sent. Thank you!.');
    }

    public function privacy_policy(): View
    {
        return view(themedTemplate('system.privacy-policy'));
    }

    public function terms_and_conditions(): View
    {
        return view(themedTemplate('system.terms-and-conditions'));
    }

    /**
     * Download a file from the storage directory.
     *
     * @return StreamedResponse|null
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function download_from_storage(): StreamedResponse|null
    {
        $filePath = request()->get('file');
        $newFileName = request()->get('name');

        if (empty($filePath)) {
            return null;
        }

        $filePath = str_replace('/', DIRECTORY_SEPARATOR, $filePath);
        $filePath = str_replace('\\', DIRECTORY_SEPARATOR, $filePath);
        $filePath = trim($filePath, DIRECTORY_SEPARATOR);

        $filePathParts = explode(DIRECTORY_SEPARATOR, $filePath);

        if (empty($newFileName)) {

            $newFileName = $filePathParts[count($filePathParts) - 1];

        } else {

            $realFileName = explode('.', $filePathParts[count($filePathParts) - 1])[0];
            $realFileExt = explode('.', $filePathParts[count($filePathParts) - 1])[1] ?? '';

            if (!empty($realFileName)) {
                if (!$newFileNameExt = explode('.', $newFileName)[1] ?? false) {
                    $newFileName = $newFileName . '.' . $realFileExt;
                }
            }
        }

        return Storage::disk('public')->download($filePath, $newFileName);
    }
}
