@extends('admin.layout.app')

@section('page-title', __('admin.add_coupon'))

@section('content')
<div style="margin-bottom: 1.5rem;">
    <h2 style="font-size: 1.15rem; font-weight: 700; color: #1f2937;">{{ __('admin.add_coupon') }}</h2>
</div>

<form action="{{ route('coupon.store', $salon) }}" method="POST">
    @csrf
    <div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; padding: 1.25rem; max-width: 500px;">
        <div style="display: grid; gap: 1rem;">
            <div>
                <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.code') }}</label>
                <input type="text" name="code" value="{{ old('code') }}" placeholder="{{ __('admin.auto_generate') }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.85rem; font-family: monospace; text-transform: uppercase;">
                <span style="font-size: 0.65rem; color: #9ca3af;">{{ __('admin.leave_empty_auto') }}</span>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                <div>
                    <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.type') }} *</label>
                    <select name="type" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.85rem;">
                        <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>{{ __('admin.percentage') }}</option>
                        <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>{{ __('admin.fixed_amount') }}</option>
                    </select>
                </div>
                <div>
                    <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.value') }} *</label>
                    <input type="number" name="value" step="0.01" value="{{ old('value') }}" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.85rem;">
                    @error('value') <span style="color: #ef4444; font-size: 0.7rem;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                <div>
                    <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.min_order') }}</label>
                    <input type="number" name="min_order_amount" step="0.01" value="{{ old('min_order_amount') }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.85rem;">
                </div>
                <div>
                    <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.max_uses') }}</label>
                    <input type="number" name="max_uses" value="{{ old('max_uses') }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.85rem;">
                    <span style="font-size: 0.65rem; color: #9ca3af;">{{ __('admin.leave_empty_unlimited') }}</span>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                <div>
                    <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.valid_from') }}</label>
                    <input type="date" name="valid_from" value="{{ old('valid_from', date('Y-m-d')) }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.85rem;">
                </div>
                <div>
                    <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.valid_until') }}</label>
                    <input type="date" name="valid_until" value="{{ old('valid_until') }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.85rem;">
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="accent-color: var(--primary);">
                <label style="font-size: 0.85rem; color: #374151;">{{ __('admin.active') }}</label>
            </div>
        </div>

        <div style="margin-top: 1.5rem; display: flex; gap: 0.75rem;">
            <button type="submit" style="padding: 0.6rem 1.5rem; background: var(--primary); color: #fff; border: none; border-radius: 0.5rem; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                <i class="fas fa-save"></i> {{ __('admin.save') }}
            </button>
            <a href="{{ route('coupon.index', $salon) }}" style="padding: 0.6rem 1.5rem; border: 1px solid #d1d5db; border-radius: 0.5rem; text-decoration: none; font-size: 0.85rem; color: #6b7280;">
                {{ __('admin.cancel') }}
            </a>
        </div>
    </div>
</form>
@endsection
