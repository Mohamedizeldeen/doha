@extends('admin.layout.app')

@section('page-title', __('admin.revenue_comparison'))

@section('content')
<div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
    <div>
        <h2 style="font-size: 1.15rem; font-weight: 700; color: #1f2937;">{{ __('admin.revenue_comparison') }}</h2>
        <p style="font-size: 0.8rem; color: #6b7280;">{{ __('admin.last_n_months', ['n' => $months]) }}</p>
    </div>
    <form method="GET" action="{{ route('reports.revenue-comparison', $salon) }}" style="display: flex; gap: 0.5rem; align-items: center;">
        <select name="months" style="padding: 0.4rem 0.6rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.8rem;">
            @foreach([3, 6, 9, 12] as $opt)
            <option value="{{ $opt }}" {{ $months == $opt ? 'selected' : '' }}>{{ $opt }} {{ __('admin.months') }}</option>
            @endforeach
        </select>
        <button type="submit" style="padding: 0.4rem 0.8rem; background: var(--primary); color: #fff; border: none; border-radius: 0.5rem; font-size: 0.8rem; cursor: pointer;">
            <i class="fas fa-filter"></i>
        </button>
    </form>
</div>

<!-- Overview Cards -->
@php
    $totalRev = $comparison->sum('revenue');
    $totalExp = $comparison->sum('expenses');
    $totalBookings = $comparison->sum('bookings');
    $avgTicket = $comparison->where('avg_ticket', '>', 0)->avg('avg_ticket') ?? 0;
    $latestGrowth = $comparison->last()->revenue_growth ?? 0;
@endphp
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
    <div style="background: linear-gradient(135deg, #059669, #34d399); border-radius: 1rem; padding: 1.1rem; color: #fff;">
        <div style="font-size: 0.65rem; opacity: 0.85;">{{ __('admin.total_revenue') }}</div>
        <div style="font-size: 1.25rem; font-weight: 800; margin-top: 0.2rem;">{{ number_format($totalRev, 2) }} {{ $currency }}</div>
    </div>
    <div style="background: linear-gradient(135deg, #dc2626, #f87171); border-radius: 1rem; padding: 1.1rem; color: #fff;">
        <div style="font-size: 0.65rem; opacity: 0.85;">{{ __('admin.total_expenses') }}</div>
        <div style="font-size: 1.25rem; font-weight: 800; margin-top: 0.2rem;">{{ number_format($totalExp, 2) }} {{ $currency }}</div>
    </div>
    <div style="background: linear-gradient(135deg, #7c3aed, #a78bfa); border-radius: 1rem; padding: 1.1rem; color: #fff;">
        <div style="font-size: 0.65rem; opacity: 0.85;">{{ __('admin.total_bookings') }}</div>
        <div style="font-size: 1.25rem; font-weight: 800; margin-top: 0.2rem;">{{ number_format($totalBookings) }}</div>
    </div>
    <div style="background: linear-gradient(135deg, #0ea5e9, #38bdf8); border-radius: 1rem; padding: 1.1rem; color: #fff;">
        <div style="font-size: 0.65rem; opacity: 0.85;">{{ __('admin.avg_ticket') }}</div>
        <div style="font-size: 1.25rem; font-weight: 800; margin-top: 0.2rem;">{{ number_format($avgTicket, 2) }} {{ $currency }}</div>
    </div>
    <div style="background: linear-gradient(135deg, {{ $latestGrowth >= 0 ? '#059669, #34d399' : '#dc2626, #f87171' }}); border-radius: 1rem; padding: 1.1rem; color: #fff;">
        <div style="font-size: 0.65rem; opacity: 0.85;">{{ __('admin.latest_growth') }}</div>
        <div style="font-size: 1.25rem; font-weight: 800; margin-top: 0.2rem;">
            {{ $latestGrowth >= 0 ? '+' : '' }}{{ $latestGrowth }}%
            <i class="fas fa-arrow-{{ $latestGrowth >= 0 ? 'up' : 'down' }}" style="font-size: 0.75rem;"></i>
        </div>
    </div>
</div>

