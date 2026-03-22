@extends('layouts.app')

@section('title', 'Admin - Edit Customer')

@section('content')
<div class="pp-admin">
    <div class="container pp-admin__inner">

        @include('frontend.admin.partials.toolbar')

        <a href="{{ route('admin.customers.index') }}" class="pp-admin__back">← Back to customers</a>

        <header class="pp-admin__hero">
            <div>
                <p class="pp-admin__eyebrow">Customer</p>
                <h1>Edit account</h1>
                <p class="pp-admin__lede">{{ $user->email }}</p>
            </div>
        </header>

        @if ($errors->any())
            <div class="pp-admin__alert pp-admin__alert--danger">
                <strong>Please fix the following:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="pp-admin__panel">
            <div class="pp-admin__panel-header">
                <h2>Details</h2>
            </div>
            <form method="POST" action="{{ route('admin.customers.update', $user->id) }}">
                @csrf
                @method('PUT')

                <div class="pp-admin__form-grid">
                    <div class="pp-admin__field">
                        <label class="pp-admin__label" for="name">Name</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            required
                            class="pp-admin__input pp-admin__input--block"
                        >
                    </div>
                    <div class="pp-admin__field">
                        <label class="pp-admin__label" for="email">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            required
                            class="pp-admin__input pp-admin__input--block"
                        >
                    </div>
                </div>

                <div style="margin-top:1rem;">
                    <label class="pp-admin__check">
                        <input
                            type="checkbox"
                            name="is_admin"
                            value="1"
                            {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}
                        >
                        Admin user
                    </label>
                </div>

                <div class="pp-admin__form-actions">
                    <button type="submit" class="pp-admin__btn pp-admin__btn--primary">Save changes</button>
                </div>
            </form>
        </div>

        <div class="pp-admin__panel pp-admin__panel--danger-zone">
            <div class="pp-admin__panel-header">
                <h2>Delete user</h2>
                <p class="pp-admin__lede" style="margin-top:0.35rem;">Permanently remove this account. This cannot be undone.</p>
            </div>
            <form
                method="POST"
                action="{{ route('admin.customers.destroy', $user->id) }}"
                onsubmit="return confirm('Delete this user? This cannot be undone.');"
            >
                @csrf
                @method('DELETE')
                <button type="submit" class="pp-admin__btn pp-admin__btn--danger">Delete user</button>
            </form>
        </div>

    </div>
</div>
@endsection
