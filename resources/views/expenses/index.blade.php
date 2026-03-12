@extends('admin.layout.app')

@section('page-title', __('admin.expenses'))

@section('content')
<div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
    <div>
        <h2 style="font-size: 1.15rem; font-weight: 700; color: #1f2937;">{{ __('admin.expenses') }}</h2>
        <p style="font-size: 0.8rem; color: #6b7280;">{{ __('admin.monthly_total') }}: <span style="font-weight: 700; color: #ef4444;">{{ number_format($monthlyTotal, 2) }} {{ $salon->currency ?? 'OMR' }}</span></p>
    </div>
    <a href="{{ route('expense.create', $salon) }}" style="padding: 0.5rem 1rem; background: var(--primary); color: #fff; border-radius: 0.75rem; text-decoration: none; font-size: 0.8rem; font-weight: 600;">
        <i class="fas fa-plus"></i> {{ __('admin.add_expense') }}
    </a>
</div>

@if(session('success'))
<div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1rem; font-size: 0.85rem;">
    {{ session('success') }}
</div>
@endif

<!-- Category Summary -->
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 0.75rem; margin-bottom: 1.5rem;">
    @php
        $categoryTotals = $expenses->groupBy('category')->map(fn($items) => $items->sum('amount'));
        $categories = \App\Models\Expense::categories();
    @endphp
    @foreach($categoryTotals as $cat => $total)
    <div style="background: #fff; border-radius: 0.75rem; padding: 0.75rem; border: 1px solid #e5e7eb; text-align: center;">
        <div style="font-size: 0.65rem; color: #6b7280;">{{ $categories[$cat][app()->getLocale() === 'ar' ? 'ar' : 'en'] ?? $cat }}</div>
        <div style="font-size: 0.95rem; font-weight: 700; color: #1f2937;">{{ number_format($total, 2) }}</div>
    </div>
    @endforeach
</div>

<!-- Expenses Table -->
<div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.date') }}</th>
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.category') }}</th>
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.description') }}</th>
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.supplier') }}</th>
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.amount') }}</th>
                <th style="padding: 0.75rem;"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $expense)
            <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 0.75rem; font-size: 0.8rem; color: #374151;">{{ $expense->expense_date->format('d/m/Y') }}</td>
                <td style="padding: 0.75rem;">
                    <span style="font-size: 0.7rem; padding: 0.15rem 0.4rem; background: #f3f4f6; border-radius: 0.25rem; color: #374151;">
                        {{ $categories[$expense->category][app()->getLocale() === 'ar' ? 'ar' : 'en'] ?? $expense->category }}
                    </span>
                </td>
                <td style="padding: 0.75rem; font-size: 0.8rem; color: #374151;">{{ Str::limit($expense->description, 40) }}</td>
                <td style="padding: 0.75rem; font-size: 0.8rem; color: #6b7280;">{{ $expense->supplier_name ?? '-' }}</td>
                <td style="padding: 0.75rem; font-size: 0.85rem; font-weight: 700; color: #ef4444;">{{ number_format($expense->amount, 2) }}</td>
                <td style="padding: 0.75rem;">
                    <div style="display: flex; gap: 0.25rem;">
                        @if($expense->receipt_image)
                        <a href="{{ asset('storage/' . $expense->receipt_image) }}" target="_blank" style="padding: 0.25rem 0.5rem; color: #2563eb; font-size: 0.75rem;">
                            <i class="fas fa-file-image"></i>
                        </a>
                        @endif
                        <form action="{{ route('expense.destroy', [$salon, $expense]) }}" method="POST" onsubmit="return confirm('{{ __('admin.confirm_delete') }}')">
                            @csrf @method('DELETE')
                            <button type="submit" style="padding: 0.25rem 0.5rem; color: #ef4444; background: none; border: none; cursor: pointer; font-size: 0.75rem;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding: 3rem; text-align: center; color: #9ca3af; font-size: 0.85rem;">
                    {{ __('admin.no_expenses') }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($expenses instanceof \Illuminate\Pagination\LengthAwarePaginator)
<div style="margin-top: 1rem;">{{ $expenses->links() }}</div>
@endif
@endsection