<!-- Comparison Table -->
<div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; overflow: hidden; margin-bottom: 1.5rem;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                <th style="padding: 0.65rem; font-size: 0.65rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.month') }}</th>
                <th style="padding: 0.65rem; font-size: 0.65rem; font-weight: 600; color: #6b7280; text-align: center;">{{ __('admin.revenue') }}</th>
                <th style="padding: 0.65rem; font-size: 0.65rem; font-weight: 600; color: #6b7280; text-align: center;">{{ __('admin.expenses') }}</th>
                <th style="padding: 0.65rem; font-size: 0.65rem; font-weight: 600; color: #6b7280; text-align: center;">{{ __('admin.net_profit') }}</th>
                <th style="padding: 0.65rem; font-size: 0.65rem; font-weight: 600; color: #6b7280; text-align: center;">{{ __('admin.bookings') }}</th>
                <th style="padding: 0.65rem; font-size: 0.65rem; font-weight: 600; color: #6b7280; text-align: center;">{{ __('admin.avg_ticket') }}</th>
                <th style="padding: 0.65rem; font-size: 0.65rem; font-weight: 600; color: #6b7280; text-align: center;">{{ __('admin.growth') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($comparison as $item)
            <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 0.65rem; font-size: 0.8rem; color: #374151; font-weight: 600;">{{ $item->label }}</td>
                <td style="padding: 0.65rem; text-align: center; font-size: 0.8rem; color: #059669; font-weight: 600;">{{ number_format($item->revenue, 2) }}</td>
                <td style="padding: 0.65rem; text-align: center; font-size: 0.8rem; color: #dc2626;">{{ number_format($item->expenses, 2) }}</td>
                <td style="padding: 0.65rem; text-align: center; font-size: 0.8rem; font-weight: 700; color: {{ $item->profit >= 0 ? '#059669' : '#dc2626' }};">{{ number_format($item->profit, 2) }}</td>
                <td style="padding: 0.65rem; text-align: center; font-size: 0.8rem; color: #374151;">{{ $item->bookings }}</td>
                <td style="padding: 0.65rem; text-align: center; font-size: 0.8rem; color: #374151;">{{ number_format($item->avg_ticket, 2) }}</td>
                <td style="padding: 0.65rem; text-align: center;">
                    @if($item->revenue_growth != 0)
                    <span style="font-size: 0.7rem; font-weight: 700; color: {{ $item->revenue_growth >= 0 ? '#059669' : '#dc2626' }};">
                        {{ $item->revenue_growth >= 0 ? '+' : '' }}{{ $item->revenue_growth }}%
                        <i class="fas fa-arrow-{{ $item->revenue_growth >= 0 ? 'up' : 'down' }}" style="font-size: 0.55rem;"></i>
                    </span>
                    @else
                    <span style="font-size: 0.7rem; color: #9ca3af;">—</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Revenue Bar Chart -->
@php $maxRevenue = $comparison->max('revenue') ?: 1; @endphp
<div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; padding: 1.25rem;">
    <h3 style="font-size: 0.9rem; font-weight: 700; color: #1f2937; margin-bottom: 1rem;">{{ __('admin.revenue_trend') }}</h3>
    <div style="display: flex; align-items: flex-end; gap: 0.5rem; height: 180px; padding: 0 0.5rem;">
        @foreach($comparison as $item)
        <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 0.25rem;">
            <div style="font-size: 0.55rem; color: #374151; font-weight: 600;">{{ number_format($item->revenue, 0) }}</div>
            <div style="display: flex; gap: 2px; align-items: flex-end; width: 100%; height: 140px;">
                <div style="flex: 1; background: linear-gradient(to top, #059669, #34d399); border-radius: 3px 3px 0 0; min-height: 2px; height: {{ $maxRevenue > 0 ? ($item->revenue / $maxRevenue * 100) : 0 }}%;" title="{{ __('admin.revenue') }}: {{ number_format($item->revenue, 2) }}"></div>
                <div style="flex: 1; background: linear-gradient(to top, #dc2626, #f87171); border-radius: 3px 3px 0 0; min-height: 2px; height: {{ $maxRevenue > 0 ? ($item->expenses / $maxRevenue * 100) : 0 }}%;" title="{{ __('admin.expenses') }}: {{ number_format($item->expenses, 2) }}"></div>
                <div style="flex: 1; background: linear-gradient(to top, {{ $item->profit >= 0 ? '#0ea5e9, #38bdf8' : '#f59e0b, #fbbf24' }}); border-radius: 3px 3px 0 0; min-height: 2px; height: {{ $maxRevenue > 0 ? (abs($item->profit) / $maxRevenue * 100) : 0 }}%;" title="{{ __('admin.net_profit') }}: {{ number_format($item->profit, 2) }}"></div>
            </div>
            <div style="font-size: 0.55rem; color: #9ca3af; text-align: center;">{{ \Carbon\Carbon::createFromFormat('Y-m', $item->month)->format('M') }}</div>
        </div>
        @endforeach
    </div>
    <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 0.75rem;">
        <div style="display: flex; align-items: center; gap: 0.3rem;"><span style="width: 10px; height: 10px; background: #059669; border-radius: 2px;"></span><span style="font-size: 0.65rem; color: #6b7280;">{{ __('admin.revenue') }}</span></div>
        <div style="display: flex; align-items: center; gap: 0.3rem;"><span style="width: 10px; height: 10px; background: #dc2626; border-radius: 2px;"></span><span style="font-size: 0.65rem; color: #6b7280;">{{ __('admin.expenses') }}</span></div>
        <div style="display: flex; align-items: center; gap: 0.3rem;"><span style="width: 10px; height: 10px; background: #0ea5e9; border-radius: 2px;"></span><span style="font-size: 0.65rem; color: #6b7280;">{{ __('admin.net_profit') }}</span></div>
    </div>
</div>
@endsection
