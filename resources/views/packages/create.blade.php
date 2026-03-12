@extends('admin.layout.app')

@section('page-title', __('admin.add_package'))

@section('content')
<div style="margin-bottom: 1.5rem;">
    <h2 style="font-size: 1.15rem; font-weight: 700; color: #1f2937;">{{ __('admin.add_package') }}</h2>
</div>

<form action="{{ route('package.store', $salon) }}" method="POST">
    @csrf
    <div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; padding: 1.25rem; max-width: 600px;">
        <div style="display: grid; gap: 1rem;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                <div>
                    <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.name_ar') }} *</label>
                    <input type="text" name="name_ar" value="{{ old('name_ar') }}" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.85rem;">
                    @error('name_ar') <span style="color: #ef4444; font-size: 0.7rem;">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.name_en') }} *</label>
                    <input type="text" name="name_en" value="{{ old('name_en') }}" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.85rem;">
                    @error('name_en') <span style="color: #ef4444; font-size: 0.7rem;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                <div>
                    <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.description') }} (AR)</label>
                    <textarea name="description_ar" rows="2" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.85rem; resize: vertical;">{{ old('description_ar') }}</textarea>
                </div>
                <div>
                    <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.description') }} (EN)</label>
                    <textarea name="description_en" rows="2" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.85rem; resize: vertical;">{{ old('description_en') }}</textarea>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                <div>
                    <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.original_price') }} *</label>
                    <input type="number" name="original_price" step="0.01" value="{{ old('original_price') }}" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.85rem;">
                </div>
                <div>
                    <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.price') }} *</label>
                    <input type="number" name="package_price" step="0.01" value="{{ old('package_price') }}" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.85rem;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                <div>
                    <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.valid_from') }}</label>
                    <input type="date" name="valid_from" value="{{ old('valid_from') }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.85rem;">
                </div>
                <div>
                    <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.valid_until') }}</label>
                    <input type="date" name="valid_until" value="{{ old('valid_until') }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.85rem;">
                </div>
            </div>

            <!-- Services Multi-Select -->
            <div>
                <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.services') }} *</label>
                <div style="max-height: 200px; overflow-y: auto; border: 1px solid #d1d5db; border-radius: 0.375rem; padding: 0.5rem;">
                    @foreach($services as $service)
                    <label style="display: flex; align-items: center; gap: 0.5rem; padding: 0.35rem 0; cursor: pointer; border-bottom: 1px solid #f3f4f6;">
                        <input type="checkbox" name="services[]" value="{{ $service->id }}" {{ in_array($service->id, old('services', [])) ? 'checked' : '' }} style="accent-color: var(--primary);">
                        <span style="font-size: 0.8rem; flex: 1;">{{ app()->getLocale() === 'ar' ? $service->name_ar : $service->name_en }}</span>
                        <span style="font-size: 0.7rem; color: #9ca3af;">{{ number_format($service->price, 2) }}</span>
                    </label>
                    @endforeach
                </div>
                @error('services') <span style="color: #ef4444; font-size: 0.7rem;">{{ $message }}</span> @enderror
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
            <a href="{{ route('package.index', $salon) }}" style="padding: 0.6rem 1.5rem; border: 1px solid #d1d5db; border-radius: 0.5rem; text-decoration: none; font-size: 0.85rem; color: #6b7280;">
                {{ __('admin.cancel') }}
            </a>
        </div>
    </div>
</form>
@endsection
