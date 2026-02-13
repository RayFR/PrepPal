@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container" style="max-width: 900px;">

    <h1 style="margin-bottom: 0.25rem;">My Profile</h1>
    <p style="margin-top: 0; opacity: 0.8;">View and update your account details.</p>

    @if (session('success'))
        <div class="alert alert-success" style="margin: 1rem 0;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger" style="margin: 1rem 0;">
            <strong>Please fix the following:</strong>
            <ul style="margin: 0.5rem 0 0 1.25rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr; gap: 1.25rem; margin-top: 1.25rem;">

        <section class="card" style="padding: 1.25rem; border-radius: 12px;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; gap: 1rem; flex-wrap: wrap;">
                <div>
                    <h2 style="margin:0 0 0.5rem;">Account</h2>
                    <p style="margin:0; opacity:0.85;">
                        Signed in as <strong>{{ auth()->user()->name }}</strong>
                    </p>
                    <p style="margin:0.25rem 0 0; opacity:0.85;">
                        Email: <strong>{{ auth()->user()->email }}</strong>
                    </p>
                </div>

                <div style="text-align:right;">
                    <p style="margin:0; opacity:0.75; font-size: 0.95rem;">
                        Member since:
                        <strong>{{ optional(auth()->user()->created_at)->format('d M Y') }}</strong>
                    </p>
                </div>
            </div>
        </section>

        <section class="card" style="padding: 1.25rem; border-radius: 12px;">
            <h2 style="margin-top:0;">Update details</h2>

            <form method="POST" action="{{ route('profile.update') }}" style="margin-top: 1rem;">
                @csrf
                @method('PUT')

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label for="name" style="display:block; margin-bottom: 0.35rem;">Name</label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name', auth()->user()->name) }}"
                            required
                            style="width:100%; padding:0.65rem; border-radius:10px;"
                        >
                    </div>

                    <div>
                        <label for="email" style="display:block; margin-bottom: 0.35rem;">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email', auth()->user()->email) }}"
                            required
                            style="width:100%; padding:0.65rem; border-radius:10px;"
                        >
                    </div>
                </div>

                <div style="margin-top: 1rem;">
                    <button type="submit" class="cart-btn" style="padding:0.7rem 1rem; border-radius:10px;">
                        Save changes
                    </button>
                </div>
            </form>
        </section>

        <section class="card" style="padding: 1.25rem; border-radius: 12px;">
            <h2 style="margin-top:0;">Change password</h2>

            <form method="POST" action="{{ route('profile.password') }}" style="margin-top: 1rem;">
                @csrf
                @method('PUT')

                <div style="display:grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                    <div>
                        <label for="current_password" style="display:block; margin-bottom: 0.35rem;">Current</label>
                        <input
                            id="current_password"
                            name="current_password"
                            type="password"
                            autocomplete="current-password"
                            required
                            style="width:100%; padding:0.65rem; border-radius:10px;"
                        >
                    </div>

                    <div>
                        <label for="password" style="display:block; margin-bottom: 0.35rem;">New</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="new-password"
                            required
                            style="width:100%; padding:0.65rem; border-radius:10px;"
                        >
                    </div>

                    <div>
                        <label for="password_confirmation" style="display:block; margin-bottom: 0.35rem;">Confirm</label>
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            autocomplete="new-password"
                            required
                            style="width:100%; padding:0.65rem; border-radius:10px;"
                        >
                    </div>
                </div>

                <div style="margin-top: 1rem;">
                    <button type="submit" class="cart-btn" style="padding:0.7rem 1rem; border-radius:10px;">
                        Update password
                    </button>
                </div>
            </form>
        </section>

        <section class="card" style="padding: 1.25rem; border-radius: 12px; border: 1px solid rgba(255,0,0,0.25);">
            <h2 style="margin-top:0;">Delete</h2>
            <p style="opacity:0.85; margin-top:0;">
                DELETE ACCOUNT (probably will add soon)
            </p>
        </section>

    </div>
</div>
@endsection
