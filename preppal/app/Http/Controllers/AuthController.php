<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
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
                'password' => [
                    'required',
                    'confirmed',
                    PasswordRule::min(6)->letters()->numbers()->symbols(),
                ],
            ],
            [
                'password.confirmed' => 'Passwords do not match.',
            ]
        );

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
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
     * Send a password reset link using either email or username.
     */
    public function forgotPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'identifier' => ['required', 'string'],
        ]);

        $identifier = trim($request->input('identifier'));

        $user = User::where('email', $identifier)
            ->orWhere('username', $identifier)
            ->first();

        $statusMessage = 'If an account matches that information, we’ve sent a password reset link.';

        if (! $user) {
            return back()->with('status', $statusMessage);
        }

        Password::sendResetLink([
            'email' => $user->email,
        ]);

        return back()->with('status', $statusMessage);
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