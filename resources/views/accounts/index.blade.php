@extends('admin.layout.app')

@section('page-title', __('admin.accounts'))

@section('content')
<div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
    <h2 style="font-size: 1.15rem; font-weight: 700; color: #1f2937;">{{ __('admin.accounts') }}</h2>
    <a href="{{ route('account.create', $salon) }}" style="padding: 0.5rem 1rem; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: #fff; border-radius: 0.75rem; text-decoration: none; font-size: 0.8rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
        <i class="fas fa-user-plus"></i> {{ __('admin.add_account') }}
    </a>
</div>

@if(session('success'))
<div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1rem; font-size: 0.85rem;">
    {{ session('success') }}
</div>
@endif

<!-- Stats -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
    <div style="background: #fff; border-radius: 1rem; padding: 1rem; border: 1px solid #e5e7eb;">
        <div style="font-size: 0.7rem; color: #6b7280;">{{ __('admin.total_accounts') }}</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary);">{{ $accounts->count() }}</div>
    </div>
    <div style="background: #fff; border-radius: 1rem; padding: 1rem; border: 1px solid #e5e7eb;">
        <div style="font-size: 0.7rem; color: #6b7280;">{{ __('admin.employees') }}</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: #2563eb;">{{ $accounts->where('role', 'employee')->count() }}</div>
    </div>
    <div style="background: #fff; border-radius: 1rem; padding: 1rem; border: 1px solid #e5e7eb;">
        <div style="font-size: 0.7rem; color: #6b7280;">{{ __('admin.cashiers') }}</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: #059669;">{{ $accounts->where('role', 'cashier')->count() }}</div>
    </div>
    <div style="background: #fff; border-radius: 1rem; padding: 1rem; border: 1px solid #e5e7eb;">
        <div style="font-size: 0.7rem; color: #6b7280;">{{ __('admin.blocked_accounts') }}</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: #ef4444;">{{ $accounts->where('is_active', false)->count() }}</div>
    </div>
</div>

<div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.name') }}</th>
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.email') }}</th>
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.role') }}</th>
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.linked_staff') }}</th>
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.status') }}</th>
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: center;">{{ __('admin.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($accounts as $account)
            <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 0.75rem;">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, {{ $account->role === 'employee' ? '#3b82f6, #2563eb' : '#059669, #047857' }}); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 0.7rem; font-weight: 700;">
                            {{ strtoupper(substr($account->name, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-size: 0.85rem; font-weight: 600; color: #1f2937;">{{ $account->name }}</div>
                            <div style="font-size: 0.7rem; color: #9ca3af;">{{ $account->phone ?? '-' }}</div>
                        </div>
                    </div>
                </td>
                <td style="padding: 0.75rem; font-size: 0.8rem; color: #374151;">{{ $account->email }}</td>
                <td style="padding: 0.75rem;">
                    <span style="font-size: 0.65rem; padding: 0.15rem 0.5rem; border-radius: 9999px; {{ $account->role === 'employee' ? 'background: #dbeafe; color: #1e40af;' : 'background: #dcfce7; color: #166534;' }}">
                        {{ $account->role === 'employee' ? __('admin.employee') : __('admin.cashier') }}
                    </span>
                </td>
                <td style="padding: 0.75rem; font-size: 0.8rem; color: #6b7280;">
                    @if($account->staffMember)
                        {{ app()->getLocale() === 'ar' ? $account->staffMember->name_ar : $account->staffMember->name_en }}
                    @else
                        -
                    @endif
                </td>
                <td style="padding: 0.75rem;">
                    @if($account->is_active)
                    <span style="font-size: 0.65rem; padding: 0.15rem 0.4rem; background: #dcfce7; color: #166534; border-radius: 9999px;">{{ __('admin.active') }}</span>
                    @else
                    <span style="font-size: 0.65rem; padding: 0.15rem 0.4rem; background: #fee2e2; color: #991b1b; border-radius: 9999px;">{{ __('admin.blocked') }}</span>
                    @endif
                </td>
                <td style="padding: 0.75rem; text-align: center;">
                    <div style="display: flex; align-items: center; justify-content: center; gap: 0.25rem; flex-wrap: wrap;">
                        <a href="{{ route('account.edit', [$salon, $account]) }}" style="color: #2563eb; font-size: 0.75rem; padding: 0.2rem 0.4rem;" title="{{ __('admin.edit') }}">
                            <i class="fas fa-edit"></i>
                        </a>

                        <!-- Toggle Block -->
                        <form action="{{ route('account.toggle-status', [$salon, $account]) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" style="background: none; border: none; cursor: pointer; font-size: 0.75rem; padding: 0.2rem 0.4rem; color: {{ $account->is_active ? '#ef4444' : '#059669' }};" title="{{ $account->is_active ? __('admin.block') : __('admin.unblock') }}">
                                <i class="fas {{ $account->is_active ? 'fa-ban' : 'fa-check-circle' }}"></i>
                            </button>
                        </form>

                        <!-- Reset Password -->
                        <button type="button" onclick="showPasswordModal({{ $account->id }})" style="background: none; border: none; cursor: pointer; font-size: 0.75rem; padding: 0.2rem 0.4rem; color: #d97706;" title="{{ __('admin.change_password') }}">
                            <i class="fas fa-key"></i>
                        </button>

                        <!-- Delete -->
                        <form action="{{ route('account.destroy', [$salon, $account]) }}" method="POST" onsubmit="return confirm('{{ __('admin.confirm_delete') }}')" style="display: inline;">
                            @csrf @method('DELETE')
                            <button type="submit" style="background: none; border: none; cursor: pointer; font-size: 0.75rem; padding: 0.2rem 0.4rem; color: #ef4444;" title="{{ __('admin.delete') }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding: 3rem; text-align: center; color: #9ca3af; font-size: 0.85rem;">
                    <i class="fas fa-users" style="font-size: 2rem; margin-bottom: 0.5rem; display: block;"></i>
                    {{ __('admin.no_accounts') }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Password Reset Modal -->
<div id="passwordModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 100; align-items: center; justify-content: center;">
    <div style="background: #fff; border-radius: 1rem; padding: 1.5rem; max-width: 400px; width: 90%;">
        <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 1rem;">{{ __('admin.change_password') }}</h3>
        <form id="passwordForm" method="POST">
            @csrf
            <div style="margin-bottom: 1rem;">
                <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.new_password') }}</label>
                <input type="text" name="new_password" value="12345678" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.85rem;">
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <button type="submit" style="padding: 0.5rem 1rem; background: var(--primary); color: #fff; border: none; border-radius: 0.5rem; font-size: 0.8rem; cursor: pointer;">{{ __('admin.save') }}</button>
                <button type="button" onclick="closePasswordModal()" style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.8rem; cursor: pointer; background: #fff;">{{ __('admin.cancel') }}</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function showPasswordModal(accountId) {
    const form = document.getElementById('passwordForm');
    form.action = `{{ url('salon/' . $salon->id . '/account') }}/${accountId}/reset-password`;
    document.getElementById('passwordModal').style.display = 'flex';
}
function closePasswordModal() {
    document.getElementById('passwordModal').style.display = 'none';
}
</script>
@endpush
@endsection
