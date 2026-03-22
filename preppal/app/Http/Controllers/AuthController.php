<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Display the login page.
     */
    public function showLogin(): View
    {
        return view('frontend.login');
    }

    /**
     * Handle a login request.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('store'));
        }

        return back()
            ->withErrors([
                'email' => 'Invalid login details',
            ])
            ->withInput();
    }

    /**
     * Handle a registration request.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => $this->prepPalPasswordRules(),
            ],
            [
                'password.confirmed' => 'Passwords do not match.',
            ]
        );

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        Auth::login($user);

        return redirect()->intended(route('store'));
    }

    /**
     * Display the user dashboard.
     */
    public function dashboard(): View
    {
        return view('frontend.dashboard');
    }

    /**
     * Send a password reset link to the account email (users table has no separate username column).
     */
    public function forgotPassword(Request $request): RedirectResponse
    {
        $trimmed = strtolower(trim((string) $request->input('identifier', '')));

        $request->validate([
            'identifier' => ['required', 'string', 'email', 'max:255'],
        ]);

        $user = User::whereRaw('LOWER(email) = ?', [$trimmed])->first();

        $statusMessage = 'If an account matches that information, we’ve sent a password reset link.';

        if (! $user) {
            return back()->with('status', $statusMessage);
        }

        $status = Password::sendResetLink([
            'email' => $user->email,
        ]);

        if ($status !== Password::RESET_LINK_SENT) {
            return back()
                ->withErrors(['identifier' => __($status)])
                ->withInput();
        }

        return back()->with('status', $statusMessage);
    }

    /**
     * Show the form for entering a new password (linked from reset email).
     */
    public function showResetPasswordForm(Request $request, string $token): View
    {
        return view('frontend.auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    /**
     * Persist a new password after the user follows the email link.
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'token' => ['required', 'string'],
                'email' => ['required', 'email', 'max:255'],
                'password' => $this->prepPalPasswordRules(),
            ],
            [
                'password.confirmed' => 'Passwords do not match.',
            ]
        );

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => $password,
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            return back()
                ->withErrors(['email' => __($status)])
                ->withInput();
        }

        return redirect()
            ->route('login')
            ->with('status', __($status));
    }

    /**
     * @return array<int, \Illuminate\Contracts\Validation\Rule|string>
     */
    protected function prepPalPasswordRules(): array
    {
        return [
            'required',
            'confirmed',
            PasswordRule::min(6)->letters()->numbers()->symbols(),
        ];
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}