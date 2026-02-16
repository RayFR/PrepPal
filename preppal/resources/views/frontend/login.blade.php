@extends('layouts.app')

@section('title', 'Sign In')

@section('content')
    <div class="auth-wrapper">

        <div class="auth-card">

            <h1 class="auth-title">Welcome to PrepPal</h1>
            <p class="auth-subtitle">
                Sign in to access your dashboard, calculator and meal plans — or create a new account in seconds.
            </p>

            {{-- SHOW ERRORS --}}
            @if ($errors->any())
                <div style="margin: 12px 0; padding: 12px; border: 1px solid #ffb4b4; background:#ffecec; border-radius:10px;">
                    <b>Something went wrong:</b>
                    <ul style="margin: 6px 0 0 18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div style="margin: 12px 0; padding: 12px; border: 1px solid #b4ffcc; background:#ecfff2; border-radius:10px;">
                    {{ session('status') }}
                </div>
            @endif

            {{-- TABS --}}
            <div class="auth-tabs">
                <button class="auth-tab auth-tab-active" data-mode="login" type="button">Sign In</button>
                <button class="auth-tab" data-mode="register" type="button">Create Account</button>
            </div>

            {{-- LOGIN FORM --}}
            <form id="loginForm" class="auth-form auth-form-active" method="POST" action="{{ route('login') }}">
                @csrf

                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>

                <label>Password</label>

                <div class="password-field">
                    <input id="loginPassword" type="password" name="password" required>

                    <label class="show password">
                        <input type="checkbox" onclick="togglePassword('loginPassword', this)">
                        Show password
                    </label>
                </div>

                <button class="cta auth-btn" type="submit">Sign In</button>
                <div style="margin-top:10px; text-align:right;">
                    <a href="#" id="forgotLink" style="font-size:14px; text-decoration:underline;">
                        Forgot password?
                    </a>
                </div>



                <p class="auth-note">Admin demo login: <b>admin@preppal.com / 123456</b></p>

                <a class="auth-back" href="{{ route('home') }}">← Back to site</a>
            </form>

            {{-- REGISTER FORM --}}
            <form id="registerForm" class="auth-form" method="POST" action="{{ route('register') }}">
                @csrf

                <label>Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required>

                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>

                <label>Password</label>
                <input id="registerPassword" type="password" name="password" required>
                <label class="show-password">
                    <input type="checkbox" onclick="togglePassword('registerPassword', this)">
                    Show password
                </label>

                <label>Confirm Password</label>
                <input id="registerConfirmPassword" type="password" name="password_confirmation" required>
                <label class="show-password">
                    <input type="checkbox" onclick="togglePassword('registerConfirmPassword', this)">
                    Show password
                </label>

                <button class="cta auth-btn" type="submit">Create Account</button>

                <a class="auth-back" href="{{ route('home') }}">← Back to site</a>
            </form>

        </div>

        <div class="auth-info-card">
            <h2>Why PrepPal?</h2>

            <ol class="auth-list">
                <li><strong>01 — Personalised targets</strong><br>Get calorie & macro goals tailored to your lifestyle.</li>
                <li><strong>02 — Meal prep made easy</strong><br>Choose from fat loss, muscle gain, maintenance or fibre
                    plans.</li>
                <li><strong>03 — All in one place</strong><br>Your cart, orders and plans stay synced while browsing.</li>
            </ol>

            <p class="auth-footer">Better eating, one week at a time. 🥗</p>
        </div>

    </div>
    {{-- FORGOT PASSWORD MODAL --}}
    <div id="forgotModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.55); z-index:9999;">
        <div
            style="background:#fff; width:min(420px, 92vw); margin:12vh auto; padding:18px; border-radius:14px; box-shadow:0 20px 60px rgba(0,0,0,.25);">
            <div style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
                <h3 style="margin:0;">Forgot Password</h3>
                <button type="button" id="fp_close"
                    style="border:none; background:transparent; font-size:22px; cursor:pointer; line-height:1;">
                    &times;
                </button>
            </div>

            <p style="margin:10px 0 14px; color:#555;">
                Enter your username (or email) and click confirm.
            </p>

            <form method="POST" action="{{ route('password.forgot') }}">
                @csrf

                <label>Username / Email</label>
                <input type="text" name="identifier" id="fp_identifier" required
                    style="width:100%; padding:10px; border:1px solid #ddd; border-radius:10px;">

                <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:14px;">
                    <button type="button" id="fp_cancel" class="cta" style="background:#eee; color:#111;">Cancel</button>
                    <button type="submit" class="cta">Confirm</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(inputId, checkbox) {
            const input = document.getElementById(inputId);
            input.type = checkbox.checked ? 'text' : 'password';
        }

        // ==========================
        // Forgot Password Modal JS
        // ==========================

        const forgotLink = document.getElementById('forgotLink');
        const forgotModal = document.getElementById('forgotModal');
        const fpClose = document.getElementById('fp_close');
        const fpCancel = document.getElementById('fp_cancel');

        function openModal() {
            if (forgotModal) {
                forgotModal.style.display = 'block';
            }
        }

        function closeModal() {
            if (forgotModal) {
                forgotModal.style.display = 'none';
            }
        }

        // Open modal
        if (forgotLink) {
            forgotLink.addEventListener('click', function (e) {
                e.preventDefault();
                openModal();
            });
        }

        // Close via X
        if (fpClose) {
            fpClose.addEventListener('click', closeModal);
        }

        // Close via Cancel button
        if (fpCancel) {
            fpCancel.addEventListener('click', closeModal);
        }

        // Close if clicking outside modal box
        if (forgotModal) {
            forgotModal.addEventListener('click', function (e) {
                if (e.target === forgotModal) {
                    closeModal();
                }
            });
        }

        // Close with ESC key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && forgotModal && forgotModal.style.display === 'block') {
                closeModal();
            }
        });
    </script>

@endsection