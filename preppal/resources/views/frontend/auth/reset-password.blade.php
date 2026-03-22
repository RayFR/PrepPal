@extends('layouts.app')

@section('title', 'Reset password')

@section('content')
<div class="auth-wrapper">
  <div class="auth-card" style="max-width: 480px; margin: 4rem auto;">
    <h1 class="auth-title">Set a new password</h1>
    <p class="auth-subtitle">Choose a strong password you have not used elsewhere.</p>

    @if ($errors->any())
      <div class="pp-auth-alert" role="alert">
        <div class="pp-auth-alert__title">Please fix the following</div>
        <ul class="pp-auth-alert__list">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" class="auth-form-active" style="display:block;">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">

      <label for="reset_email">Email</label>
      <input
        id="reset_email"
        type="email"
        name="email"
        value="{{ old('email', $email) }}"
        required
        autocomplete="username"
      >

      <label for="reset_password">New password</label>
      <div class="pp-passwrap">
        <input
          id="reset_password"
          type="password"
          name="password"
          required
          autocomplete="new-password"
          minlength="6"
        >
        <button type="button" class="pp-pass-toggle" aria-label="Show password" data-target="reset_password" aria-pressed="false">
          <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M12 5c5.5 0 9.6 4.2 10.9 6.2.2.3.2.7 0 1C21.6 14.8 17.5 19 12 19S2.4 14.8 1.1 12.2c-.2-.3-.2-.7 0-1C2.4 9.2 6.5 5 12 5zm0 2C7.8 7 4.4 10.2 3.2 11.7 4.4 13.2 7.8 17 12 17s7.6-3.8 8.8-5.3C19.6 10.2 16.2 7 12 7zm0 2.2A2.8 2.8 0 1 1 12 14.8a2.8 2.8 0 0 1 0-5.6z"/>
          </svg>
        </button>
      </div>

      <p class="pp-pass-hint">At least <b>6 characters</b>, with a <b>number</b> and a <b>symbol</b>.</p>

      <label for="reset_password_confirmation">Confirm new password</label>
      <div class="pp-passwrap">
        <input
          id="reset_password_confirmation"
          type="password"
          name="password_confirmation"
          required
          autocomplete="new-password"
          minlength="6"
        >
        <button type="button" class="pp-pass-toggle" aria-label="Show password" data-target="reset_password_confirmation" aria-pressed="false">
          <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M12 5c5.5 0 9.6 4.2 10.9 6.2.2.3.2.7 0 1C21.6 14.8 17.5 19 12 19S2.4 14.8 1.1 12.2c-.2-.3-.2-.7 0-1C2.4 9.2 6.5 5 12 5zm0 2C7.8 7 4.4 10.2 3.2 11.7 4.4 13.2 7.8 17 12 17s7.6-3.8 8.8-5.3C19.6 10.2 16.2 7 12 7zm0 2.2A2.8 2.8 0 1 1 12 14.8a2.8 2.8 0 0 1 0-5.6z"/>
          </svg>
        </button>
      </div>

      <button type="submit" class="pp-auth-submit">Update password</button>

      <a class="pp-backlink" href="{{ route('login') }}">
        <span class="pp-backlink__icon">←</span>
        <span>Back to sign in</span>
      </a>
    </form>
  </div>
</div>
@endsection
