@extends('layouts.app')

@section('title', 'Admin - Edit Customer')

@section('content')
<div class="container" style="max-width: 900px;">

    <a href="{{ route('admin.customers.index') }}" style="text-decoration:none;">← Back to customers</a>

    <h1 style="margin: 1rem 0 0.25rem;">Edit Customer</h1>
    <p style="margin-top: 0; opacity: 0.8;">Update customer details and admin/security flags.</p>

    @if($errors->any())
        <div class="alert alert-danger" style="margin: 1rem 0;">
            <strong>Please fix the following:</strong>
            <ul style="margin: 0.5rem 0 0 1.25rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card" style="padding: 1.25rem; border-radius: 12px; margin-top: 1rem;">
        <form method="POST" action="{{ route('admin.customers.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label style="display:block; margin-bottom:0.35rem;">Name</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        required
                        style="width:100%; padding:0.65rem; border-radius:10px;"
                    >
                </div>

                <div>
                    <label style="display:block; margin-bottom:0.35rem;">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        required
                        style="width:100%; padding:0.65rem; border-radius:10px;"
                    >
                </div>
            </div>

            <div style="margin-top: 1rem; display:flex; gap:1rem; flex-wrap:wrap;">
                <label style="display:flex; align-items:center; gap:0.5rem;">
                    <input
                        type="checkbox"
                        name="is_admin"
                        value="1"
                        {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}
                    >
                    Admin user
                </label>

            </div>

            <div style="margin-top: 1.25rem;">
                <button type="submit" class="cart-btn" style="padding:0.7rem 1rem; border-radius:10px;">
                    Save changes
                </button>
            </div>
        </form>
    </div>

    <div class="card" style="padding: 1.25rem; border-radius: 12px; margin-top: 1rem; border: 1px solid rgba(255,0,0,0.25);">
        <h2 style="margin-top:0;">Delete user</h2>
        <p style="opacity:0.85; margin-top:0;">
            This action cannot be undone.
        </p>

        <form method="POST" action="{{ route('admin.customers.destroy', $user->id) }}"
              onsubmit="return confirm('Delete this user? This cannot be undone.');">
            @csrf
            @method('DELETE')
            <button type="submit" style="padding:0.7rem 1rem; border-radius:10px; background:#c00; color:#fff; border:none; cursor:pointer;">
                Delete user
            </button>
        </form>
    </div>

</div>
@endsection