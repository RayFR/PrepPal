@extends('layouts.app')

@section('title', 'Profile photo')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/pp-account.css') }}">
@endpush

@section('content')
<div class="container pp-acct">

  <div class="pp-acct__top">
    <div class="pp-acct__crumb">PROFILE PHOTO</div>
    <h1 class="pp-acct__welcome">Profile picture</h1>
    <p class="pp-acct__sub">Upload a photo for your account. It appears in the header menu and in your account sidebar.</p>
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

    @include('frontend.partials.account-sidebar', ['active' => 'photo'])

    <section class="pp-acct__main">
      <section class="card pp-panel" id="profile-photo">
        <div class="pp-panel__head">
          <h2>Upload</h2>
          <p>PNG, JPG, GIF or WebP. Maximum size 2&nbsp;MB.</p>
        </div>

        <div class="pp-panel__body">
          <form method="POST" action="{{ route('profile.avatar.update') }}" enctype="multipart/form-data">
            @csrf

            <div class="pp-upload">
              <div>
                <label class="pp-label" for="avatar">Choose image</label>

                <input class="pp-file-hidden" id="avatar" name="avatar" type="file" accept="image/jpeg,image/png,image/gif,image/webp" required>

                <div class="pp-upload__row">
                  <button type="button" class="pp-btn pp-btn--ghost" id="ppChooseFile">Choose file</button>
                  <span class="pp-upload__name" id="ppFileName">No file chosen</span>
                </div>

                <div class="pp-upload__hint">Square images look best. Your previous picture is replaced when you upload a new one.</div>
              </div>

              <div>
                <div class="pp-preview">
                  <div class="pp-preview__label">Preview</div>

                  @if (auth()->user()->avatar_path)
                    <img id="ppAvatarPreview" src="{{ asset('storage/' . auth()->user()->avatar_path) }}" alt="Current profile picture">
                    <div class="pp-preview__fallback" id="ppAvatarFallback" style="display:none;">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
                  @else
                    <div class="pp-preview__fallback" id="ppAvatarFallback">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
                    <img id="ppAvatarPreview" src="" alt="Preview" style="display:none;">
                  @endif
                </div>
              </div>
            </div>

            <div class="pp-actions">
              <button type="submit" class="pp-btn">Save photo</button>
            </div>
          </form>

          @if (auth()->user()->avatar_path)
            <form method="POST" action="{{ route('profile.avatar.destroy') }}" class="pp-actions" style="margin-top: 10px;" onsubmit="return confirm('Remove your profile picture?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="pp-btn pp-btn--ghost">Remove current photo</button>
            </form>
          @endif
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

  if (chooseBtn && input) chooseBtn.addEventListener('click', function () { input.click(); });

  if (input) {
    input.addEventListener('change', function () {
      var file = input.files && input.files[0];
      if (fileName) fileName.textContent = file ? file.name : 'No file chosen';

      if (file && img) {
        if (img.src && img.src.indexOf('blob:') === 0) URL.revokeObjectURL(img.src);
        img.src = URL.createObjectURL(file);
        img.style.display = 'block';
        img.alt = 'Selected image preview';
        if (fallback) fallback.style.display = 'none';
      }
    });
  }
})();
</script>
@endpush
