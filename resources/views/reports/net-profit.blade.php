@extends('admin.layout.app')

@section('page-title', __('admin.net_profit_report'))

@section('content')
<div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
    <div>
        <h2 style="font-size: 1.15rem; font-weight: 700; color: #1f2937;">{{ __('admin.net_profit_report') }}</h2>
        <p style="font-size: 0.8rem; color: #6b7280;">{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->translatedFormat('F Y') }}</p>
    </div>
    <form method="GET" action="{{ route('reports.net-profit', $salon) }}" style="display: flex; gap: 0.5rem; align-items: center;">
        <input type="month" name="month" value="{{ $month }}" style="padding: 0.4rem 0.6rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.8rem;">
        <button type="submit" style="padding: 0.4rem 0.8rem; background: var(--primary); color: #fff; border: none; border-radius: 0.5rem; font-size: 0.8rem; cursor: pointer;">
            <i class="fas fa-filter"></i>
        </button>
    </form>
</div>

<!-- Key Metrics -->
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
    <div style="background: linear-gradient(135deg, #059669, #34d399); border-radius: 1rem; padding: 1.25rem; color: #fff;">
        <div style="font-size: 0.7rem; opacity: 0.85;"><i class="fas fa-arrow-up"></i> {{ __('admin.total_revenue') }}</div>
        <div style="font-size: 1.5rem; font-weight: 800; margin-top: 0.25rem;">{{ number_format($totalRevenue, 2) }} {{ $currency }}</div>
    </div>
    <div style="background: linear-gradient(135deg, #dc2626, #f87171); border-radius: 1rem; padding: 1.25rem; color: #fff;">
        <div style="font-size: 0.7rem; opacity: 0.85;"><i class="fas fa-arrow-down"></i> {{ __('admin.total_expenses') }}</div>
        <div style="font-size: 1.5rem; font-weight: 800; margin-top: 0.25rem;">{{ number_format($totalExpenses, 2) }} {{ $currency }}</div>
    </div>
    <div style="background: linear-gradient(135deg, #7c3aed, #a78bfa); border-radius: 1rem; padding: 1.25rem; color: #fff;">
        <div style="font-size: 0.7rem; opacity: 0.85;"><i class="fas fa-users"></i> {{ __('admin.total_salaries') }}</div>
        <div style="font-size: 1.5rem; font-weight: 800; margin-top: 0.25rem;">{{ number_format($totalSalaries, 2) }} {{ $currency }}</div>
    </div>
    <div style="background: linear-gradient(135deg, {{ $netProfit >= 0 ? '#0ea5e9, #38bdf8' : '#ef4444, #f87171' }}); border-radius: 1rem; padding: 1.25rem; color: #fff;">
        <div style="font-size: 0.7rem; opacity: 0.85;"><i class="fas fa-chart-line"></i> {{ __('admin.net_profit') }}</div>
        <div style="font-size: 1.5rem; font-weight: 800; margin-top: 0.25rem;">{{ number_format($netProfit, 2) }} {{ $currency }}</div>
        <div style="font-size: 0.7rem; opacity: 0.85; margin-top: 0.25rem;">{{ __('admin.profit_margin') }}: {{ $profitMargin }}%</div>
    </div>
</div>

