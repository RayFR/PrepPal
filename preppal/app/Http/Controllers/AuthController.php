<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($data)) {
            $request->session()->regenerate();

            // ✅ send user back to the page they originally wanted (e.g. /store)
            // fallback: store
            return redirect()->intended(route('store'));
        }

        return back()->withErrors([
            'email' => 'Invalid login details'
        ])->withInput();
    }

    // Handle registration request
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'username' => $data['name'],
            'email' => $data['email'],
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

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
