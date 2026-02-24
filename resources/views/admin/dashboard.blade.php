@extends('admin.layout.app')

@section('page-title', __('admin.dashboard'))

@section('content')
<style>
    .stat-card { background: #fff; border-radius: 1rem; padding: 1.25rem; border: 1px solid rgba(0,0,0,0.04); transition: all 0.3s; }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.06); }
    .stat-icon { width: 44px; height: 44px; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
    .stat-value { font-size: 1.4rem; font-weight: 800; color: #1a1a2e; line-height: 1; }
    .stat-label { font-size: 0.72rem; color: #94a3b8; font-weight: 500; margin-top: 0.2rem; }
    .card-box { background: #fff; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.04); padding: 1.25rem; }
    .section-head { font-size: 0.95rem; font-weight: 700; color: #1a1a2e; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem; }
    .section-head i { color: #dd208e; }
    .revenue-hero { background: linear-gradient(135deg, #dd208e 0%, #9333ea 100%); border-radius: 1rem; padding: 1.5rem; color: #fff; }
    .revenue-card { background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border-radius: 0.75rem; padding: 1rem; border: 1px solid rgba(255,255,255,0.2); }
    .mini-stat { border-inline-start: 3px solid; padding: 0.75rem 1rem; background: #fff; border-radius: 0.5rem; }
</style>

{{-- REVENUE HERO --}}
<div class="revenue-hero" style="margin-bottom: 1.5rem;">
    <div style="font-size: 0.85rem; font-weight: 600; opacity: 0.85; margin-bottom: 1rem;">
        <i class="fas fa-chart-line me-1"></i> {{ __('admin.revenue_summary') }}
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 0.75rem;">
        <div class="revenue-card">
            <div style="font-size: 0.72rem; opacity: 0.8;">{{ __('admin.this_week') }}</div>
            <div style="font-size: 1.5rem; font-weight: 800; margin-top: 0.25rem;">{{ number_format($weeklyTotal ?? 0, 0) }}</div>
            <div style="font-size: 0.65rem; opacity: 0.6;">{{ $salon->currency }} &middot; {{ __('admin.last_7_days') }}</div>
        </div>
        <div class="revenue-card">
            <div style="font-size: 0.72rem; opacity: 0.8;">{{ __('admin.this_month') }}</div>
            <div style="font-size: 1.5rem; font-weight: 800; margin-top: 0.25rem;">{{ number_format($monthlyTotal ?? 0, 0) }}</div>
            <div style="font-size: 0.65rem; opacity: 0.6;">{{ $salon->currency }} &middot; {{ __('admin.current_month') }}</div>
        </div>
        <div class="revenue-card">
            <div style="font-size: 0.72rem; opacity: 0.8;">{{ __('admin.this_year') }}</div>
            <div style="font-size: 1.5rem; font-weight: 800; margin-top: 0.25rem;">{{ number_format($yearlyTotal ?? 0, 0) }}</div>
            <div style="font-size: 0.65rem; opacity: 0.6;">{{ $salon->currency }} &middot; {{ __('admin.current_year') }}</div>
        </div>
    </div>
</div>

{{-- STAT CARDS --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 0.75rem; margin-bottom: 1.25rem;">
    <div class="stat-card">
        <div style="display: flex; align-items: center; gap: 0.6rem;">
            <div class="stat-icon" style="background: #eff6ff; color: #2563eb;"><i class="fas fa-calendar-check"></i></div>
            <div><div class="stat-value">{{ $totalBookings }}</div><div class="stat-label">{{ __('admin.total_bookings') }}</div></div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display: flex; align-items: center; gap: 0.6rem;">
            <div class="stat-icon" style="background: #f0fdf4; color: #16a34a;"><i class="fas fa-check-circle"></i></div>
            <div><div class="stat-value" style="color: #16a34a;">{{ $confirmedBookings }}</div><div class="stat-label">{{ __('admin.completed_bookings') }}</div></div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display: flex; align-items: center; gap: 0.6rem;">
            <div class="stat-icon" style="background: #fffbeb; color: #eab308;"><i class="fas fa-clock"></i></div>
            <div><div class="stat-value" style="color: #eab308;">{{ $pendingBookings }}</div><div class="stat-label">{{ __('admin.scheduled_bookings') }}</div></div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display: flex; align-items: center; gap: 0.6rem;">
            <div class="stat-icon" style="background: #fef2f2; color: #ef4444;"><i class="fas fa-times-circle"></i></div>
            <div><div class="stat-value" style="color: #ef4444;">{{ $cancelledBookings }}</div><div class="stat-label">{{ __('admin.cancelled_bookings') }}</div></div>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 0.75rem; margin-bottom: 1.5rem;">
    <div class="stat-card">
        <div style="display: flex; align-items: center; gap: 0.6rem;">
            <div class="stat-icon" style="background: #faf5ff; color: #9333ea;"><i class="fas fa-users"></i></div>
            <div><div class="stat-value">{{ $totalClients }}</div><div class="stat-label">{{ __('admin.total_clients') }}</div></div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display: flex; align-items: center; gap: 0.6rem;">
            <div class="stat-icon" style="background: #eef2ff; color: #6366f1;"><i class="fas fa-concierge-bell"></i></div>
            <div><div class="stat-value">{{ $totalServices }}</div><div class="stat-label">{{ __('admin.total_services') }}</div></div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display: flex; align-items: center; gap: 0.6rem;">
            <div class="stat-icon" style="background: #fdf2f8; color: #ec4899;"><i class="fas fa-user-tie"></i></div>
            <div><div class="stat-value">{{ $totalStaff }}</div><div class="stat-label">{{ __('admin.total_staff') }}</div></div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display: flex; align-items: center; gap: 0.6rem;">
            <div class="stat-icon" style="background: #fff7ed; color: #ea580c;"><i class="fas fa-box"></i></div>
            <div><div class="stat-value">{{ $totalProducts }}</div><div class="stat-label">{{ __('admin.total_products') }}</div></div>
        </div>
    </div>
</div>

{{-- CHARTS ROW --}}
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.5rem;">
    <div class="card-box">
        <div class="section-head"><i class="fas fa-chart-line"></i> {{ __('admin.weekly_revenue') }}</div>
        <div style="position: relative; height: 260px;"><canvas id="weeklyChart"></canvas></div>
    </div>
    <div class="card-box">
        <div class="section-head"><i class="fas fa-chart-bar"></i> {{ __('admin.yearly_revenue_monthly') }}</div>
        <div style="position: relative; height: 260px;"><canvas id="monthlyChart"></canvas></div>
    </div>
</div>

{{-- FILTER SECTION --}}
<div class="card-box" style="margin-bottom: 1.5rem;">
    <div class="section-head"><i class="fas fa-filter"></i> {{ __('admin.filter_revenue') }}</div>
    <form id="filterForm" style="margin-bottom: 1rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 0.75rem; align-items: end;">
            <div>
                <label style="display: block; font-size: 0.72rem; font-weight: 600; color: #64748b; margin-bottom: 0.3rem;">{{ __('admin.specific_date') }}</label>
                <input type="date" id="filterDate" name="date" style="width: 100%; padding: 0.5rem 0.75rem; border: 1.5px solid #e2e8f0; border-radius: 0.625rem; font-size: 0.8rem;">
            </div>
            <div>
                <label style="display: block; font-size: 0.72rem; font-weight: 600; color: #64748b; margin-bottom: 0.3rem;">{{ __('admin.month') }}</label>
                <input type="month" id="filterMonth" name="month" style="width: 100%; padding: 0.5rem 0.75rem; border: 1.5px solid #e2e8f0; border-radius: 0.625rem; font-size: 0.8rem;">
            </div>
            <div>
                <label style="display: block; font-size: 0.72rem; font-weight: 600; color: #64748b; margin-bottom: 0.3rem;">{{ __('admin.year') }}</label>
                <input type="number" id="filterYear" name="year" min="2000" max="2100" value="{{ now()->year }}" style="width: 100%; padding: 0.5rem 0.75rem; border: 1.5px solid #e2e8f0; border-radius: 0.625rem; font-size: 0.8rem;">
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <button type="button" id="filterBtn" style="flex: 1; padding: 0.5rem 1rem; background: linear-gradient(135deg, #dd208e, #9333ea); color: #fff; border: none; border-radius: 0.625rem; font-size: 0.8rem; font-weight: 600; cursor: pointer;">
                    <span id="filterBtnText">{{ __('admin.show') }}</span>
                    <span id="filterSpinner" class="hidden" style="display: none;">...</span>
                </button>
                <button type="button" id="clearBtn" style="padding: 0.5rem 1rem; background: #f1f5f9; color: #475569; border: none; border-radius: 0.625rem; font-size: 0.8rem; font-weight: 600; cursor: pointer;">{{ __('admin.clear') }}</button>
            </div>
        </div>
    </form>
    <div id="filterResult" class="hidden" style="display: none;">
        <div id="resultBox" style="padding: 1rem; background: linear-gradient(135deg, #f0fdf4, #ecfdf5); border-inline-start: 4px solid #16a34a; border-radius: 0.75rem;">
            <p style="font-size: 0.8rem; color: #334155;">{{ __('admin.total_revenue_for') }} <strong style="color: #16a34a;" id="resultLabel"></strong>:</p>
            <p style="font-size: 1.5rem; font-weight: 800; color: #16a34a; margin-top: 0.25rem;" id="resultAmount">0.00</p>
        </div>
        <div id="chartContainer" class="hidden" style="display: none; margin-top: 1rem;">
            <div style="position: relative; height: 250px;"><canvas id="filteredChart"></canvas></div>
        </div>
    </div>
</div>

{{-- BOOKING LINK --}}
<div class="card-box" style="margin-bottom: 1.5rem;">
    <div class="section-head"><i class="fas fa-link"></i> {{ __('admin.quick_booking_link') }}</div>
    <div style="display: flex; gap: 0.5rem;">
        <input type="text" id="bookingLink" value="{{ url('/book/' . ($salon->name_en ?? '')) }}" readonly
            style="flex: 1; padding: 0.6rem 0.85rem; border: 1.5px solid #e2e8f0; border-radius: 0.625rem; font-size: 0.8rem; color: #334155; background: #f8fafc;" dir="ltr">
        <button type="button" id="copyBtn" style="padding: 0.6rem 1.25rem; background: linear-gradient(135deg, #dd208e, #b01670); color: #fff; border: none; border-radius: 0.625rem; font-size: 0.8rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.4rem;">
            <i class="fas fa-copy"></i> <span id="copyBtnText">{{ __('admin.copy_link') }}</span>
        </button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
let filteredChartInstance = null;
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        // Weekly Revenue Chart
        const weeklyCtx = document.getElementById('weeklyChart');
        if (weeklyCtx) {
            new Chart(weeklyCtx, {
                type: 'line',
                data: {
                    labels: @json($dayLabels),
                    datasets: [{
                        label: '{{ __("admin.weekly_chart_label") }}',
                        data: @json($weeklyRevenue),
                        borderColor: '#dd208e',
                        backgroundColor: 'rgba(221, 32, 142, 0.08)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#dd208e',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } } }
            });
        }
        // Monthly Revenue Chart
        const monthlyCtx = document.getElementById('monthlyChart');
        if (monthlyCtx) {
            new Chart(monthlyCtx, {
                type: 'bar',
                data: {
                    labels: @json($monthLabels),
                    datasets: [{
                        label: '{{ __("admin.monthly_chart_label") }}',
                        data: @json($monthlyData),
                        backgroundColor: 'rgba(221, 32, 142, 0.15)',
                        borderColor: '#dd208e',
                        borderWidth: 2,
                        borderRadius: 8,
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } } }
            });
        }
    }, 100);

    // Filter functionality
    document.getElementById('filterBtn').addEventListener('click', function() {
        const date = document.getElementById('filterDate').value;
        const month = document.getElementById('filterMonth').value;
        const year = document.getElementById('filterYear').value;
        if (!date && !month && !year) { alert('Please select at least one filter'); return; }
        const btn = this, btnText = document.getElementById('filterBtnText'), spinner = document.getElementById('filterSpinner');
        btn.disabled = true; btnText.style.display = 'none'; spinner.style.display = 'inline';
        const params = new URLSearchParams();
        if (date) params.append('date', date);
        if (month) params.append('month', month);
        if (year) params.append('year', year);
        fetch('{{ route("admin.filter-revenue") }}?' + params, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.json())
        .then(data => {
            const result = document.getElementById('filterResult');
            result.classList.remove('hidden'); result.style.display = 'block';
            document.getElementById('resultLabel').textContent = data.filterLabel || '';
            document.getElementById('resultAmount').textContent = parseFloat(data.filteredRevenue || 0).toFixed(2);
            if (data.filteredChartData && data.filteredChartData.length > 0) {
                const cc = document.getElementById('chartContainer');
                cc.classList.remove('hidden'); cc.style.display = 'block';
                if (filteredChartInstance) filteredChartInstance.destroy();
                filteredChartInstance = new Chart(document.getElementById('filteredChart'), {
                    type: 'line',
                    data: {
                        labels: data.filteredChartLabels,
                        datasets: [{ label: '{{ __("admin.daily_revenue") }}', data: data.filteredChartData, borderColor: '#16a34a', backgroundColor: 'rgba(22,163,106,0.1)', borderWidth: 2, fill: true, tension: 0.4, pointRadius: 3 }]
                    },
                    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } } }
                });
            } else { document.getElementById('chartContainer').style.display = 'none'; }
        })
        .catch(e => { console.error(e); alert('Error fetching data.'); })
        .finally(() => { btn.disabled = false; btnText.style.display = 'inline'; spinner.style.display = 'none'; });
    });

    document.getElementById('clearBtn').addEventListener('click', function() {
        document.getElementById('filterDate').value = '';
        document.getElementById('filterMonth').value = '';
        document.getElementById('filterYear').value = '{{ now()->year }}';
        document.getElementById('filterResult').style.display = 'none';
        if (filteredChartInstance) { filteredChartInstance.destroy(); filteredChartInstance = null; }
    });

    // Copy link
    document.getElementById('copyBtn').addEventListener('click', function() {
        const link = document.getElementById('bookingLink').value;
        const btnText = document.getElementById('copyBtnText');
        navigator.clipboard.writeText(link).then(() => {
            const orig = btnText.textContent;
            btnText.textContent = '{{ __("admin.copied") }} ✓';
            setTimeout(() => { btnText.textContent = orig; }, 2000);
        });
    });
});
</script>
@endsection
