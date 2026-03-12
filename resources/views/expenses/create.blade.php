@extends('admin.layout.app')

@section('page-title', __('admin.add_expense'))

@section('content')
<div style="margin-bottom: 1.5rem;">
    <h2 style="font-size: 1.15rem; font-weight: 700; color: #1f2937;">{{ __('admin.add_expense') }}</h2>
</div>

<form action="{{ route('expense.store', $salon) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; padding: 1.25rem; max-width: 500px;">
        <div style="display: grid; gap: 1rem;">
            <div>
                <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.category') }} *</label>
                <select name="category" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.85rem;">
                    @php $categories = \App\Models\Expense::categories(); @endphp
                    @foreach($categories as $key => $cat)
                    <option value="{{ $key }}" {{ old('category') === $key ? 'selected' : '' }}>
                        {{ $cat[app()->getLocale() === 'ar' ? 'ar' : 'en'] }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.description') }} *</label>
                <textarea name="description" rows="2" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.85rem; resize: vertical;">{{ old('description') }}</textarea>
                @error('description') <span style="color: #ef4444; font-size: 0.7rem;">{{ $message }}</span> @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                <div>
                    <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.amount') }} *</label>
                    <input type="number" name="amount" step="0.01" value="{{ old('amount') }}" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.85rem;">
                    @error('amount') <span style="color: #ef4444; font-size: 0.7rem;">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.date') }} *</label>
                    <input type="date" name="expense_date" value="{{ old('expense_date', date('Y-m-d')) }}" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.85rem;">
                </div>
            </div>

            <div>
                <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.supplier') }}</label>
                <input type="text" name="supplier_name" value="{{ old('supplier_name') }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.85rem;">
            </div>

            <div>
                <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.receipt_image') }}</label>
                <input type="file" name="receipt_image" accept="image/*" style="width: 100%; padding: 0.4rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.8rem;">
            </div>
        </div>

        <div style="margin-top: 1.5rem; display: flex; gap: 0.75rem;">
            <button type="submit" style="padding: 0.6rem 1.5rem; background: var(--primary); color: #fff; border: none; border-radius: 0.5rem; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                <i class="fas fa-save"></i> {{ __('admin.save') }}
            </button>
            <a href="{{ route('expense.index', $salon) }}" style="padding: 0.6rem 1.5rem; border: 1px solid #d1d5db; border-radius: 0.5rem; text-decoration: none; font-size: 0.85rem; color: #6b7280;">
                {{ __('admin.cancel') }}
            </a>
        </div>
    </div>
</form>
@endsection
