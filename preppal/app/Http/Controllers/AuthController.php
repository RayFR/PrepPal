<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;

class AuthController extends Controller
{
    // Show login page
    public function showLogin()
    {
        return view('frontend.login');
    }

    // Handle login request
    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($data)) {
            $request->session()->regenerate();

            // ✅ send user back to the page they originally wanted (e.g. /store)
            // fallback: store
            return redirect()->intended(route('store'));
        }

        return back()->withErrors([
            'email' => 'Invalid login details',
        ])->withInput();
    }

    // Handle registration request
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                // ✅ min 6 chars + must contain letters, numbers, and symbols (e.g. @)
                PasswordRule::min(6)->letters()->numbers()->symbols(),
            ],
        ], [
            // Nice readable error message (optional)
            'password.confirmed' => 'Passwords do not match.',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'username' => $data['name'], // keep your existing behavior
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        // ✅ same behavior for sign up: go to intended URL, fallback store
        return redirect()->intended(route('store'));
    }

    // Dashboard view
    public function dashboard()
    {
        return view('frontend.dashboard');
    }

    public function forgotPassword(Request $request)
    {
        // Accept either username OR email from the popup
        $request->validate([
            'identifier' => ['required', 'string'],
        ]);

        $identifier = trim($request->identifier);

        // If user typed a username, resolve to email. If they typed email, use it directly.
        $user = User::where('email', $identifier)
            ->orWhere('username', $identifier)
            ->first();

        // Always respond with the same message (prevents user-enumeration)
        $genericMsg = 'If an account matches that information, we’ve sent a password reset link.';

        if (!$user) {
            return back()->with('status', $genericMsg);
        }

        Password::sendResetLink(['email' => $user->email]);

        // Even if sending fails, don’t reveal details
        return back()->with('status', $genericMsg);
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}