@extends('layouts.app')

@section('title', 'Admin - Customers')

@section('content')
<div class="pp-admin">
    <div class="container pp-admin__inner">

        @include('frontend.admin.partials.toolbar')

        <header class="pp-admin__hero">
            <div>
                <p class="pp-admin__eyebrow">Admin</p>
                <h1>Customers</h1>
                <p class="pp-admin__lede">Search accounts, edit roles, or remove users. Deleting a user cannot be undone.</p>
            </div>
            <div class="pp-admin__hero-actions">
                <a href="{{ route('home') }}" class="pp-admin__btn pp-admin__btn--ghost">← Storefront</a>
            </div>
        </header>

        @if (session('success'))
            <div class="pp-admin__alert pp-admin__alert--success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="pp-admin__alert pp-admin__alert--danger">
                <strong>Something went wrong:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="GET" action="{{ route('admin.customers.index') }}" class="pp-admin__filters">
            <input
                type="text"
                name="q"
                value="{{ $q }}"
                placeholder="Name, email, or ID…"
                class="pp-admin__input pp-admin__input--grow"
            >
            <button type="submit" class="pp-admin__btn pp-admin__btn--primary">Search</button>
            @if (! empty($q))
                <a href="{{ route('admin.customers.index') }}" class="pp-admin__btn pp-admin__btn--ghost">Clear</a>
            @endif
        </form>

        <div class="pp-admin__panel" style="padding:0; overflow:hidden;">
            <div class="pp-admin__table-wrap" style="margin:0;">
                <table class="pp-admin__table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Force reset</th>
                            <th>Joined</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $c)
                            <tr>
                                <td>{{ $c->id }}</td>
                                <td><strong>{{ $c->name }}</strong></td>
                                <td>{{ $c->email }}</td>
                                <td>
                                    @if ($c->is_admin)
                                        <span class="pp-admin__badge pp-admin__badge--processing">Admin</span>
                                    @else
                                        <span class="pp-admin__badge">Customer</span>
                                    @endif
                                </td>
                                <td>
                                    @if (isset($c->force_password_reset) && $c->force_password_reset)
                                        <span class="pp-admin__badge pp-admin__badge--pending">Yes</span>
                                    @else
                                        <span class="pp-admin__badge">No</span>
                                    @endif
                                </td>
                                <td>{{ optional($c->created_at)->format('d M Y') }}</td>
                                <td>
                                    <div class="pp-admin__table-actions">
                                        <a href="{{ route('admin.customers.edit', $c->id) }}" class="pp-admin__btn pp-admin__btn--primary pp-admin__btn--sm">Edit</a>
                                        <form
                                            method="POST"
                                            action="{{ route('admin.customers.destroy', $c->id) }}"
                                            style="display:inline;"
                                            onsubmit="return confirm('Delete this user? This cannot be undone.');"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="pp-admin__btn pp-admin__btn--danger pp-admin__btn--sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="pp-admin__lede" style="padding:1.25rem;">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pp-admin__pagination" style="padding:0 1rem 1rem;">
                {{ $customers->links('vendor.pagination.preppal') }}
            </div>
        </div>

    </div>
</div>
@endsection
