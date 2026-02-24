@extends('superAdmin.layout.app')

@section('page-title', __('admin.main_dashboard'))

@section('content')
<style>
    .stat-card { background: #fff; border-radius: 1rem; padding: 1.25rem; border: 1px solid rgba(0,0,0,0.04); transition: all 0.3s; position: relative; overflow: hidden; }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.06); }
    .stat-card .stat-icon { width: 48px; height: 48px; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
    .stat-card .stat-value { font-size: 1.5rem; font-weight: 800; color: #1a1a2e; line-height: 1; }
    .stat-card .stat-label { font-size: 0.75rem; color: #94a3b8; font-weight: 500; margin-top: 0.25rem; }
    .alert-card { border-radius: 1rem; padding: 1rem 1.25rem; display: flex; align-items: center; gap: 0.75rem; }
    .section-head { font-size: 1rem; font-weight: 700; color: #1a1a2e; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem; }
    .section-head i { color: #dd208e; }
    .card-box { background: #fff; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.04); padding: 1.25rem; }
    .data-table { width: 100%; border-collapse: collapse; font-size: 0.8rem; }
    .data-table th { background: #f8fafc; padding: 0.65rem 1rem; text-align: start; font-weight: 600; color: #64748b; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05em; }
    .data-table td { padding: 0.65rem 1rem; border-top: 1px solid #f1f5f9; color: #334155; }
    .data-table tbody tr:hover { background: #fafbfc; }
    .badge-sm { padding: 0.15rem 0.5rem; border-radius: 999px; font-size: 0.65rem; font-weight: 700; }
    .income-highlight { background: linear-gradient(135deg, #dd208e, #9333ea); color: #fff; border: none; }
    .income-highlight .stat-value, .income-highlight .stat-label { color: #fff; }
    .income-highlight .stat-icon { background: rgba(255,255,255,0.2); color: #fff; }
    .payment-modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; }
    .payment-modal-overlay.active { display: flex; }
    .payment-modal { background: #fff; border-radius: 1.25rem; padding: 2rem; width: 90%; max-width: 420px; box-shadow: 0 20px 60px rgba(0,0,0,0.15); }
</style>

{{-- SUBSCRIPTION ALERTS --}}
@if(isset($overdueSalons) && $overdueSalons->count() > 0)
<div class="alert-card" style="background: linear-gradient(135deg, #fef2f2, #fff1f2); border: 1px solid #fecaca; margin-bottom: 1rem;">
    <div style="width: 40px; height: 40px; border-radius: 0.75rem; background: #ef4444; display: flex; align-items: center; justify-content: center; color: #fff; flex-shrink: 0;">
        <i class="fas fa-exclamation-triangle"></i>
    </div>
    <div style="flex: 1;">
        <div style="font-weight: 700; color: #991b1b; font-size: 0.85rem;">{{ __('admin.overdue_subscriptions') }} ({{ $overdueSalons->count() }})</div>
        <div style="font-size: 0.75rem; color: #b91c1c; margin-top: 0.15rem;">
            @foreach($overdueSalons->take(3) as $s)
                {{ app()->getLocale() === 'ar' ? $s->name_ar : ($s->name_en ?? $s->name_ar) }}@if(!$loop->last), @endif
            @endforeach
            @if($overdueSalons->count() > 3) +{{ $overdueSalons->count() - 3 }} {{ __('admin.more') }}@endif
        </div>
    </div>
</div>
@endif

@if(isset($expiringSoon) && $expiringSoon->count() > 0)
<div class="alert-card" style="background: linear-gradient(135deg, #fffbeb, #fef3c7); border: 1px solid #fde68a; margin-bottom: 1.25rem;">
    <div style="width: 40px; height: 40px; border-radius: 0.75rem; background: #f59e0b; display: flex; align-items: center; justify-content: center; color: #fff; flex-shrink: 0;">
        <i class="fas fa-clock"></i>
    </div>
    <div style="flex: 1;">
        <div style="font-weight: 700; color: #92400e; font-size: 0.85rem;">{{ __('admin.expiring_soon') }} ({{ $expiringSoon->count() }})</div>
        <div style="font-size: 0.75rem; color: #a16207; margin-top: 0.15rem;">
            @foreach($expiringSoon->take(4) as $s)
                {{ app()->getLocale() === 'ar' ? $s->name_ar : ($s->name_en ?? $s->name_ar) }} ({{ $s->daysRemaining() }} {{ __('admin.days') }})@if(!$loop->last), @endif
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- INCOME STAT CARDS --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
    <div class="stat-card income-highlight">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <div class="stat-icon"><i class="fas fa-wallet"></i></div>
            <div>
                <div class="stat-value">{{ number_format($totalIncome, 1) }}</div>
                <div class="stat-label">{{ __('admin.total_app_income') }} ({{ __('admin.omr') }})</div>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <div class="stat-icon" style="background: #f0fdf4; color: #16a34a;"><i class="fas fa-calendar-alt"></i></div>
            <div>
                <div class="stat-value">{{ number_format($thisMonthIncome, 1) }}</div>
                <div class="stat-label">{{ __('admin.this_month_income') }} ({{ __('admin.omr') }})</div>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <div class="stat-icon" style="background: #eff6ff; color: #2563eb;"><i class="fas fa-store"></i></div>
            <div>
                <div class="stat-value">{{ $totalSalons }}</div>
                <div class="stat-label">{{ __('admin.total_salons') }}</div>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <div class="stat-icon" style="background: #faf5ff; color: #9333ea;"><i class="fas fa-hand-holding-usd"></i></div>
            <div>
                <div class="stat-value">{{ number_format($totalCommissionsPaid, 1) }}</div>
                <div class="stat-label">{{ __('admin.total_commissions') }} ({{ __('admin.omr') }})</div>
            </div>
        </div>
    </div>
</div>

{{-- SUBSCRIPTION STATUS ROW --}}
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
    <div class="stat-card" style="border-inline-start: 4px solid #16a34a;">
        <div class="stat-value" style="color: #16a34a;">{{ $activeSalons }}</div>
        <div class="stat-label">{{ __('admin.active_subscriptions') }}</div>
    </div>
    <div class="stat-card" style="border-inline-start: 4px solid #eab308;">
        <div class="stat-value" style="color: #eab308;">{{ $trialSalons }}</div>
        <div class="stat-label">{{ __('admin.trial_salons') }}</div>
    </div>
    <div class="stat-card" style="border-inline-start: 4px solid #2563eb;">
        <div class="stat-value" style="color: #2563eb;">{{ number_format($monthlySubIncome, 1) }}</div>
        <div class="stat-label">{{ __('admin.monthly_sub_income') }} ({{ __('admin.omr') }})</div>
    </div>
    <div class="stat-card" style="border-inline-start: 4px solid #9333ea;">
        <div class="stat-value" style="color: #9333ea;">{{ number_format($yearlySubIncome, 1) }}</div>
        <div class="stat-label">{{ __('admin.yearly_sub_income') }} ({{ __('admin.omr') }})</div>
    </div>
</div>

{{-- SALES USERS OVERVIEW --}}
@if(isset($salesUsers) && $salesUsers->count() > 0)
<div class="card-box" style="margin-bottom: 1.5rem;">
    <div class="section-head">
        <i class="fas fa-user-tie"></i> {{ __('admin.sales_users') }}
        <a href="{{ route('superAdmin.salesUsers.index') }}" style="margin-inline-start: auto; font-size: 0.75rem; color: #dd208e; font-weight: 600; text-decoration: none;">{{ __('admin.view_all') }} &rarr;</a>
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 0.75rem;">
        @foreach($salesUsers as $su)
        <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background: #f8fafc; border-radius: 0.75rem;">
            <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #dd208e, #9333ea); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; flex-shrink: 0;">
                {{ mb_substr($su->name, 0, 1) }}
            </div>
            <div style="flex: 1; min-width: 0;">
                <div style="font-weight: 700; font-size: 0.8rem; color: #1a1a2e; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $su->name }}</div>
                <div style="font-size: 0.7rem; color: #94a3b8;">{{ $su->sold_salons_count ?? 0 }} {{ __('admin.salons') }} &middot; {{ $su->commission_rate }}%</div>
            </div>
            <div style="text-align: end;">
                <div style="font-size: 0.8rem; font-weight: 700; color: #16a34a;">{{ number_format($su->total_commission, 1) }} <span style="font-size: 0.6rem; font-weight: 500;">{{ __('admin.omr') }}</span></div>
                <div style="font-size: 0.6rem; color: #94a3b8;">{{ __('admin.commission') }}</div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- CHARTS --}}
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.5rem;">
    <div class="card-box">
        <div class="section-head"><i class="fas fa-chart-bar"></i> {{ __('admin.monthly_subscription_income') }}</div>
        <div style="position: relative; height: 280px;"><canvas id="incomeChart"></canvas></div>
    </div>
    <div class="card-box">
        <div class="section-head"><i class="fas fa-chart-pie"></i> {{ __('admin.subscription_distribution') }}</div>
        <div style="position: relative; height: 280px;"><canvas id="subscriptionChart"></canvas></div>
    </div>
</div>

{{-- RECENT PAYMENTS --}}
<div class="card-box" style="margin-bottom: 1.5rem;">
    <div class="section-head"><i class="fas fa-receipt"></i> {{ __('admin.recent_payments') }}</div>
    <div style="overflow-x: auto; border-radius: 0.75rem; border: 1px solid #f1f5f9;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>{{ __('admin.salon') }}</th>
                    <th>{{ __('admin.subscription_type') }}</th>
                    <th>{{ __('admin.amount') }}</th>
                    <th>{{ __('admin.commission') }}</th>
                    <th>{{ __('admin.sales_person') }}</th>
                    <th>{{ __('admin.date') }}</th>
                    <th>{{ __('admin.status') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentPayments as $payment)
                <tr>
                    <td class="font-semibold">{{ app()->getLocale() === 'ar' ? $payment->salon->name_ar : ($payment->salon->name_en ?? $payment->salon->name_ar) }}</td>
                    <td>
                        <span class="badge-sm" style="background: {{ $payment->subscription_type === 'yearly' ? '#9333ea15' : '#2563eb15' }}; color: {{ $payment->subscription_type === 'yearly' ? '#9333ea' : '#2563eb' }};">
                            {{ __('admin.' . $payment->subscription_type) }}
                        </span>
                    </td>
                    <td style="font-weight: 700; color: #16a34a;">{{ number_format($payment->amount, 1) }} {{ __('admin.omr') }}</td>
                    <td>
                        @if($payment->commission_amount > 0)
                            <span style="color: #ea580c; font-weight: 600;">{{ number_format($payment->commission_amount, 1) }} {{ __('admin.omr') }}</span>
                            <span style="font-size: 0.6rem; color: #94a3b8;">({{ $payment->commission_rate }}%)</span>
                        @else
                            <span style="color: #94a3b8;">-</span>
                        @endif
                    </td>
                    <td>{{ $payment->salesUser->name ?? '-' }}</td>
                    <td dir="ltr">{{ $payment->created_at->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge-sm" style="background: {{ $payment->status === 'paid' ? '#16a34a15' : ($payment->status === 'pending' ? '#eab30815' : '#ef444415') }}; color: {{ $payment->status === 'paid' ? '#16a34a' : ($payment->status === 'pending' ? '#eab308' : '#ef4444') }};">
                            {{ __('admin.payment_' . $payment->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 2rem; color: #94a3b8;">{{ __('admin.no_payments_yet') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- SALONS TABLE WITH PAYMENT ACTION --}}
<div class="card-box">
    <div class="section-head"><i class="fas fa-store"></i> {{ __('admin.salons_subscription_status') }}</div>
    <div style="overflow-x: auto; border-radius: 0.75rem; border: 1px solid #f1f5f9;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>{{ __('admin.salon') }}</th>
                    <th>{{ __('admin.subscription_type') }}</th>
                    <th>{{ __('admin.subscription_end') }}</th>
                    <th>{{ __('admin.total_paid') }}</th>
                    <th>{{ __('admin.sales_person') }}</th>
                    <th>{{ __('admin.status') }}</th>
                    <th>{{ __('admin.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($salons as $salon)
                <tr>
                    <td class="font-semibold">{{ app()->getLocale() === 'ar' ? $salon->name_ar : ($salon->name_en ?? $salon->name_ar) }}</td>
                    <td>
                        @php $typeColor = ['trial'=>'#f59e0b','monthly'=>'#2563eb','yearly'=>'#9333ea']; @endphp
                        <span class="badge-sm" style="background: {{ ($typeColor[$salon->subscription_type] ?? '#94a3b8') }}15; color: {{ $typeColor[$salon->subscription_type] ?? '#94a3b8' }};">
                            {{ __('admin.' . ($salon->subscription_type ?? 'trial')) }}
                        </span>
                    </td>
                    <td dir="ltr">{{ $salon->subscription_end_date ? $salon->subscription_end_date->format('d/m/Y') : '-' }}</td>
                    <td style="font-weight: 700;">{{ number_format($salon->total_paid, 1) }} {{ __('admin.omr') }}</td>
                    <td>{{ $salon->salesUser->name ?? '-' }}</td>
                    <td>
                        @if($salon->isSubscriptionActive())
                            <span class="badge-sm" style="background: #16a34a15; color: #16a34a;">{{ __('admin.active') }}</span>
                        @else
                            <span class="badge-sm" style="background: #ef444415; color: #ef4444;">{{ __('admin.expired') }}</span>
                        @endif
                    </td>
                    <td>
                        <button onclick="openPaymentModal({{ $salon->id }}, '{{ addslashes(app()->getLocale() === 'ar' ? $salon->name_ar : ($salon->name_en ?? $salon->name_ar)) }}')"
                            style="background: linear-gradient(135deg, #dd208e, #9333ea); color: #fff; border: none; padding: 0.3rem 0.75rem; border-radius: 0.5rem; font-size: 0.7rem; font-weight: 600; cursor: pointer; white-space: nowrap;">
                            <i class="fas fa-plus-circle"></i> {{ __('admin.record_payment') }}
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- PAYMENT MODAL --}}
<div class="payment-modal-overlay" id="paymentModal">
    <div class="payment-modal">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
            <h3 style="font-size: 1.1rem; font-weight: 800; color: #1a1a2e; margin: 0;">
                <i class="fas fa-receipt" style="color: #dd208e; margin-inline-end: 0.5rem;"></i>{{ __('admin.record_payment') }}
            </h3>
            <button onclick="closePaymentModal()" style="background: none; border: none; font-size: 1.2rem; color: #94a3b8; cursor: pointer;">&times;</button>
        </div>
        <div style="font-size: 0.85rem; color: #64748b; margin-bottom: 1rem;">
            {{ __('admin.salon') }}: <strong id="modalSalonName" style="color: #1a1a2e;"></strong>
        </div>
        <form id="paymentForm" method="POST">
            @csrf
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.8rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">{{ __('admin.subscription_type') }}</label>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; padding: 0.75rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; cursor: pointer; transition: all 0.2s;" id="monthlyLabel">
                        <input type="radio" name="subscription_type" value="monthly" checked onchange="updatePaymentTypeUI()"
                            style="accent-color: #dd208e;">
                        <div>
                            <div style="font-weight: 700; font-size: 0.85rem; color: #1a1a2e;">{{ __('admin.monthly') }}</div>
                            <div style="font-size: 0.75rem; color: #16a34a; font-weight: 600;">15 {{ __('admin.omr') }}</div>
                        </div>
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; padding: 0.75rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; cursor: pointer; transition: all 0.2s;" id="yearlyLabel">
                        <input type="radio" name="subscription_type" value="yearly" onchange="updatePaymentTypeUI()"
                            style="accent-color: #dd208e;">
                        <div>
                            <div style="font-weight: 700; font-size: 0.85rem; color: #1a1a2e;">{{ __('admin.yearly') }}</div>
                            <div style="font-size: 0.75rem; color: #16a34a; font-weight: 600;">120 {{ __('admin.omr') }}</div>
                        </div>
                    </label>
                </div>
            </div>
            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.8rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">{{ __('admin.notes') }}</label>
                <textarea name="notes" rows="2" style="width: 100%; border: 1px solid #e2e8f0; border-radius: 0.5rem; padding: 0.5rem 0.75rem; font-size: 0.8rem; resize: none; font-family: inherit;" placeholder="{{ __('admin.payment_notes_placeholder') }}"></textarea>
            </div>
            <button type="submit" style="width: 100%; background: linear-gradient(135deg, #dd208e, #9333ea); color: #fff; border: none; padding: 0.75rem; border-radius: 0.75rem; font-size: 0.9rem; font-weight: 700; cursor: pointer;">
                <i class="fas fa-check-circle"></i> {{ __('admin.confirm_payment') }}
            </button>
        </form>
    </div>
</div>

@php
$monthLabels = [
    __('admin.january'), __('admin.february'), __('admin.march'), __('admin.april'),
    __('admin.may'), __('admin.june'), __('admin.july'), __('admin.august'),
    __('admin.september'), __('admin.october'), __('admin.november'), __('admin.december')
];
$incomeData = array_values($monthlyIncome);
@endphp

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Payment Modal
function openPaymentModal(salonId, salonName) {
    document.getElementById('modalSalonName').textContent = salonName;
    document.getElementById('paymentForm').action = '/superadmin/salons/' + salonId + '/payment';
    document.getElementById('paymentModal').classList.add('active');
    updatePaymentTypeUI();
}
function closePaymentModal() {
    document.getElementById('paymentModal').classList.remove('active');
}
function updatePaymentTypeUI() {
    const monthly = document.querySelector('input[value="monthly"]').checked;
    document.getElementById('monthlyLabel').style.borderColor = monthly ? '#dd208e' : '#e2e8f0';
    document.getElementById('yearlyLabel').style.borderColor = !monthly ? '#dd208e' : '#e2e8f0';
}
document.getElementById('paymentModal').addEventListener('click', function(e) {
    if (e.target === this) closePaymentModal();
});

// Charts
document.addEventListener('DOMContentLoaded', function() {
    const incomeCtx = document.getElementById('incomeChart');
    if (incomeCtx) {
        new Chart(incomeCtx, {
            type: 'bar',
            data: {
                labels: @json($monthLabels),
                datasets: [{
                    label: '{{ __("admin.subscription_income") }}',
                    data: @json($incomeData),
                    backgroundColor: 'rgba(221, 32, 142, 0.15)',
                    borderColor: '#dd208e',
                    borderWidth: 2,
                    borderRadius: 8,
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } } }
        });
    }
    const subCtx = document.getElementById('subscriptionChart');
    if (subCtx) {
        new Chart(subCtx, {
            type: 'doughnut',
            data: {
                labels: ['{{ __("admin.trial") }}', '{{ __("admin.monthly") }}', '{{ __("admin.yearly") }}'],
                datasets: [{
                    data: [{{ $subscriptionStats['trial'] }}, {{ $subscriptionStats['monthly'] }}, {{ $subscriptionStats['yearly'] }}],
                    backgroundColor: ['#f59e0b', '#2563eb', '#9333ea'],
                    borderWidth: 0,
                    cutout: '70%',
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { font: { size: 11 }, usePointStyle: true, padding: 16 } } } }
        });
    }
});
</script>

@endsection
