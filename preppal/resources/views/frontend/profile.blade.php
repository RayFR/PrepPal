@extends('layouts.app')

@section('title', 'My Account')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/pp-account.css') }}">
@endpush

@section('content')
<div class="container pp-acct">

  <header class="pp-acct__hero">
    <div class="pp-acct__hero-inner">
      <p class="pp-acct__eyebrow">Your account</p>
      <h1 class="pp-acct__welcome">Hi, {{ auth()->user()->name }}</h1>
      <p class="pp-acct__sub">Update how we reach you, keep your password fresh, and jump to orders or your photo from the shortcuts below.</p>
    </div>
  </header>

  @if (session('success'))
    <div class="pp-acct__alert pp-acct__alert--success">{{ session('success') }}</div>
  @endif

  @if ($errors->any())
    <div class="pp-acct__alert pp-acct__alert--danger">
      <strong>Please fix the following:</strong>
      <ul>
        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
      </ul>
    </div>
  @endif

  <div class="pp-acct__layout">

    @include('frontend.partials.account-sidebar', ['active' => 'home'])

    <section class="pp-acct__main">

      <div class="pp-acct__tiles" aria-label="Account shortcuts">
        <a class="pp-tile pp-tile--link" href="{{ route('orders.index') }}">
          <div class="pp-tile__title">Order history</div>
          <p class="pp-tile__text">Track deliveries and request returns.</p>
          <span class="pp-tile__cta">View orders →</span>
        </a>
        <a class="pp-tile pp-tile--link" href="{{ route('profile.avatar') }}">
          <div class="pp-tile__title">Profile photo</div>
          <p class="pp-tile__text">Show your picture in the header menu.</p>
          <span class="pp-tile__cta">Upload photo →</span>
        </a>
        <a class="pp-tile pp-tile--link" href="{{ route('store') }}">
          <div class="pp-tile__title">Store</div>
          <p class="pp-tile__text">Browse meals, supplements, and more.</p>
          <span class="pp-tile__cta">Go shopping →</span>
        </a>
      </div>

      <section class="card pp-panel pp-panel--accent" id="profile">
        <div class="pp-panel__head">
          <div class="pp-panel__head-text">
            <h2>Contact details</h2>
            <p>Name and email used for orders and sign-in.</p>
          </div>
        </div>

        <div class="pp-panel__body">
          <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <div class="pp-grid">
              <div>
                <label class="pp-label" for="name">Full name</label>
                <input class="pp-input" id="name" name="name" type="text" value="{{ old('name', auth()->user()->name) }}" required autocomplete="name">
              </div>

              <div>
                <label class="pp-label" for="email">Email</label>
                <input class="pp-input" id="email" name="email" type="email" value="{{ old('email', auth()->user()->email) }}" required autocomplete="email">
              </div>
            </div>

            <div class="pp-actions">
              <button type="submit" class="pp-btn pp-btn--primary">Save changes</button>
            </div>
          </form>
        </div>
      </section>

      <section class="card pp-panel pp-panel--muted" id="password">
        <div class="pp-panel__head">
          <div class="pp-panel__head-text">
            <h2>Password</h2>
            <p>Use at least 6 characters with a number and a symbol, matching the rules for new accounts.</p>
          </div>
        </div>

        <div class="pp-panel__body">
          <form method="POST" action="{{ route('profile.password') }}">
            @csrf
            @method('PUT')

            <div class="pp-grid pp-grid--3">
              <div>
                <label class="pp-label" for="current_password">Current password</label>
                <input class="pp-input" id="current_password" name="current_password" type="password" required autocomplete="current-password">
              </div>

              <div>
                <label class="pp-label" for="password">New password</label>
                <input class="pp-input" id="password" name="password" type="password" required autocomplete="new-password" minlength="8">
              </div>

              <div>
                <label class="pp-label" for="password_confirmation">Confirm new</label>
                <input class="pp-input" id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" minlength="6">
              </div>
            </div>

            <div class="pp-actions">
              <button type="submit" class="pp-btn pp-btn--ghost">Update password</button>
            </div>
          </form>
        </div>
      </section>

    </section>
  </div>
</div>
@endsection