@extends('admin.layout.app')

@section('page-title', __('admin.reports'))

@section('content')
<style>
    .report-card { background: #fff; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.04); padding: 1.25rem; margin-bottom: 1.25rem; }
    .report-card:hover { box-shadow: 0 8px 25px rgba(0,0,0,0.06); }
    .stat-hero { background: linear-gradient(135deg, #dd208e 0%, #9333ea 100%); border-radius: 1rem; padding: 1.5rem; color: #fff; margin-bottom: 1.5rem; }
    .stat-hero-card { background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border-radius: 0.75rem; padding: 1rem; border: 1px solid rgba(255,255,255,0.2); text-align: center; }
    .stat-hero-value { font-size: 1.6rem; font-weight: 800; line-height: 1; }
    .stat-hero-label { font-size: 0.72rem; opacity: 0.8; margin-top: 0.3rem; }
    .section-head { font-size: 0.95rem; font-weight: 700; color: #1a1a2e; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem; }
    .section-head i { color: #dd208e; }
    .table-clean { width: 100%; border-collapse: collapse; }
    .table-clean th { font-size: 0.72rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; padding: 0.75rem 0.5rem; border-bottom: 2px solid #f1f5f9; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }}; }
    .table-clean td { padding: 0.75rem 0.5rem; border-bottom: 1px solid #f8fafc; font-size: 0.85rem; color: #334155; }
    .table-clean tr:hover td { background: #fdf2f8; }
    .rank-badge { width: 26px; height: 26px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; }
    .rank-1 { background: linear-gradient(135deg, #fbbf24, #f59e0b); color: #fff; }
    .rank-2 { background: linear-gradient(135deg, #94a3b8, #64748b); color: #fff; }
    .rank-3 { background: linear-gradient(135deg, #cd7f32, #b8860b); color: #fff; }
    .rank-default { background: #f1f5f9; color: #64748b; }
    .chart-container { position: relative; height: 280px; }
    .progress-bar-custom { height: 8px; border-radius: 4px; background: #f1f5f9; overflow: hidden; }
    .progress-bar-fill { height: 100%; border-radius: 4px; background: linear-gradient(90deg, #dd208e, #9333ea); transition: width 0.6s ease; }
    .empty-state { text-align: center; padding: 2rem; color: #94a3b8; }
    .empty-state i { font-size: 2.5rem; margin-bottom: 0.75rem; display: block; }
</style>

{{-- HERO STATS --}}
<div class="stat-hero">
    <div style="font-size: 0.85rem; font-weight: 600; opacity: 0.85; margin-bottom: 1rem;">
        <i class="fas fa-chart-pie {{ app()->getLocale() === 'ar' ? 'ms-1' : 'me-1' }}"></i> {{ __('admin.reports_overview') }}
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 0.75rem;">
        <div class="stat-hero-card">
            <div class="stat-hero-value">{{ number_format($totalRevenue, 0) }}</div>
            <div class="stat-hero-label">{{ $currency }} &middot; {{ __('admin.total_revenue') }}</div>
        </div>
        <div class="stat-hero-card">
            <div class="stat-hero-value">{{ $totalBookings }}</div>
            <div class="stat-hero-label">{{ __('admin.total_bookings') }}</div>
        </div>
        <div class="stat-hero-card">
            <div class="stat-hero-value">{{ $completedBookings }}</div>
            <div class="stat-hero-label">{{ __('admin.completed_bookings') }}</div>
        </div>
        <div class="stat-hero-card">
            <div class="stat-hero-value">{{ number_format($avgBookingValue, 1) }}</div>
            <div class="stat-hero-label">{{ $currency }} &middot; {{ __('admin.avg_booking_value') }}</div>
        </div>
        <div class="stat-hero-card">
            <div class="stat-hero-value">{{ $totalClients }}</div>
            <div class="stat-hero-label">{{ __('admin.total_clients') }}</div>
        </div>
        <div class="stat-hero-card">
            <div class="stat-hero-value">{{ $busiestDay->day_name ?? '-' }}</div>
            <div class="stat-hero-label">{{ __('admin.busiest_day') }}</div>
        </div>
    </div>
</div>

{{-- CHARTS ROW --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 1.25rem; margin-bottom: 1.25rem;">
    {{-- Monthly Revenue Chart --}}
    <div class="report-card">
        <div class="section-head">
            <i class="fas fa-chart-line"></i>
            {{ __('admin.bookings_over_time') }}
        </div>
        @if($monthlyRevenue->count() > 0)
        <div class="chart-container">
            <canvas id="monthlyRevenueChart"></canvas>
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-chart-area"></i>
            {{ __('admin.no_report_data') }}
        </div>
        @endif
    </div>

    {{-- Revenue by Service Chart --}}
    <div class="report-card">
        <div class="section-head">
            <i class="fas fa-chart-bar"></i>
            {{ __('admin.revenue_by_service') }}
        </div>
        @if($revenueByService->count() > 0)
        <div class="chart-container">
            <canvas id="serviceRevenueChart"></canvas>
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-chart-bar"></i>
            {{ __('admin.no_report_data') }}
        </div>
        @endif
    </div>
</div>

{{-- TABLES ROW --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 1.25rem;">
    {{-- Top Clients --}}
    <div class="report-card">
        <div class="section-head">
            <i class="fas fa-crown"></i>
            {{ __('admin.top_clients') }}
        </div>
        @if($topClients->count() > 0)
        <div style="overflow-x: auto;">
            <table class="table-clean">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('admin.client_name') }}</th>
                        <th>{{ __('admin.visits') }}</th>
                        <th>{{ __('admin.total_spent') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topClients as $i => $client)
                    <tr>
                        <td>
                            <span class="rank-badge {{ $i === 0 ? 'rank-1' : ($i === 1 ? 'rank-2' : ($i === 2 ? 'rank-3' : 'rank-default')) }}">
                                {{ $i + 1 }}
                            </span>
                        </td>
                        <td>
                            <div style="font-weight: 600;">{{ app()->getLocale() === 'ar' ? $client->name_ar : $client->name_en }}</div>
                            <div style="font-size: 0.72rem; color: #94a3b8;">{{ $client->phone }}</div>
                        </td>
                        <td>{{ $client->visits }}</td>
                        <td style="font-weight: 600; color: #dd208e;">{{ number_format($client->total_spent, 1) }} {{ $currency }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-users"></i>
            {{ __('admin.no_report_data') }}
        </div>
        @endif
    </div>

    {{-- Staff Performance --}}
    <div class="report-card">
        <div class="section-head">
            <i class="fas fa-trophy"></i>
            {{ __('admin.staff_performance') }}
        </div>
        @if($staffPerformance->count() > 0)
        @php $maxStaffRevenue = $staffPerformance->max('total_revenue') ?: 1; @endphp
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            @foreach($staffPerformance as $i => $staff)
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span class="rank-badge {{ $i === 0 ? 'rank-1' : ($i === 1 ? 'rank-2' : ($i === 2 ? 'rank-3' : 'rank-default')) }}">
                            {{ $i + 1 }}
                        </span>
                        <span style="font-weight: 600; font-size: 0.85rem;">{{ app()->getLocale() === 'ar' ? $staff->name_ar : $staff->name_en }}</span>
                    </div>
                    <div style="text-align: {{ app()->getLocale() === 'ar' ? 'left' : 'right' }};">
                        <div style="font-weight: 700; font-size: 0.85rem; color: #dd208e;">{{ number_format($staff->total_revenue, 1) }} {{ $currency }}</div>
                        <div style="font-size: 0.7rem; color: #94a3b8;">{{ $staff->bookings_count }} {{ __('admin.bookings') }}</div>
                    </div>
                </div>
                <div class="progress-bar-custom">
                    <div class="progress-bar-fill" style="width: {{ ($staff->total_revenue / $maxStaffRevenue) * 100 }}%;"></div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-user-tie"></i>
            {{ __('admin.no_report_data') }}
        </div>
        @endif
    </div>
</div>

{{-- Revenue by Service Table --}}
<div class="report-card" style="margin-top: 1.25rem;">
    <div class="section-head">
        <i class="fas fa-list-ol"></i>
        {{ __('admin.revenue_by_service') }} — {{ __('admin.details') }}
    </div>
    @if($revenueByService->count() > 0)
    @php $maxServiceRevenue = $revenueByService->max('total_revenue') ?: 1; @endphp
    <div style="overflow-x: auto;">
        <table class="table-clean">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('admin.service') }}</th>
                    <th>{{ __('admin.bookings_count') }}</th>
                    <th>{{ __('admin.revenue') }}</th>
                    <th style="width: 30%;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($revenueByService as $i => $service)
                <tr>
                    <td>
                        <span class="rank-badge {{ $i === 0 ? 'rank-1' : ($i === 1 ? 'rank-2' : ($i === 2 ? 'rank-3' : 'rank-default')) }}">
                            {{ $i + 1 }}
                        </span>
                    </td>
                    <td style="font-weight: 600;">{{ app()->getLocale() === 'ar' ? $service->name_ar : $service->name_en }}</td>
                    <td>{{ $service->bookings_count }}</td>
                    <td style="font-weight: 700; color: #dd208e;">{{ number_format($service->total_revenue, 1) }} {{ $currency }}</td>
                    <td>
                        <div class="progress-bar-custom">
                            <div class="progress-bar-fill" style="width: {{ ($service->total_revenue / $maxServiceRevenue) * 100 }}%;"></div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="empty-state">
        <i class="fas fa-concierge-bell"></i>
        {{ __('admin.no_report_data') }}
    </div>
    @endif
</div>

{{-- Daily Bookings (Last 30 Days) --}}
<div class="report-card" style="margin-top: 1.25rem;">
    <div class="section-head">
        <i class="fas fa-calendar-check"></i>
        {{ __('admin.bookings_over_time') }} — {{ __('admin.last_30_days') }}
    </div>
    @if($bookingsOverTime->count() > 0)
    <div class="chart-container" style="height: 220px;">
        <canvas id="dailyBookingsChart"></canvas>
    </div>
    @else
    <div class="empty-state">
        <i class="fas fa-calendar-alt"></i>
        {{ __('admin.no_report_data') }}
    </div>
    @endif
</div>

{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isRtl = '{{ app()->getLocale() }}' === 'ar';
    const currency = '{{ $currency }}';

    Chart.defaults.font.family = '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif';
    Chart.defaults.font.size = 11;

    // ── Monthly Revenue Line Chart ──────────────────────
    @if($monthlyRevenue->count() > 0)
    new Chart(document.getElementById('monthlyRevenueChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyRevenue->pluck('month')) !!},
            datasets: [{
                label: isRtl ? 'الإيرادات' : 'Revenue',
                data: {!! json_encode($monthlyRevenue->pluck('revenue')) !!},
                borderColor: '#dd208e',
                backgroundColor: 'rgba(221, 32, 142, 0.1)',
                borderWidth: 2.5,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#dd208e',
                pointRadius: 4,
                pointHoverRadius: 6
            }, {
                label: isRtl ? 'الحجوزات' : 'Bookings',
                data: {!! json_encode($monthlyRevenue->pluck('bookings')) !!},
                borderColor: '#9333ea',
                backgroundColor: 'rgba(147, 51, 234, 0.1)',
                borderWidth: 2,
                fill: false,
                tension: 0.4,
                pointBackgroundColor: '#9333ea',
                pointRadius: 3,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { intersect: false, mode: 'index' },
            plugins: {
                legend: { position: 'top', labels: { usePointStyle: true, padding: 15 } }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    position: isRtl ? 'right' : 'left',
                    title: { display: true, text: currency }
                },
                y1: {
                    beginAtZero: true,
                    position: isRtl ? 'left' : 'right',
                    grid: { drawOnChartArea: false },
                    title: { display: true, text: isRtl ? 'حجوزات' : 'Bookings' }
                }
            }
        }
    });
    @endif

    // ── Revenue by Service Doughnut ─────────────────────
    @if($revenueByService->count() > 0)
    const serviceColors = ['#dd208e','#9333ea','#f59e0b','#10b981','#3b82f6','#ef4444','#8b5cf6','#ec4899','#14b8a6','#f97316'];
    new Chart(document.getElementById('serviceRevenueChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($revenueByService->map(fn($s) => app()->getLocale() === 'ar' ? $s->name_ar : $s->name_en)->values()) !!},
            datasets: [{
                data: {!! json_encode($revenueByService->pluck('total_revenue')) !!},
                backgroundColor: serviceColors.slice(0, {{ $revenueByService->count() }}),
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { usePointStyle: true, padding: 12, font: { size: 10 } }
                },
                tooltip: {
                    callbacks: {
                        label: function(ctx) {
                            const total = ctx.dataset.data.reduce((a, b) => a + parseFloat(b), 0);
                            const pct = ((ctx.parsed / total) * 100).toFixed(1);
                            return ctx.label + ': ' + parseFloat(ctx.parsed).toLocaleString() + ' ' + currency + ' (' + pct + '%)';
                        }
                    }
                }
            }
        }
    });
    @endif

    // ── Daily Bookings Bar Chart ────────────────────────
    @if($bookingsOverTime->count() > 0)
    new Chart(document.getElementById('dailyBookingsChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($bookingsOverTime->pluck('date')) !!},
            datasets: [{
                label: isRtl ? 'الحجوزات' : 'Bookings',
                data: {!! json_encode($bookingsOverTime->pluck('count')) !!},
                backgroundColor: 'rgba(221, 32, 142, 0.7)',
                borderColor: '#dd208e',
                borderWidth: 1,
                borderRadius: 4,
                barPercentage: 0.7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    position: isRtl ? 'right' : 'left',
                    ticks: { stepSize: 1 }
                },
                x: {
                    ticks: { maxRotation: 45, font: { size: 9 } }
                }
            }
        }
    });
    @endif
});
</script>
@endsection
