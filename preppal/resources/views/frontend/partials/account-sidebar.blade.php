@php
  $active = $active ?? 'home';
  $u = auth()->user();
@endphp

<aside class="pp-acct__side card">
  <div class="pp-acct__side-head">
    <div class="pp-acct__avatar">
      @if ($u->avatar_path)
        <img src="{{ asset('storage/' . $u->avatar_path) }}" alt="">
      @else
        <div class="pp-acct__avatar-fallback">{{ strtoupper(substr($u->name ?? 'U', 0, 1)) }}</div>
      @endif
    </div>

    <div class="pp-acct__side-meta">
      <div class="pp-acct__name">{{ $u->name }}</div>
      <div class="pp-acct__email">{{ $u->email }}</div>
      <div class="pp-acct__since">Member since {{ optional($u->created_at)->format('d M Y') }}</div>
    </div>
  </div>

  <nav class="pp-acct__nav">
    <a class="pp-acct__nav-item {{ $active === 'home' ? 'is-active' : '' }}" href="{{ route('profile.index') }}">Account Home</a>
    <a class="pp-acct__nav-item {{ $active === 'photo' ? 'is-active' : '' }}" href="{{ route('profile.avatar') }}">Profile photo</a>
    <a class="pp-acct__nav-item {{ $active === 'orders' ? 'is-active' : '' }}" href="{{ route('orders.index') }}">My Orders</a>

    <div class="pp-acct__nav-sep"></div>

    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="pp-acct__nav-item pp-acct__nav-item--danger">Log out</button>
    </form>
  </nav>
</aside>
