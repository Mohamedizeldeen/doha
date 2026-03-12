<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use App\Models\User;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index(Salon $salon)
    {
        $this->authorize('update', $salon);

        $accounts = User::where('salon_id', $salon->id)
            ->whereIn('role', ['employee', 'cashier'])
            ->with('staffMember')
            ->orderByDesc('created_at')
            ->get();

        return view('accounts.index', compact('salon', 'accounts'));
    }

    public function create(Salon $salon)
    {
        $this->authorize('update', $salon);

        $staffMembers = $salon->staff()->get();
        return view('accounts.create', compact('salon', 'staffMembers'));
    }

    public function store(Request $request, Salon $salon)
    {
        $this->authorize('update', $salon);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:employee,cashier',
            'staff_id' => 'nullable|exists:staff,id',
            'password' => 'nullable|string|min:6',
        ]);

        // If employee role, staff_id is required
        if ($validated['role'] === 'employee' && empty($validated['staff_id'])) {
            return back()->withErrors(['staff_id' => __('admin.staff_required_for_employee')])->withInput();
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'role' => $validated['role'],
            'salon_id' => $salon->id,
            'staff_id' => $validated['role'] === 'employee' ? $validated['staff_id'] : null,
            'password' => Hash::make($validated['password'] ?? '12345678'),
            'is_active' => true,
        ]);

        return redirect()->route('account.index', $salon)
            ->with('success', __('admin.account_created'));
    }

    public function edit(Salon $salon, User $account)
    {
        $this->authorize('update', $salon);
        if ($account->salon_id !== $salon->id) abort(403);

        $staffMembers = $salon->staff()->get();
        return view('accounts.edit', compact('salon', 'account', 'staffMembers'));
    }

    public function update(Request $request, Salon $salon, User $account)
    {
        $this->authorize('update', $salon);
        if ($account->salon_id !== $salon->id) abort(403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $account->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:employee,cashier',
            'staff_id' => 'nullable|exists:staff,id',
        ]);

        $account->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'role' => $validated['role'],
            'staff_id' => $validated['role'] === 'employee' ? $validated['staff_id'] : null,
        ]);

        return redirect()->route('account.index', $salon)
            ->with('success', __('admin.account_updated'));
    }

    public function toggleStatus(Salon $salon, User $account)
    {
        $this->authorize('update', $salon);
        if ($account->salon_id !== $salon->id) abort(403);

        $account->update(['is_active' => !$account->is_active]);

        $message = $account->is_active ? __('admin.account_activated') : __('admin.account_blocked');
        return redirect()->route('account.index', $salon)->with('success', $message);
    }

    public function resetPassword(Request $request, Salon $salon, User $account)
    {
        $this->authorize('update', $salon);
        if ($account->salon_id !== $salon->id) abort(403);

        $validated = $request->validate([
            'new_password' => 'required|string|min:6',
        ]);

        $account->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return redirect()->route('account.index', $salon)
            ->with('success', __('admin.password_changed'));
    }

    public function destroy(Salon $salon, User $account)
    {
        $this->authorize('update', $salon);
        if ($account->salon_id !== $salon->id) abort(403);

        $account->delete();

        return redirect()->route('account.index', $salon)
            ->with('success', __('admin.account_deleted'));
    }
}
