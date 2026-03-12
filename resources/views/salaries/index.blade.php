@extends('admin.layout.app')

@section('page-title', __('admin.salaries'))

@section('content')
<div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
    <div>
        <h2 style="font-size: 1.15rem; font-weight: 700; color: #1f2937;">{{ __('admin.salaries') }}</h2>
        <p style="font-size: 0.8rem; color: #6b7280;">{{ __('admin.salary_for_month') }}: {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->translatedFormat('F Y') }}</p>
    </div>
    <form method="GET" action="{{ route('salary.index', $salon) }}" style="display: flex; gap: 0.5rem; align-items: center;">
        <input type="month" name="month" value="{{ $month }}" style="padding: 0.4rem 0.6rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.8rem;">
        <button type="submit" style="padding: 0.4rem 0.8rem; background: var(--primary); color: #fff; border: none; border-radius: 0.5rem; font-size: 0.8rem; cursor: pointer;">
            <i class="fas fa-filter"></i>
        </button>
    </form>
</div>

<!-- Summary Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
    <div style="background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 1rem; padding: 1.25rem; color: #fff;">
        <div style="font-size: 0.7rem; opacity: 0.8;">{{ __('admin.total_salaries') }}</div>
        <div style="font-size: 1.5rem; font-weight: 800; margin-top: 0.25rem;">{{ number_format($totalSalaries, 2) }} {{ $currency }}</div>
    </div>
    <div style="background: linear-gradient(135deg, #11998e, #38ef7d); border-radius: 1rem; padding: 1.25rem; color: #fff;">
        <div style="font-size: 0.7rem; opacity: 0.8;">{{ __('admin.total_paid_salaries') }}</div>
        <div style="font-size: 1.5rem; font-weight: 800; margin-top: 0.25rem;">{{ number_format($totalPaid, 2) }} {{ $currency }}</div>
    </div>
    <div style="background: linear-gradient(135deg, #f093fb, #f5576c); border-radius: 1rem; padding: 1.25rem; color: #fff;">
        <div style="font-size: 0.7rem; opacity: 0.8;">{{ __('admin.remaining_salaries') }}</div>
        <div style="font-size: 1.5rem; font-weight: 800; margin-top: 0.25rem;">{{ number_format($totalSalaries - $totalPaid, 2) }} {{ $currency }}</div>
    </div>
</div>

<!-- Staff Salary Table -->
<div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.staff_member') }}</th>
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: center;">{{ __('admin.base_salary') }}</th>
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: center;">{{ __('admin.revenue') }}</th>
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: center;">{{ __('admin.commission') }}</th>
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: center;">{{ __('admin.total') }}</th>
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: center;">{{ __('admin.status') }}</th>
                <th style="padding: 0.75rem;"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($staffSalaries as $item)
            <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 0.75rem;">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 0.7rem; font-weight: 700;">
                            {{ strtoupper(substr(app()->getLocale() === 'ar' ? $item->staff->name_ar : $item->staff->name_en, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-size: 0.85rem; font-weight: 600; color: #1f2937;">{{ app()->getLocale() === 'ar' ? $item->staff->name_ar : $item->staff->name_en }}</div>
                            <div style="font-size: 0.65rem; color: #9ca3af;">{{ $item->staff->commission_rate }}% {{ __('admin.commission') }}</div>
                        </div>
                    </div>
                </td>
                <td style="padding: 0.75rem; text-align: center; font-size: 0.85rem; color: #374151;">{{ number_format($item->base_salary, 2) }}</td>
                <td style="padding: 0.75rem; text-align: center; font-size: 0.85rem; color: #059669; font-weight: 600;">{{ number_format($item->month_revenue, 2) }}</td>
                <td style="padding: 0.75rem; text-align: center; font-size: 0.85rem; color: #7c3aed; font-weight: 600;">{{ number_format($item->commission, 2) }}</td>
                <td style="padding: 0.75rem; text-align: center; font-size: 0.95rem; font-weight: 800; color: #1f2937;">{{ number_format($item->total, 2) }}</td>
                <td style="padding: 0.75rem; text-align: center;">
                    @if($item->payment && $item->payment->status === 'paid')
                        <span style="background: #dcfce7; color: #166534; font-size: 0.65rem; padding: 0.2rem 0.5rem; border-radius: 9999px; font-weight: 600;">{{ __('admin.paid') }}</span>
                    @else
                        <span style="background: #fef9c3; color: #854d0e; font-size: 0.65rem; padding: 0.2rem 0.5rem; border-radius: 9999px; font-weight: 600;">{{ __('admin.pending') }}</span>
                    @endif
                </td>
                <td style="padding: 0.75rem;">
                    @if(!$item->payment || $item->payment->status !== 'paid')
                    <form action="{{ route('salary.store', $salon) }}" method="POST" style="display: inline;">
                        @csrf
                        <input type="hidden" name="staff_id" value="{{ $item->staff->id }}">
                        <input type="hidden" name="month" value="{{ $month }}">
                        <input type="hidden" name="base_salary" value="{{ $item->base_salary }}">
                        <input type="hidden" name="commission_amount" value="{{ $item->commission }}">
                        <input type="hidden" name="bonus" value="0">
                        <input type="hidden" name="deductions" value="0">
                        <button type="submit" onclick="return confirm('{{ __('admin.confirm_pay_salary') }}')" style="padding: 0.3rem 0.75rem; background: #059669; color: #fff; border: none; border-radius: 0.5rem; font-size: 0.7rem; font-weight: 600; cursor: pointer;">
                            <i class="fas fa-money-bill-wave"></i> {{ __('admin.pay') }}
                        </button>
                    </form>
                    @else
                        <span style="font-size: 0.65rem; color: #9ca3af;">{{ $item->payment->paid_date?->format('d/m') }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="padding: 3rem; text-align: center; color: #9ca3af;">{{ __('admin.no_data') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
