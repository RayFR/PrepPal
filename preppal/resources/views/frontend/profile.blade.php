@extends('layouts.app')

@section('title', 'My Account')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/pp-account.css') }}">
@endpush

@section('content')
<div class="container pp-acct">

  <div class="pp-acct__top">
    <div class="pp-acct__crumb">ACCOUNT HOME</div>
    <h1 class="pp-acct__welcome">Welcome, {{ auth()->user()->name }}</h1>
    <p class="pp-acct__sub">Manage your profile, orders and password in one place.</p>
  </div>

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

    <aside class="pp-acct__side card">
      <div class="pp-acct__side-head">
        <div class="pp-acct__avatar">
          @if(auth()->user()->avatar_path)
            <img src="{{ asset('storage/' . auth()->user()->avatar_path) }}" alt="Profile picture">
          @else
            <div class="pp-acct__avatar-fallback">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
          @endif
        </div>

        <div class="pp-acct__side-meta">
          <div class="pp-acct__name">{{ auth()->user()->name }}</div>
          <div class="pp-acct__email">{{ auth()->user()->email }}</div>
          <div class="pp-acct__since">Member since {{ optional(auth()->user()->created_at)->format('d M Y') }}</div>
        </div>
      </div>

      <nav class="pp-acct__nav">
        <a class="pp-acct__nav-item is-active" href="{{ route('profile.index') }}">Account Home</a>
        <a class="pp-acct__nav-item" href="{{ route('orders.index') }}">My Orders</a>

        <div class="pp-acct__nav-sep"></div>

        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="pp-acct__nav-item pp-acct__nav-item--danger">Log out</button>
        </form>
      </nav>
    </aside>

    <section class="pp-acct__main">

      <section class="card pp-panel" id="profile">
        <div class="pp-panel__head">
          <h2>My Profile</h2>
          <p>Update your details and profile picture.</p>
        </div>

        <div class="pp-panel__body">
          <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="pp-grid">
              <div>
                <label class="pp-label" for="name">Name</label>
                <input class="pp-input" id="name" name="name" type="text" value="{{ old('name', auth()->user()->name) }}" required>
              </div>

              <div>
                <label class="pp-label" for="email">Email</label>
                <input class="pp-input" id="email" name="email" type="email" value="{{ old('email', auth()->user()->email) }}" required>
              </div>
            </div>

            <div class="pp-upload">
              <div>
                <label class="pp-label">Profile picture</label>

                <input class="pp-file-hidden" id="avatar" name="avatar" type="file" accept="image/*">

                <div class="pp-upload__row">
                  <button type="button" class="pp-btn pp-btn--ghost" id="ppChooseFile">Choose file</button>
                  <span class="pp-upload__name" id="ppFileName">No file chosen</span>
                </div>

                <div class="pp-upload__hint">PNG/JPG/WebP up to 2MB. Shows in the top-right dropdown.</div>

                @if(auth()->user()->avatar_path)
                  <label class="pp-check">
                    <input type="checkbox" name="remove_avatar" value="1"> Remove current picture
                  </label>
                @endif
              </div>

              <div>
                <div class="pp-preview">
                  <div class="pp-preview__label">Preview</div>

                  @if(auth()->user()->avatar_path)
                    <img id="ppAvatarPreview" src="{{ asset('storage/' . auth()->user()->avatar_path) }}" alt="Preview">
                  @else
                    <div class="pp-preview__fallback" id="ppAvatarFallback">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
                    <img id="ppAvatarPreview" src="" alt="Preview" style="display:none;">
                  @endif
                </div>
              </div>
            </div>

            <div class="pp-actions">
              <button type="submit" class="pp-btn">Save changes</button>
            </div>
          </form>
        </div>
      </section>

      <section class="card pp-panel" id="password">
        <div class="pp-panel__head">
          <h2>Change Password</h2>
          <p>Use a strong password you don’t reuse elsewhere.</p>
        </div>

        <div class="pp-panel__body">
          <form method="POST" action="{{ route('profile.password') }}">
            @csrf
            @method('PUT')

            <div class="pp-grid pp-grid--3">
              <div>
                <label class="pp-label" for="current_password">Current</label>
                <input class="pp-input" id="current_password" name="current_password" type="password" required>
              </div>

              <div>
                <label class="pp-label" for="password">New</label>
                <input class="pp-input" id="password" name="password" type="password" required>
              </div>

              <div>
                <label class="pp-label" for="password_confirmation">Confirm</label>
                <input class="pp-input" id="password_confirmation" name="password_confirmation" type="password" required>
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

@push('scripts')
<script>
(function () {
  var input = document.getElementById('avatar');
  var chooseBtn = document.getElementById('ppChooseFile');
  var fileName = document.getElementById('ppFileName');
  var img = document.getElementById('ppAvatarPreview');
  var fallback = document.getElementById('ppAvatarFallback');

  if (chooseBtn && input) chooseBtn.addEventListener('click', function(){ input.click(); });

  if (input) {
    input.addEventListener('change', function () {
      var file = input.files && input.files[0];
      if (fileName) fileName.textContent = file ? file.name : 'No file chosen';

      if (file && img) {
        img.src = URL.createObjectURL(file);
        img.style.display = 'block';
        if (fallback) fallback.style.display = 'none';
      }
    });
  }
})();
</script>
@endpush