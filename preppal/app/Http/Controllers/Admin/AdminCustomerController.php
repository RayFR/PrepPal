<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminCustomerController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));

        $customers = User::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('name', 'like', "%{$q}%")
                       ->orWhere('email', 'like', "%{$q}%")
                       ->orWhere('id', $q);
                });
            })
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('frontend.admin.customers.index', compact('customers', 'q'));
    }

    public function edit(User $user)
    {
        return view('frontend.admin.customers.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'is_admin' => ['nullable', 'boolean'],
            'force_password_reset' => ['nullable', 'boolean'],
        ]);

        // checkbox values
        $data['is_admin'] = (bool)($request->input('is_admin', false));
        $data['force_password_reset'] = (bool)($request->input('force_password_reset', false));

        $user->update($data);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy(User $user)
    {
        // prevent deleting yourself
        if ($user->id === auth()->id()) {
            return back()->withErrors(['delete' => 'You cannot delete your own account.']);
        }

        $user->delete();

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}
