@extends('admin.layout.app')

@section('page-title', __('admin.edit_account'))

@section('content')
<div style="margin-bottom: 1.5rem;">
    <h2 style="font-size: 1.15rem; font-weight: 700; color: #1f2937;">{{ __('admin.edit_account') }}</h2>
</div>

<form action="{{ route('account.update', [$salon, $account]) }}" method="POST">
    @csrf @method('PUT')
    <div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; padding: 1.25rem; max-width: 500px;">
        <div style="display: grid; gap: 1rem;">
            <div>
                <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.name') }} *</label>
                <input type="text" name="name" value="{{ old('name', $account->name) }}" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.85rem;">
                @error('name') <span style="color: #ef4444; font-size: 0.7rem;">{{ $message }}</span> @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                <div>
                    <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.email') }} *</label>
                    <input type="email" name="email" value="{{ old('email', $account->email) }}" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.85rem;">
                    @error('email') <span style="color: #ef4444; font-size: 0.7rem;">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.phone') }}</label>
                    <input type="text" name="phone" value="{{ old('phone', $account->phone) }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.85rem;">
                </div>
            </div>

            <div>
                <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.role') }} *</label>
                <select name="role" id="roleSelect" onchange="toggleStaffField()" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.85rem;">
                    <option value="employee" {{ old('role', $account->role) === 'employee' ? 'selected' : '' }}>{{ __('admin.employee') }}</option>
                    <option value="cashier" {{ old('role', $account->role) === 'cashier' ? 'selected' : '' }}>{{ __('admin.cashier') }}</option>
                </select>
            </div>

            <div id="staffField">
                <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.linked_staff') }} *</label>
                <select name="staff_id" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.85rem;">
                    <option value="">{{ __('admin.select_staff') }}</option>
                    @foreach($staffMembers as $staff)
                    <option value="{{ $staff->id }}" {{ old('staff_id', $account->staff_id) == $staff->id ? 'selected' : '' }}>
                        {{ app()->getLocale() === 'ar' ? $staff->name_ar : $staff->name_en }} - {{ app()->getLocale() === 'ar' ? $staff->position_ar : $staff->position_en }}
                    </option>
                    @endforeach
                </select>
                @error('staff_id') <span style="color: #ef4444; font-size: 0.7rem;">{{ $message }}</span> @enderror
            </div>

            <!-- Status -->
            <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background: {{ $account->is_active ? '#f0fdf4' : '#fef2f2' }}; border-radius: 0.5rem;">
                <i class="fas {{ $account->is_active ? 'fa-check-circle' : 'fa-ban' }}" style="color: {{ $account->is_active ? '#059669' : '#ef4444' }}; font-size: 1.25rem;"></i>
                <div>
                    <div style="font-size: 0.85rem; font-weight: 600; color: {{ $account->is_active ? '#166534' : '#991b1b' }};">
                        {{ $account->is_active ? __('admin.active') : __('admin.blocked') }}
                    </div>
                    <div style="font-size: 0.7rem; color: #6b7280;">{{ __('admin.toggle_from_list') }}</div>
                </div>
            </div>
        </div>

        <div style="margin-top: 1.5rem; display: flex; gap: 0.75rem;">
            <button type="submit" style="padding: 0.6rem 1.5rem; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: #fff; border: none; border-radius: 0.5rem; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                <i class="fas fa-save"></i> {{ __('admin.save') }}
            </button>
            <a href="{{ route('account.index', $salon) }}" style="padding: 0.6rem 1.5rem; border: 1px solid #d1d5db; border-radius: 0.5rem; text-decoration: none; font-size: 0.85rem; color: #6b7280; display: inline-flex; align-items: center;">
                {{ __('admin.cancel') }}
            </a>
        </div>
    </div>
</form>

@push('scripts')
<script>
function toggleStaffField() {
    const role = document.getElementById('roleSelect').value;
    document.getElementById('staffField').style.display = role === 'employee' ? 'block' : 'none';
}
toggleStaffField();
</script>
@endpush
@endsection
