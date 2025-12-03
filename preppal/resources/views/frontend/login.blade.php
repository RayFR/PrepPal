@extends('layouts.app')

@section('title', 'Sign In')

@section('content')
<div class="auth-wrapper">

    {{-- LEFT SIDE — AUTH CARD --}}
    <div class="auth-card">

        <h1 class="auth-title">Welcome to PrepPal</h1>
        <p class="auth-subtitle">
            Sign in to access your dashboard, calculator and meal plans — or create a new account in seconds.
        </p>

        {{-- TABS --}}
        <div class="auth-tabs">
            <button class="auth-tab auth-tab-active" data-mode="login">Sign In</button>
            <button class="auth-tab" data-mode="register">Create Account</button>
        </div>

        {{-- LOGIN FORM --}}
        <form id="loginForm" class="auth-form auth-form-active" method="POST" action="/login">
            @csrf

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button class="cta auth-btn" type="submit">Sign In</button>

            <p class="auth-note">Admin demo login: <b>admin@preppal.com / 123456</b></p>

            <a class="auth-back" href="/">← Back to site</a>
        </form>

        {{-- REGISTER FORM --}}
        <form id="registerForm" class="auth-form" method="POST" action="/register">
            @csrf

            <label>Full Name</label>
            <input type="text" name="name" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" required>

            <button class="cta auth-btn" type="submit">Create Account</button>

            <a class="auth-back" href="/">← Back to site</a>
        </form>

    </div>

    {{-- RIGHT SIDE — INFO PANEL --}}
    <div class="auth-info-card">
        <h2>Why PrepPal?</h2>

        <ol class="auth-list">
            <li>
                <strong>01 — Personalised targets</strong><br>
                Get calorie & macro goals tailored to your lifestyle.
            </li>

            <li>
                <strong>02 — Meal prep made easy</strong><br>
                Choose from fat loss, muscle gain, maintenance or fibre plans.
            </li>

            <li>
                <strong>03 — All in one place</strong><br>
                Your cart, orders and plans stay synced while browsing.
            </li>
        </ol>

        <p class="auth-footer">
            Better eating, one week at a time. 🥗
        </p>
    </div>

</div>
@endsection
