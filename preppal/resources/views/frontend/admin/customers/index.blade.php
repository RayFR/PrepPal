@extends('layouts.app')

@section('title', 'Admin - Customers')

@section('content')
<div class="container" style="max-width: 1100px;">

    <div style="display:flex; justify-content:space-between; align-items:flex-end; gap: 1rem; flex-wrap: wrap;">
        <div>
            <h1 style="margin-bottom: 0.25rem;">Customers</h1>
            <p style="margin-top: 0; opacity: 0.8;">Search, view, edit or delete customer accounts.</p>
        </div>
        <a href="{{ route('home') }}" style="text-decoration:none;">← Back to site</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="margin: 1rem 0;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger" style="margin: 1rem 0;">
            <strong>There was a problem:</strong>
            <ul style="margin: 0.5rem 0 0 1.25rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="GET" action="{{ route('admin.customers.index') }}" style="display:flex; gap: 0.5rem; margin: 1rem 0;">
        <input
            type="text"
            name="q"
            value="{{ $q }}"
            placeholder="Search by name, email or ID..."
            style="flex:1; padding:0.65rem; border-radius:10px;"
        >
        <button type="submit" class="cart-btn" style="padding:0.65rem 1rem; border-radius:10px;">
            Search
        </button>
        @if(!empty($q))
            <a href="{{ route('admin.customers.index') }}" class="cart-btn" style="padding:0.65rem 1rem; border-radius:10px; text-decoration:none;">
                Clear
            </a>
        @endif
    </form>

    <div class="card" style="padding: 1rem; border-radius: 12px;">
        <div style="overflow:auto;">
            <table style="width:100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align:left; opacity:0.9;">
                        <th style="padding:0.6rem;">ID</th>
                        <th style="padding:0.6rem;">Name</th>
                        <th style="padding:0.6rem;">Email</th>
                        <th style="padding:0.6rem;">Role</th>
                        <th style="padding:0.6rem;">Force reset</th>
                        <th style="padding:0.6rem;">Joined</th>
                        <th style="padding:0.6rem;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $c)
                        <tr style="border-top:1px solid rgba(0,0,0,0.12);">
                            <td style="padding:0.6rem;">{{ $c->id }}</td>
                            <td style="padding:0.6rem;">{{ $c->name }}</td>
                            <td style="padding:0.6rem;">{{ $c->email }}</td>
                            <td style="padding:0.6rem;">
                                @if($c->is_admin)
                                    <span style="font-weight:700;">Admin</span>
                                @else
                                    Customer
                                @endif
                            </td>
                            <td style="padding:0.6rem;">
                                @if(isset($c->force_password_reset) && $c->force_password_reset)
                                    <span style="font-weight:700;">Yes</span>
                                @else
                                    No
                                @endif
                            </td>
                            <td style="padding:0.6rem;">
                                {{ optional($c->created_at)->format('d M Y') }}
                            </td>
                            <td style="padding:0.6rem; white-space:nowrap;">
                                <a href="{{ route('admin.customers.edit', $c->id) }}">Edit</a>

                                <span style="opacity:0.35;"> | </span>

                                <form method="POST"
                                      action="{{ route('admin.customers.destroy', $c->id) }}"
                                      style="display:inline;"
                                      onsubmit="return confirm('Delete this user? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            style="background:none; border:none; padding:0; color:#c00; cursor:pointer;">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding:0.9rem; opacity:0.8;">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 1rem;">
            {{ $customers->links() }}
        </div>
    </div>

</div>
@endsection