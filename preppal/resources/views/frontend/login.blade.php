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
                <div class="pp-auth-alert" role="alert">
                    <div class="pp-auth-alert__title">Something went wrong</div>
                    <ul class="pp-auth-alert__list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="pp-auth-status" role="status">
                    {{ session('status') }}
                </div>
            @endif

            {{-- TABS --}}
            <div class="auth-tabs pp-auth-tabs" role="tablist" aria-label="Sign in or register">
                <button class="auth-tab auth-tab-active pp-auth-tab" type="button" data-mode="login" role="tab" aria-selected="true">Sign In</button>
                <button class="auth-tab pp-auth-tab" type="button" data-mode="register" role="tab" aria-selected="false">Create Account</button>
            </div>

            {{-- LOGIN FORM --}}
            <form id="loginForm" class="auth-form auth-form-active" method="POST" action="{{ route('login') }}">
                @csrf

                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>

                <label>Password</label>
                <div class="pp-passwrap">
                    <input
                        id="loginPassword"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                    />

                    <button
                        type="button"
                        class="pp-pass-toggle"
                        aria-label="Show password"
                        data-target="loginPassword"
                        aria-pressed="false"
                    >
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 5c5.5 0 9.6 4.2 10.9 6.2.2.3.2.7 0 1C21.6 14.8 17.5 19 12 19S2.4 14.8 1.1 12.2c-.2-.3-.2-.7 0-1C2.4 9.2 6.5 5 12 5zm0 2C7.8 7 4.4 10.2 3.2 11.7 4.4 13.2 7.8 17 12 17s7.6-3.8 8.8-5.3C19.6 10.2 16.2 7 12 7zm0 2.2A2.8 2.8 0 1 1 12 14.8a2.8 2.8 0 0 1 0-5.6z"/>
                        </svg>
                    </button>
                </div>

                <button class="pp-auth-submit" type="submit">Sign In</button>

                <div class="pp-auth-links">
  <a href="#" id="forgotLink" class="pp-forgot-link">
    Forgot password?
  </a>