<!-- Breakdown -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
    <!-- Profit Calculation -->
    <div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; padding: 1.25rem;">
        <h3 style="font-size: 0.9rem; font-weight: 700; color: #1f2937; margin-bottom: 1rem;">{{ __('admin.profit_breakdown') }}</h3>
        <div style="display: flex; flex-direction: column; gap: 0.6rem;">
            <div style="display: flex; justify-content: space-between; padding-bottom: 0.5rem; border-bottom: 1px solid #f3f4f6;">
                <span style="font-size: 0.8rem; color: #059669; font-weight: 600;">{{ __('admin.total_revenue') }}</span>
                <span style="font-size: 0.85rem; font-weight: 700; color: #059669;">+{{ number_format($totalRevenue, 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding-bottom: 0.5rem; border-bottom: 1px solid #f3f4f6;">
                <span style="font-size: 0.8rem; color: #dc2626;">{{ __('admin.total_expenses') }}</span>
                <span style="font-size: 0.85rem; font-weight: 700; color: #dc2626;">-{{ number_format($totalExpenses, 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding-bottom: 0.5rem; border-bottom: 1px solid #f3f4f6;">
                <span style="font-size: 0.8rem; color: #7c3aed;">{{ __('admin.total_salaries') }}</span>
                <span style="font-size: 0.85rem; font-weight: 700; color: #7c3aed;">-{{ number_format($totalSalaries, 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding-top: 0.5rem; border-top: 2px solid #374151;">
                <span style="font-size: 0.9rem; font-weight: 800; color: #1f2937;">{{ __('admin.net_profit') }}</span>
                <span style="font-size: 1rem; font-weight: 800; color: {{ $netProfit >= 0 ? '#059669' : '#dc2626' }};">{{ number_format($netProfit, 2) }} {{ $currency }}</span>
            </div>
        </div>
    </div>

    <!-- Expenses by Category -->
    <div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; padding: 1.25rem;">
        <h3 style="font-size: 0.9rem; font-weight: 700; color: #1f2937; margin-bottom: 1rem;">{{ __('admin.expenses_by_category') }}</h3>
        @php $categories = \App\Models\Expense::categories(); @endphp
        @forelse($expensesByCategory as $cat => $amount)
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0; border-bottom: 1px solid #f3f4f6;">
            <span style="font-size: 0.8rem; color: #374151;">{{ $categories[$cat][app()->getLocale()] ?? $cat }}</span>
            <span style="font-size: 0.8rem; font-weight: 600; color: #dc2626;">{{ number_format($amount, 2) }} {{ $currency }}</span>
        </div>
        @empty
        <p style="text-align: center; color: #9ca3af; font-size: 0.8rem; padding: 1rem;">{{ __('admin.no_data') }}</p>
        @endforelse
    </div>
</div>

<!-- Monthly Trend -->
<div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; padding: 1.25rem;">
    <h3 style="font-size: 0.9rem; font-weight: 700; color: #1f2937; margin-bottom: 1rem;">{{ __('admin.monthly_trend') }} ({{ __('admin.last_6_months') }})</h3>
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                <th style="padding: 0.6rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.month') }}</th>
                <th style="padding: 0.6rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: center;">{{ __('admin.revenue') }}</th>
                <th style="padding: 0.6rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: center;">{{ __('admin.expenses') }}</th>
                <th style="padding: 0.6rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: center;">{{ __('admin.net_profit') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($monthlyTrend as $m)
            <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 0.6rem; font-size: 0.8rem; color: #374151; font-weight: 600;">{{ $m->label }}</td>
                <td style="padding: 0.6rem; text-align: center; font-size: 0.8rem; color: #059669; font-weight: 600;">{{ number_format($m->revenue, 2) }}</td>
                <td style="padding: 0.6rem; text-align: center; font-size: 0.8rem; color: #dc2626;">{{ number_format($m->expenses, 2) }}</td>
                <td style="padding: 0.6rem; text-align: center; font-size: 0.85rem; font-weight: 700; color: {{ $m->profit >= 0 ? '#059669' : '#dc2626' }};">{{ number_format($m->profit, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Simple Bar Chart -->
    @php $maxVal = $monthlyTrend->max('revenue') ?: 1; @endphp
    <div style="display: flex; align-items: flex-end; gap: 0.75rem; margin-top: 1.5rem; height: 150px; padding: 0 0.5rem;">
        @foreach($monthlyTrend as $m)
        <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 0.25rem;">
            <div style="display: flex; gap: 2px; align-items: flex-end; width: 100%; height: 120px;">
                <div style="flex: 1; background: #059669; border-radius: 3px 3px 0 0; height: {{ $maxVal > 0 ? ($m->revenue / $maxVal * 100) : 0 }}%;" title="{{ __('admin.revenue') }}: {{ number_format($m->revenue, 2) }}"></div>
                <div style="flex: 1; background: #dc2626; border-radius: 3px 3px 0 0; height: {{ $maxVal > 0 ? ($m->expenses / $maxVal * 100) : 0 }}%;" title="{{ __('admin.expenses') }}: {{ number_format($m->expenses, 2) }}"></div>
            </div>
            <div style="font-size: 0.6rem; color: #9ca3af; text-align: center;">{{ \Carbon\Carbon::createFromFormat('Y-m', $m->month)->format('M') }}</div>
        </div>
        @endforeach
    </div>
    <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 0.75rem;">
        <div style="display: flex; align-items: center; gap: 0.3rem;"><span style="width: 10px; height: 10px; background: #059669; border-radius: 2px;"></span><span style="font-size: 0.65rem; color: #6b7280;">{{ __('admin.revenue') }}</span></div>
        <div style="display: flex; align-items: center; gap: 0.3rem;"><span style="width: 10px; height: 10px; background: #dc2626; border-radius: 2px;"></span><span style="font-size: 0.65rem; color: #6b7280;">{{ __('admin.expenses') }}</span></div>
    </div>
</div>
@endsection
