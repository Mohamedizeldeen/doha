@extends('sales.layout.app')

@section('page-title', __('admin.dashboard'))

@section('content')
<style>
    .stat-card { background: #fff; border-radius: 1rem; padding: 1.5rem; border: 1px solid rgba(0,0,0,0.05); transition: all 0.3s; }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.08); }
    .stat-icon { width: 48px; height: 48px; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; }
    .stat-value { font-size: 1.75rem; font-weight: 800; color: #1a1a2e; margin-top: 0.75rem; }
    .stat-label { font-size: 0.8rem; color: #64748b; margin-top: 0.25rem; }
    .section-title { font-size: 1.1rem; font-weight: 700; color: #1a1a2e; margin-bottom: 1rem; }
    .alert-card { border-radius: 0.75rem; padding: 1rem 1.25rem; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.75rem; font-size: 0.875rem; }
    .alert-warning { background: #fffbeb; border: 1px solid #fbbf24; color: #92400e; }
    .table-modern { width: 100%; border-collapse: separate; border-spacing: 0; }
    .table-modern th { background: #f8fafc; padding: 0.75rem 1rem; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }}; font-size: 0.75rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e2e8f0; }
    .table-modern td { padding: 0.85rem 1rem; border-bottom: 1px solid #f1f5f9; font-size: 0.875rem; color: #334155; }
    .table-modern tr:hover td { background: #f8fafc; }
    .badge { padding: 0.25rem 0.65rem; border-radius: 999px; font-size: 0.7rem; font-weight: 600; }
    .badge-active { background: #dcfce7; color: #166534; }
    .badge-expired { background: #fee2e2; color: #991b1b; }
    .badge-trial { background: #fef3c7; color: #92400e; }
</style>

<!-- Stats Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
    <div class="stat-card">
        <div class="stat-icon" style="background: #fdf2f8; color: #dd208e;"><i class="fas fa-store"></i></div>
        <div class="stat-value">{{ $totalSalons }}</div>
        <div class="stat-label">{{ __('admin.total_salons') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #ecfdf5; color: #10b981;"><i class="fas fa-check-circle"></i></div>
        <div class="stat-value">{{ $activeSalons }}</div>
        <div class="stat-label">{{ __('admin.active_salons') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #eff6ff; color: #3b82f6;"><i class="fas fa-money-bill-wave"></i></div>
        <div class="stat-value">{{ number_format($totalSubscriptionIncome, 2) }} <small style="font-size: 0.6em; color: #64748b;">{{ __('admin.omr') }}</small></div>
        <div class="stat-label">{{ __('admin.subscription_income') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #f0fdf4; color: #22c55e;"><i class="fas fa-hand-holding-usd"></i></div>
        <div class="stat-value">{{ number_format($totalCommission, 2) }} <small style="font-size: 0.6em; color: #64748b;">{{ __('admin.omr') }}</small></div>
        <div class="stat-label">{{ __('admin.my_commission') }} ({{ $commissionRate }}%)</div>
    </div>
</div>

<!-- Alerts Section -->
@if($expiringSoon->count() > 0)
<div style="margin-bottom: 1.5rem;">
    <h3 class="section-title"><i class="fas fa-exclamation-triangle" style="color: #f59e0b;"></i> {{ __('admin.expiring_soon') }}</h3>
    @foreach($expiringSoon as $salon)
    <div class="alert-card alert-warning">
        <i class="fas fa-clock"></i>
        <div>
            <strong>{{ app()->getLocale() === 'ar' ? $salon->name_ar : ($salon->name_en ?? $salon->name_ar) }}</strong>
            — {{ __('admin.expires_in') }} {{ $salon->daysRemaining() }} {{ __('admin.days') }}
        </div>
    </div>
    @endforeach
</div>
@endif

<!-- Recent Payments -->
@if($recentPayments->count() > 0)
<div style="background: #fff; border-radius: 1rem; padding: 1.5rem; border: 1px solid rgba(0,0,0,0.05); margin-bottom: 1.5rem;">
    <h3 class="section-title"><i class="fas fa-receipt" style="color: #dd208e;"></i> {{ __('admin.recent_payments') }}</h3>
    <div style="overflow-x: auto;">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>{{ __('admin.salon_name') }}</th>
                    <th>{{ __('admin.subscription_type') }}</th>
                    <th>{{ __('admin.amount') }}</th>
                    <th>{{ __('admin.my_commission') }}</th>
                    <th>{{ __('admin.period') }}</th>
                    <th>{{ __('admin.date') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentPayments as $payment)
                <tr>
                    <td><strong>{{ app()->getLocale() === 'ar' ? $payment->salon->name_ar : ($payment->salon->name_en ?? $payment->salon->name_ar) }}</strong></td>
                    <td>
                        @if($payment->subscription_type === 'monthly')
                            <span class="badge badge-active">{{ __('admin.monthly') }}</span>
                        @else
                            <span class="badge" style="background: #dbeafe; color: #1e40af;">{{ __('admin.yearly') }}</span>
                        @endif
                    </td>
                    <td>{{ number_format($payment->amount, 2) }} {{ __('admin.omr') }}</td>
                    <td style="color: #10b981; font-weight: 600;">{{ number_format($payment->commission_amount, 2) }} {{ __('admin.omr') }}</td>
                    <td style="font-size: 0.8rem;">{{ $payment->period_start?->format('Y-m-d') }} → {{ $payment->period_end?->format('Y-m-d') }}</td>
                    <td>{{ $payment->created_at->format('Y-m-d') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- Commission Chart -->
<div style="background: #fff; border-radius: 1rem; padding: 1.5rem; border: 1px solid rgba(0,0,0,0.05); margin-bottom: 1.5rem;">
    <h3 class="section-title">{{ __('admin.monthly_commission') }}</h3>
    <canvas id="commissionChart" height="80"></canvas>
</div>

<!-- My Salons Table -->
<div style="background: #fff; border-radius: 1rem; padding: 1.5rem; border: 1px solid rgba(0,0,0,0.05);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h3 class="section-title" style="margin-bottom: 0;">{{ __('admin.my_salons') }}</h3>
        <a href="{{ route('sales.salons.create') }}" style="background: linear-gradient(135deg, #dd208e, #b01670); color: #fff; padding: 0.5rem 1rem; border-radius: 0.625rem; text-decoration: none; font-size: 0.8rem; font-weight: 600;">
            <i class="fas fa-plus"></i> {{ __('admin.add_salon') }}
        </a>
    </div>
    <div style="overflow-x: auto;">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>{{ __('admin.salon_name') }}</th>
                    <th>{{ __('admin.subscription') }}</th>
                    <th>{{ __('admin.subscription_end') }}</th>
                    <th>{{ __('admin.status') }}</th>
                    <th>{{ __('admin.total_paid') }}</th>
                    <th>{{ __('admin.my_commission') }}</th>
                    <th>{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($soldSalons as $salon)
                <tr>
                    <td><strong>{{ app()->getLocale() === 'ar' ? $salon->name_ar : ($salon->name_en ?? $salon->name_ar) }}</strong></td>
                    <td>{{ ucfirst($salon->subscription_type ?? 'N/A') }}</td>
                    <td>{{ $salon->subscription_end_date ? \Carbon\Carbon::parse($salon->subscription_end_date)->format('Y-m-d') : '—' }}</td>
                    <td>
                        @if($salon->subscription_type === 'trial')
                            <span class="badge badge-trial">{{ __('admin.trial') }}</span>
                        @elseif($salon->isSubscriptionActive())
                            <span class="badge badge-active">{{ __('admin.active') }}</span>
                        @else
                            <span class="badge badge-expired">{{ __('admin.expired') }}</span>
                        @endif
                    </td>
                    <td>{{ number_format($salon->total_paid, 2) }} {{ __('admin.omr') }}</td>
                    <td style="color: #10b981; font-weight: 600;">{{ number_format($salon->salon_commission, 2) }} {{ __('admin.omr') }}</td>
                    <td>
                        <a href="{{ route('sales.salons.show', $salon) }}" style="color: #dd208e; text-decoration: none; font-weight: 500;">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 2rem; color: #94a3b8;">{{ __('admin.no_salons_yet') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('commissionChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode([__('admin.jan'), __('admin.feb'), __('admin.mar'), __('admin.apr'), __('admin.may'), __('admin.jun'), __('admin.jul'), __('admin.aug'), __('admin.sep'), __('admin.oct'), __('admin.nov'), __('admin.dec')]) !!},
            datasets: [{
                label: '{{ __("admin.commission") }}',
                data: @json($monthlyCommission),
                backgroundColor: 'rgba(221, 32, 142, 0.15)',
                borderColor: '#dd208e',
                borderWidth: 2,
                borderRadius: 8,
                barPercentage: 0.6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { font: { size: 11 } } },
                x: { grid: { display: false }, ticks: { font: { size: 11 } } }
            }
        }
    });
</script>
@endpush
@endsection