</div>

                <p class="auth-note">Admin demo login: <b>admin@preppal.com / 123456</b></p>

                <a class="pp-backlink" href="{{ route('home') }}">
                    <span class="pp-backlink__icon">←</span>
                    <span>Back to site</span>
                </a>
            </form>

            {{-- REGISTER FORM --}}
            <form id="registerForm" class="auth-form" method="POST" action="{{ route('register') }}">
                @csrf

                <label>Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required>

                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>

                <label>Password</label>
                <div class="pp-passwrap">
                    <input id="registerPassword" type="password" name="password" required autocomplete="new-password" />
                    <button type="button" class="pp-pass-toggle" aria-label="Show password" data-target="registerPassword" aria-pressed="false">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 5c5.5 0 9.6 4.2 10.9 6.2.2.3.2.7 0 1C21.6 14.8 17.5 19 12 19S2.4 14.8 1.1 12.2c-.2-.3-.2-.7 0-1C2.4 9.2 6.5 5 12 5zm0 2C7.8 7 4.4 10.2 3.2 11.7 4.4 13.2 7.8 17 12 17s7.6-3.8 8.8-5.3C19.6 10.2 16.2 7 12 7zm0 2.2A2.8 2.8 0 1 1 12 14.8a2.8 2.8 0 0 1 0-5.6z"/>
                        </svg>
                    </button>
                </div>

                {{-- Password rules UI (frontend hint + live checks) --}}
      <p class="pp-pass-hint" id="ppPassHint">
        Password must be at least <b>6 characters</b> and include a <b>number</b> and a <b>symbol</b> (e.g. <b>@</b>).
      </p>
      <ul class="pp-pass-rules" id="ppPassRules">
        <li data-rule="len">6+ characters</li>
        <li data-rule="num">Contains a number</li>
        <li data-rule="sym">Contains a symbol (@!%…)</li>
      </ul>

                <label>Confirm Password</label>
                <div class="pp-passwrap">
                    <input id="registerConfirmPassword" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <button type="button" class="pp-pass-toggle" aria-label="Show password" data-target="registerConfirmPassword" aria-pressed="false">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 5c5.5 0 9.6 4.2 10.9 6.2.2.3.2.7 0 1C21.6 14.8 17.5 19 12 19S2.4 14.8 1.1 12.2c-.2-.3-.2-.7 0-1C2.4 9.2 6.5 5 12 5zm0 2C7.8 7 4.4 10.2 3.2 11.7 4.4 13.2 7.8 17 12 17s7.6-3.8 8.8-5.3C19.6 10.2 16.2 7 12 7zm0 2.2A2.8 2.8 0 1 1 12 14.8a2.8 2.8 0 0 1 0-5.6z"/>
                        </svg>
                    </button>
                </div>

                <div class="pp-auth-actions">
                    <button class="pp-auth-submit" type="submit">Create Account</button>

                    <a class="pp-backlink" href="{{ route('home') }}">
                        <span class="pp-backlink__icon">←</span>
                        <span>Back to site</span>
                    </a>
                </div>
            </form>

        </div>

        <div class="auth-info-card">
            <h2>Why PrepPal?</h2>

            <ol class="auth-list">
                <li><strong>01 — Personalised targets</strong><br>Get calorie & macro goals tailored to your lifestyle.</li>
                <li><strong>02 — Meal prep made easy</strong><br>Choose from fat loss, muscle gain, maintenance or fibre plans.</li>
                <li><strong>03 — All in one place</strong><br>Your cart, orders and plans stay synced while browsing.</li>
            </ol>

            <p class="auth-footer">Better eating, one week at a time.</p>
        </div>

    </div>

    {{-- FORGOT PASSWORD MODAL --}}
    <div id="forgotModal" class="pp-auth-modal" style="display:none;" aria-hidden="true">
        <div class="pp-auth-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="ppForgotTitle">
            <div class="pp-auth-modal__head">
                <h3 id="ppForgotTitle" class="pp-auth-modal__title">Forgot password</h3>
                <button type="button" id="fp_close" class="pp-auth-modal__x" aria-label="Close">&times;</button>
            </div>

            <p class="pp-auth-modal__lede">
                Enter the email address you used to register. If an account exists, we will send a reset link there.
            </p>

            <form method="POST" action="{{ route('password.forgot') }}">
                @csrf

                <label class="pp-auth-modal__label" for="fp_identifier">Email</label>
                <input
                    type="email"
                    name="identifier"
                    id="fp_identifier"
                    class="pp-auth-modal__input"
                    value="{{ old('identifier') }}"
                    required
                    maxlength="255"
                    autocomplete="email"
                    inputmode="email"
                >

                <div class="pp-auth-modal__actions">
                    <button type="button" id="fp_cancel" class="pp-auth-modal__btn pp-auth-modal__btn--ghost">Cancel</button>
                    <button type="submit" class="pp-auth-modal__btn pp-auth-modal__btn--primary">Send reset link</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // ==========================
        // Forgot Password Modal JS
        // ==========================
        const forgotLink = document.getElementById('forgotLink');
        const forgotModal = document.getElementById('forgotModal');
        const fpClose = document.getElementById('fp_close');
        const fpCancel = document.getElementById('fp_cancel');

        function openModal() {
            if (forgotModal) {
                forgotModal.style.display = 'flex';
                forgotModal.setAttribute('aria-hidden', 'false');
            }
        }

        function closeModal() {
            if (forgotModal) {
                forgotModal.style.display = 'none';
                forgotModal.setAttribute('aria-hidden', 'true');
            }
        }

        if (forgotLink) {
            forgotLink.addEventListener('click', function (e) {
                e.preventDefault();
                openModal();
            });
        }

        if (fpClose) fpClose.addEventListener('click', closeModal);
        if (fpCancel) fpCancel.addEventListener('click', closeModal);

        if (forgotModal) {
            forgotModal.addEventListener('click', function (e) {
                if (e.target === forgotModal) closeModal();
            });
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && forgotModal && forgotModal.style.display === 'flex') {
                closeModal();
            }
        });

        @if ($errors->has('identifier'))
        document.addEventListener('DOMContentLoaded', function () { openModal(); });
        @endif
    </script>
@endsection