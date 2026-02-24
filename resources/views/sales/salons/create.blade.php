@extends('sales.layout.app')

@section('page-title', __('admin.create_salon'))

@section('content')
<style>
    .form-card { background: #fff; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.75rem; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
    .form-group { margin-bottom: 0; }
    .form-group.full { grid-column: 1 / -1; }
    .form-label { display: block; font-size: 0.8rem; font-weight: 600; color: #334155; margin-bottom: 0.4rem; }
    .form-input, .form-select, .form-textarea { width: 100%; padding: 0.65rem 0.85rem; border: 1.5px solid #e2e8f0; border-radius: 0.625rem; font-size: 0.85rem; color: #1a1a2e; background: #fff; transition: border-color .2s, box-shadow .2s; }
    .form-input:focus, .form-select:focus, .form-textarea:focus { outline: none; border-color: #dd208e; box-shadow: 0 0 0 3px rgba(221,32,142,0.1); }
    .form-textarea { min-height: 100px; resize: vertical; }
    .form-error { color: #ef4444; font-size: 0.75rem; margin-top: 0.3rem; }
    .section-title { font-size: 0.9rem; font-weight: 700; color: #1a1a2e; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid #f1f5f9; display: flex; align-items: center; gap: 0.5rem; }
    .section-title i { color: #dd208e; }
    .form-footer { display: flex; justify-content: flex-end; gap: 0.75rem; margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid #f1f5f9; }
    .btn { padding: 0.65rem 1.5rem; border-radius: 0.625rem; font-size: 0.85rem; font-weight: 600; cursor: pointer; border: none; transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; }
    .btn-primary { background: linear-gradient(135deg, #dd208e, #b01670); color: #fff; }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 15px rgba(221,32,142,0.3); }
    .btn-secondary { background: #f1f5f9; color: #475569; }
    .btn-secondary:hover { background: #e2e8f0; }
    @media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; } }
</style>

<div style="margin-bottom: 1rem;">
    <a href="{{ route('sales.salons.index') }}" style="color: #64748b; text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.4rem;">
        <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i>
        {{ __('admin.back') }}
    </a>
</div>

<form action="{{ route('sales.salons.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- Salon Info --}}
    <div class="form-card" style="margin-bottom: 1.25rem;">
        <div class="section-title"><i class="fas fa-store"></i> {{ __('admin.salon_info') }}</div>
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">{{ __('admin.name_ar') }} *</label>
                <input type="text" name="name_ar" class="form-input" value="{{ old('name_ar') }}" required dir="rtl">
                @error('name_ar') <div class="form-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('admin.name_en') }}</label>
                <input type="text" name="name_en" class="form-input" value="{{ old('name_en') }}" dir="ltr">
                @error('name_en') <div class="form-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group full">
                <label class="form-label">{{ __('admin.logo') }}</label>
                <input type="file" name="logo" class="form-input" accept="image/*">
                @error('logo') <div class="form-error">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>

    {{-- Owner Info --}}
    <div class="form-card" style="margin-bottom: 1.25rem;">
        <div class="section-title"><i class="fas fa-user"></i> {{ __('admin.salon_owner') }}</div>
        <p style="font-size: 0.8rem; color: #64748b; margin-bottom: 1rem;">
            {{ app()->getLocale() === 'ar' ? 'سيتم إنشاء حساب تلقائياً لمالك الصالون' : 'An account will be automatically created for the salon owner' }}
        </p>
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">{{ __('admin.name') }} *</label>
                <input type="text" name="owner_name" class="form-input" value="{{ old('owner_name') }}" required>
                @error('owner_name') <div class="form-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('admin.email') }} *</label>
                <input type="email" name="email" class="form-input" value="{{ old('email') }}" required dir="ltr">
                @error('email') <div class="form-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('admin.password') }} *</label>
                <input type="password" name="password" class="form-input" required dir="ltr">
                @error('password') <div class="form-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('admin.phone') }}</label>
                <input type="text" name="owner_phone" class="form-input" value="{{ old('owner_phone') }}" dir="ltr">
                @error('owner_phone') <div class="form-error">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>

    {{-- Salon Details --}}
    <div class="form-card" style="margin-bottom: 1.25rem;">
        <div class="section-title"><i class="fas fa-info-circle"></i> {{ __('admin.salon_info') }}</div>
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">{{ __('admin.phone') }}</label>
                <input type="text" name="phone" class="form-input" value="{{ old('phone') }}" dir="ltr">
                @error('phone') <div class="form-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('admin.email') }}</label>
                <input type="email" name="salon_email" class="form-input" value="{{ old('salon_email') }}" dir="ltr">
                @error('salon_email') <div class="form-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('admin.address_ar') }}</label>
                <input type="text" name="address_ar" class="form-input" value="{{ old('address_ar') }}" dir="rtl">
                @error('address_ar') <div class="form-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('admin.address_en') }}</label>
                <input type="text" name="address_en" class="form-input" value="{{ old('address_en') }}" dir="ltr">
                @error('address_en') <div class="form-error">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>

    {{-- Subscription --}}
    <div class="form-card" style="margin-bottom: 1.25rem;">
        <div class="section-title"><i class="fas fa-credit-card"></i> {{ __('admin.subscription') }}</div>
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">{{ __('admin.subscription_type') }} *</label>
                <select name="subscription_type" class="form-select" required>
                    <option value="trial" {{ old('subscription_type') === 'trial' ? 'selected' : '' }}>{{ __('admin.trial') }}</option>
                    <option value="monthly" {{ old('subscription_type') === 'monthly' ? 'selected' : '' }}>{{ __('admin.monthly') }}</option>
                    <option value="yearly" {{ old('subscription_type') === 'yearly' ? 'selected' : '' }}>{{ __('admin.yearly') }}</option>
                </select>
                @error('subscription_type') <div class="form-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('admin.subscription_start') }}</label>
                <input type="date" name="subscription_start" class="form-input" value="{{ old('subscription_start', date('Y-m-d')) }}" dir="ltr">
                @error('subscription_start') <div class="form-error">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>

    <div class="form-footer">
        <a href="{{ route('sales.salons.index') }}" class="btn btn-secondary">{{ __('admin.cancel') }}</a>
        <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> {{ __('admin.create') }}</button>
    </div>
</form>
@endsection
