@extends('admin.layout.app')

@section('page-title', __('admin.bookings'))

@section('content')
<style>
    .cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; }
    .cal-header-cell { padding: 0.75rem 0.5rem; text-align: center; font-weight: 700; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; background: #f8fafc; border-radius: 0.5rem; }
    .cal-cell { min-height: 110px; background: #fff; border-radius: 0.75rem; padding: 0.5rem; cursor: pointer; transition: all 0.25s ease; border: 2px solid transparent; position: relative; }
    .cal-cell:hover { border-color: var(--primary); box-shadow: 0 4px 15px rgba(221,32,142,0.12); transform: translateY(-1px); }
    .cal-cell.today { background: linear-gradient(135deg, #fdf2f8, #fce7f3); border-color: var(--primary); }
    .cal-cell.other-month { opacity: 0.35; pointer-events: none; }
    .cal-cell.selected { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(221,32,142,0.15); }
    .cal-day-num { font-size: 0.85rem; font-weight: 700; color: #1e293b; margin-bottom: 0.35rem; }
    .cal-cell.today .cal-day-num { color: var(--primary); }
    .cal-dot { display: inline-block; width: 7px; height: 7px; border-radius: 50%; margin: 1px; }
    .cal-dot.scheduled { background: #3b82f6; }
    .cal-dot.completed { background: #22c55e; }
    .cal-dot.cancelled, .cal-dot.canceled { background: #ef4444; }
    .cal-booking-mini { font-size: 0.65rem; padding: 2px 6px; border-radius: 4px; margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; cursor: pointer; transition: all 0.2s; }
    .cal-booking-mini:hover { transform: scale(1.02); }
    .cal-booking-mini.scheduled { background: #dbeafe; color: #1d4ed8; }
    .cal-booking-mini.completed { background: #dcfce7; color: #166534; }
    .cal-booking-mini.cancelled, .cal-booking-mini.canceled { background: #fee2e2; color: #991b1b; }
    .cal-more { font-size: 0.65rem; color: var(--primary); font-weight: 600; cursor: pointer; margin-top: 2px; }
    .view-btn { padding: 0.5rem 1rem; border-radius: 0.75rem; font-size: 0.8rem; font-weight: 600; border: 1.5px solid #e2e8f0; background: #fff; color: #64748b; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.4rem; }
    .view-btn:hover { border-color: var(--primary); color: var(--primary); }
    .view-btn.active { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: #fff; border-color: transparent; box-shadow: 0 4px 12px rgba(221,32,142,0.3); }
    .booking-panel { position: fixed; top: 0; {{ app()->getLocale() === 'ar' ? 'left' : 'right' }}: 0; width: 420px; max-width: 90vw; height: 100vh; background: #fff; z-index: 100; box-shadow: -8px 0 30px rgba(0,0,0,0.12); transform: translateX({{ app()->getLocale() === 'ar' ? '-110%' : '110%' }}); transition: transform 0.35s cubic-bezier(0.4,0,0.2,1); overflow-y: auto; }
    .booking-panel.open { transform: translateX(0); }
    .panel-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.3); backdrop-filter: blur(4px); z-index: 99; opacity: 0; pointer-events: none; transition: opacity 0.3s; }
    .panel-overlay.open { opacity: 1; pointer-events: all; }
    .stat-card { background: #fff; border-radius: 1rem; padding: 1.25rem; border: 1px solid rgba(0,0,0,0.04); box-shadow: 0 1px 3px rgba(0,0,0,0.04); transition: all 0.3s; }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.08); }
    .list-booking-row { background: #fff; border-radius: 0.75rem; padding: 1rem 1.25rem; margin-bottom: 0.5rem; border: 1px solid rgba(0,0,0,0.04); transition: all 0.25s; cursor: pointer; }
    .list-booking-row:hover { border-color: var(--primary); box-shadow: 0 4px 15px rgba(221,32,142,0.08); transform: translateY(-1px); }
    .status-badge { padding: 0.25rem 0.75rem; border-radius: 2rem; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.03em; }
    .status-badge.scheduled { background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #1e40af; }
    .status-badge.completed { background: linear-gradient(135deg, #dcfce7, #bbf7d0); color: #166534; }
    .status-badge.cancelled, .status-badge.canceled { background: linear-gradient(135deg, #fee2e2, #fecaca); color: #991b1b; }
    .nav-arrow { width: 38px; height: 38px; border-radius: 0.75rem; border: 1.5px solid #e2e8f0; background: #fff; color: #64748b; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s; font-size: 0.9rem; }
    .nav-arrow:hover { border-color: var(--primary); color: var(--primary); background: #fdf2f8; }
    @media (max-width: 768px) {
        .cal-cell { min-height: 70px; padding: 0.25rem; }
        .cal-booking-mini { display: none; }
        .cal-header-cell { font-size: 0.6rem; padding: 0.5rem 0.25rem; }
        .cal-day-num { font-size: 0.75rem; }
    }
</style>

{{-- Stats Row --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 animate-fade-in">
    @php
        $totalBookings = $bookings->count();
        $scheduledCount = $bookings->where('status', 'scheduled')->count();
        $completedCount = $bookings->where('status', 'completed')->count();
        $cancelledCount = $bookings->whereIn('status', ['cancelled', 'canceled'])->count();
    @endphp
    <div class="stat-card">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center">
                <i class="fas fa-calendar-check text-white text-sm"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-semibold">{{ __('admin.total_bookings') }}</p>
                <p class="text-xl font-bold text-gray-900">{{ $totalBookings }}</p>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                <i class="fas fa-clock text-white text-sm"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-semibold">{{ __('admin.pending') }}</p>
                <p class="text-xl font-bold text-gray-900">{{ $scheduledCount }}</p>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center">
                <i class="fas fa-check-circle text-white text-sm"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-semibold">{{ __('admin.completed') }}</p>
                <p class="text-xl font-bold text-gray-900">{{ $completedCount }}</p>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center">
                <i class="fas fa-times-circle text-white text-sm"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-semibold">{{ __('admin.cancelled') }}</p>
                <p class="text-xl font-bold text-gray-900">{{ $cancelledCount }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Toolbar --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-5 animate-fade-in" style="animation-delay: 0.1s">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-2">
            <button class="nav-arrow" onclick="calPrev()"><i class="fas fa-chevron-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i></button>
            <h2 class="text-lg md:text-xl font-bold text-gray-900 min-w-[180px] text-center" id="calTitle"></h2>
            <button class="nav-arrow" onclick="calNext()"><i class="fas fa-chevron-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}"></i></button>
            <button class="view-btn ms-2" onclick="calToday()"><i class="fas fa-crosshairs"></i> {{ __('admin.today') ?? 'Today' }}</button>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            {{-- View Toggles --}}
            <div class="flex items-center gap-1 bg-gray-50 rounded-xl p-1">
                <button class="view-btn active" data-view="month" onclick="setView('month')"><i class="fas fa-calendar-alt"></i> {{ __('admin.month') }}</button>
                <button class="view-btn" data-view="list" onclick="setView('list')"><i class="fas fa-list-ul"></i> {{ __('admin.list') ?? 'List' }}</button>
            </div>
            {{-- Filter --}}
            <select id="calStatusFilter" class="view-btn" onchange="applyCalFilter()" style="cursor:pointer;">
                <option value="">{{ __('admin.all_statuses') }}</option>
                <option value="scheduled">{{ __('admin.pending') }}</option>
                <option value="completed">{{ __('admin.completed') }}</option>
                <option value="cancelled">{{ __('admin.cancelled') }}</option>
            </select>
            {{-- Search --}}
            <div class="relative">
                <i class="fas fa-search absolute top-1/2 -translate-y-1/2 {{ app()->getLocale() === 'ar' ? 'right-3' : 'left-3' }} text-gray-400 text-xs"></i>
                <input type="text" id="calSearch" placeholder="{{ __('admin.search') }}..." 
                    class="view-btn {{ app()->getLocale() === 'ar' ? 'pr-8' : 'pl-8' }}" style="min-width: 160px;" oninput="applyCalFilter()">
            </div>
            {{-- New Booking --}}
            <a href="{{ route('booking.create', $salon) }}" class="view-btn active" style="text-decoration:none;">
                <i class="fas fa-plus"></i> {{ __('admin.new_booking') }}
            </a>
        </div>
    </div>
</div>

{{-- Calendar View --}}
<div id="calendarView" class="animate-fade-in" style="animation-delay: 0.2s">
    {{-- Day Headers --}}
    <div class="cal-grid mb-2" id="calDayHeaders"></div>
    {{-- Calendar Grid --}}
    <div class="cal-grid" id="calGrid"></div>
</div>

{{-- List View (hidden by default) --}}
<div id="listView" class="animate-fade-in" style="display: none;">
    <div id="listContainer"></div>
</div>

{{-- Booking Detail Panel --}}
<div class="panel-overlay" id="panelOverlay" onclick="closePanel()"></div>
<div class="booking-panel" id="bookingPanel">
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900" id="panelTitle">{{ __('admin.booking_details') }}</h3>
            <button onclick="closePanel()" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-red-50 hover:text-red-500 transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="panelContent"></div>
    </div>
</div>

{{-- Day Detail Panel --}}
<div class="panel-overlay" id="dayPanelOverlay" onclick="closeDayPanel()"></div>
<div class="booking-panel" id="dayPanel">
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900" id="dayPanelTitle"></h3>
            <button onclick="closeDayPanel()" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-red-50 hover:text-red-500 transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="dayPanelContent"></div>
    </div>
</div>

@php
$bookingsJsonData = $bookings->map(function($b) use ($salon) {
    $locale = app()->getLocale();
    return [
        'id' => $b->id,
        'client' => $locale === 'ar' ? $b->client->name_ar : ($b->client->name_en ?? $b->client->name_ar),
        'client_phone' => $b->client->phone,
        'service' => $locale === 'ar' ? $b->service->name_ar : ($b->service->name_en ?? $b->service->name_ar),
        'staff' => $b->staff ? ($locale === 'ar' ? $b->staff->name_ar : ($b->staff->name_en ?? $b->staff->name_ar)) : ($locale === 'ar' ? 'غير محدد' : 'Unassigned'),
        'datetime' => $b->appointment_datetime->format('Y-m-d H:i'),
        'date' => $b->appointment_datetime->format('Y-m-d'),
        'time' => $b->appointment_datetime->format('H:i'),
        'status' => $b->status,
        'price' => $b->service->price,
        'currency' => $salon->currency,
        'notes' => $b->notes,
        'whatsapp_reminded' => $b->whatsapp_reminded,
        'show_url' => route('booking.show', [$salon, $b]),
        'edit_url' => route('booking.edit', [$salon, $b]),
        'delete_url' => route('booking.destroy', [$salon, $b]),
        'whatsapp_url' => 'https://wa.me/' . preg_replace('/[^0-9]/', '', $b->client->phone) . '?text=' . urlencode(__('admin.whatsapp_reminder_text', ['salon' => ($locale === 'ar' ? $salon->name_ar : ($salon->name_en ?? $salon->name_ar)), 'date' => $b->appointment_datetime->format('Y-m-d'), 'time' => $b->appointment_datetime->format('H:i')])),
        'whatsapp_toggle_url' => route('booking.whatsapp.toggle', [$salon, $b]),
    ];
})->values();
@endphp

<script>
// Booking data from server
const bookingsData = @json($bookingsJsonData);

const salonId = {{ $salon->id }};
const csrfToken = '{{ csrf_token() }}';
const locale = '{{ app()->getLocale() }}';
const translations = {
    pending: '{{ __("admin.pending") }}',
    completed: '{{ __("admin.completed") }}',
    cancelled: '{{ __("admin.cancelled") }}',
    view: '{{ __("admin.view") }}',
    edit: '{{ __("admin.edit") }}',
    delete: '{{ __("admin.delete") }}',
    confirm_delete: '{{ __("admin.confirm_delete") }}',
    no_data: '{{ __("admin.no_data") }}',
    client: '{{ __("admin.client") }}',
    service: '{{ __("admin.service") }}',
    staff_member: '{{ __("admin.staff_member") }}',
    date: '{{ __("admin.date") }}',
    time: '{{ __("admin.time") }}',
    status: '{{ __("admin.status") }}',
    price: '{{ __("admin.price") }}',
    notes: '{{ __("admin.notes") }}',
    reminded: '{{ __("admin.reminded") }}',
    not_reminded: '{{ __("admin.not_reminded") }}',
    booking_details: '{{ __("admin.booking_details") }}',
    bookings_for: '{{ __("admin.bookings") }}',
};

const dayNamesAr = ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'];
const dayNamesEn = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
const monthNamesAr = ['يناير','فبراير','مارس','أبريل','مايو','يونيو','يوليو','أغسطس','سبتمبر','أكتوبر','نوفمبر','ديسمبر'];
const monthNamesEn = ['January','February','March','April','May','June','July','August','September','October','November','December'];
const dayNames = locale === 'ar' ? dayNamesAr : dayNamesEn;
const monthNames = locale === 'ar' ? monthNamesAr : monthNamesEn;

let currentDate = new Date();
let currentView = 'month';
let filteredBookings = [...bookingsData];

function getStatusLabel(status) {
    if (status === 'scheduled') return translations.pending;
    if (status === 'completed') return translations.completed;
    return translations.cancelled;
}

function applyCalFilter() {
    const search = document.getElementById('calSearch').value.toLowerCase();
    const status = document.getElementById('calStatusFilter').value;
    filteredBookings = bookingsData.filter(b => {
        const matchStatus = !status || b.status === status || (status === 'cancelled' && b.status === 'canceled');
        const matchSearch = !search || b.client.toLowerCase().includes(search) || b.client_phone.includes(search) || b.service.toLowerCase().includes(search) || b.staff.toLowerCase().includes(search);
        return matchStatus && matchSearch;
    });
    render();
}

function renderDayHeaders() {
    const el = document.getElementById('calDayHeaders');
    const startDay = locale === 'ar' ? 6 : 0;
    let html = '';
    for (let i = 0; i < 7; i++) {
        const idx = (startDay + i) % 7;
        html += `<div class="cal-header-cell">${dayNames[idx]}</div>`;
    }
    el.innerHTML = html;
}

function renderCalendar() {
    const grid = document.getElementById('calGrid');
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    const today = new Date();

    document.getElementById('calTitle').textContent = `${monthNames[month]} ${year}`;

    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const startDay = locale === 'ar' ? 6 : 0;
    let startOffset = (firstDay.getDay() - startDay + 7) % 7;

    const bookingMap = {};
    filteredBookings.forEach(b => {
        if (!bookingMap[b.date]) bookingMap[b.date] = [];
        bookingMap[b.date].push(b);
    });

    let html = '';

    const prevLast = new Date(year, month, 0).getDate();
    for (let i = startOffset - 1; i >= 0; i--) {
        const d = prevLast - i;
        html += `<div class="cal-cell other-month"><div class="cal-day-num">${d}</div></div>`;
    }

    for (let d = 1; d <= lastDay.getDate(); d++) {
        const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
        const isToday = today.getFullYear() === year && today.getMonth() === month && today.getDate() === d;
        const dayBookings = bookingMap[dateStr] || [];
        const maxShow = 3;

        html += `<div class="cal-cell ${isToday ? 'today' : ''}" onclick="openDayPanel('${dateStr}')">`;
        html += `<div class="cal-day-num">${d}</div>`;

        if (dayBookings.length > 0) {
            html += `<div class="flex flex-wrap gap-0.5 mb-1">`;
            dayBookings.forEach(b => {
                const sc = b.status === 'scheduled' ? 'scheduled' : (b.status === 'completed' ? 'completed' : 'cancelled');
                html += `<span class="cal-dot ${sc}"></span>`;
            });
            html += `</div>`;

            dayBookings.slice(0, maxShow).forEach(b => {
                const sc = b.status === 'scheduled' ? 'scheduled' : (b.status === 'completed' ? 'completed' : 'cancelled');
                html += `<div class="cal-booking-mini ${sc}" onclick="event.stopPropagation(); openBookingPanel(${b.id})" title="${b.client} - ${b.time}">
                    <span class="font-bold">${b.time}</span> ${b.client}
                </div>`;
            });

            if (dayBookings.length > maxShow) {
                html += `<div class="cal-more">+${dayBookings.length - maxShow} {{ __('admin.show') }}</div>`;
            }
        }
        html += `</div>`;
    }

    const totalCells = startOffset + lastDay.getDate();
    const remaining = (7 - (totalCells % 7)) % 7;
    for (let i = 1; i <= remaining; i++) {
        html += `<div class="cal-cell other-month"><div class="cal-day-num">${i}</div></div>`;
    }

    grid.innerHTML = html;
}

function renderList() {
    const container = document.getElementById('listContainer');
    const sorted = [...filteredBookings].sort((a, b) => new Date(b.datetime) - new Date(a.datetime));

    if (sorted.length === 0) {
        container.innerHTML = `<div class="bg-white rounded-xl p-12 text-center border border-gray-100">
            <i class="fas fa-calendar-times text-4xl text-gray-300 mb-4"></i>
            <p class="text-gray-400 text-lg">${translations.no_data}</p>
        </div>`;
        return;
    }

    const groups = {};
    sorted.forEach(b => {
        if (!groups[b.date]) groups[b.date] = [];
        groups[b.date].push(b);
    });

    let html = '';
    Object.keys(groups).sort((a, b) => new Date(b) - new Date(a)).forEach(date => {
        const d = new Date(date);
        const dayLabel = locale === 'ar' ? dayNamesAr[d.getDay()] : dayNamesEn[d.getDay()];
        html += `<div class="mb-6">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-500 to-pink-600 flex items-center justify-center text-white font-bold text-sm">${d.getDate()}</div>
                <div>
                    <p class="font-bold text-gray-900 text-sm">${dayLabel}</p>
                    <p class="text-xs text-gray-400">${date}</p>
                </div>
                <span class="ms-auto bg-gray-100 text-gray-600 px-2.5 py-0.5 rounded-full text-xs font-bold">${groups[date].length}</span>
            </div>`;

        groups[date].forEach(b => {
            const sc = b.status === 'scheduled' ? 'scheduled' : (b.status === 'completed' ? 'completed' : 'cancelled');
            html += `<div class="list-booking-row" onclick="openBookingPanel(${b.id})">
                <div class="flex items-center gap-4 flex-wrap">
                    <div class="flex items-center gap-3 min-w-[140px]">
                        <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 font-bold text-xs">${b.time}</div>
                        <div>
                            <p class="font-bold text-gray-900 text-sm">${b.client}</p>
                            <p class="text-xs text-gray-400">${b.client_phone}</p>
                        </div>
                    </div>
                    <div class="min-w-[100px]">
                        <p class="text-xs text-gray-400">${translations.service}</p>
                        <p class="font-semibold text-gray-700 text-sm">${b.service}</p>
                    </div>
                    <div class="min-w-[80px]">
                        <p class="text-xs text-gray-400">${translations.staff_member}</p>
                        <p class="font-semibold text-gray-700 text-sm">${b.staff}</p>
                    </div>
                    <div class="min-w-[60px]">
                        <p class="text-xs text-gray-400">${translations.price}</p>
                        <p class="font-semibold text-gray-700 text-sm">${b.price} ${b.currency}</p>
                    </div>
                    <span class="status-badge ${sc} ms-auto">${getStatusLabel(b.status)}</span>
                </div>
            </div>`;
        });
        html += `</div>`;
    });

    container.innerHTML = html;
}

function openDayPanel(dateStr) {
    const dayBookings = filteredBookings.filter(b => b.date === dateStr);
    const d = new Date(dateStr);
    const dayLabel = locale === 'ar' ? dayNamesAr[d.getDay()] : dayNamesEn[d.getDay()];

    document.getElementById('dayPanelTitle').textContent = `${dayLabel} - ${dateStr}`;

    let html = '';
    if (dayBookings.length === 0) {
        html = `<div class="text-center py-8">
            <i class="fas fa-calendar-day text-3xl text-gray-300 mb-3"></i>
            <p class="text-gray-400">${translations.no_data}</p>
        </div>`;
    } else {
        dayBookings.sort((a, b) => a.time.localeCompare(b.time)).forEach(b => {
            const sc = b.status === 'scheduled' ? 'scheduled' : (b.status === 'completed' ? 'completed' : 'cancelled');
            html += `<div class="bg-gray-50 rounded-xl p-4 mb-3 cursor-pointer hover:bg-gray-100 transition" onclick="closeDayPanel(); setTimeout(()=>openBookingPanel(${b.id}), 350);">
                <div class="flex items-center justify-between mb-2">
                    <span class="font-bold text-gray-900">${b.time}</span>
                    <span class="status-badge ${sc}">${getStatusLabel(b.status)}</span>
                </div>
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <div>
                        <p class="text-gray-400 text-xs">${translations.client}</p>
                        <p class="font-semibold text-gray-800">${b.client}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs">${translations.service}</p>
                        <p class="font-semibold text-gray-800">${b.service}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs">${translations.staff_member}</p>
                        <p class="font-semibold text-gray-800">${b.staff}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs">${translations.price}</p>
                        <p class="font-semibold text-gray-800">${b.price} ${b.currency}</p>
                    </div>
                </div>
            </div>`;
        });
    }

    document.getElementById('dayPanelContent').innerHTML = html;
    document.getElementById('dayPanel').classList.add('open');
    document.getElementById('dayPanelOverlay').classList.add('open');
}

function closeDayPanel() {
    document.getElementById('dayPanel').classList.remove('open');
    document.getElementById('dayPanelOverlay').classList.remove('open');
}

function openBookingPanel(id) {
    const b = bookingsData.find(x => x.id === id);
    if (!b) return;

    document.getElementById('panelTitle').textContent = translations.booking_details;

    const sc = b.status === 'scheduled' ? 'scheduled' : (b.status === 'completed' ? 'completed' : 'cancelled');
    const remindedClass = b.whatsapp_reminded ? 'bg-green-100 text-green-700 border-green-300' : 'bg-gray-100 text-gray-500 border-gray-200';
    const remindedIcon = b.whatsapp_reminded ? 'fa-check-circle' : 'fa-circle';
    const remindedText = b.whatsapp_reminded ? translations.reminded : translations.not_reminded;

    let html = `
        <div class="text-center mb-6">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-pink-500 to-pink-600 flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-calendar-check text-white text-2xl"></i>
            </div>
            <h4 class="font-bold text-gray-900 text-lg">${b.client}</h4>
            <p class="text-gray-400 text-sm ltr">${b.client_phone}</p>
            <span class="status-badge ${sc} mt-2 inline-block">${getStatusLabel(b.status)}</span>
        </div>

        <div class="space-y-3 mb-6">
            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                <i class="fas fa-spa text-pink-500 w-5 text-center"></i>
                <div>
                    <p class="text-xs text-gray-400">${translations.service}</p>
                    <p class="font-semibold text-gray-800 text-sm">${b.service}</p>
                </div>
            </div>
            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                <i class="fas fa-user text-blue-500 w-5 text-center"></i>
                <div>
                    <p class="text-xs text-gray-400">${translations.staff_member}</p>
                    <p class="font-semibold text-gray-800 text-sm">${b.staff}</p>
                </div>
            </div>
            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                <i class="fas fa-calendar text-purple-500 w-5 text-center"></i>
                <div>
                    <p class="text-xs text-gray-400">${translations.date}</p>
                    <p class="font-semibold text-gray-800 text-sm">${b.date}</p>
                </div>
            </div>
            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                <i class="fas fa-clock text-indigo-500 w-5 text-center"></i>
                <div>
                    <p class="text-xs text-gray-400">${translations.time}</p>
                    <p class="font-semibold text-gray-800 text-sm">${b.time}</p>
                </div>
            </div>
            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                <i class="fas fa-tag text-green-500 w-5 text-center"></i>
                <div>
                    <p class="text-xs text-gray-400">${translations.price}</p>
                    <p class="font-semibold text-gray-800 text-sm">${b.price} ${b.currency}</p>
                </div>
            </div>
            ${b.notes ? `<div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                <i class="fas fa-sticky-note text-yellow-500 w-5 text-center mt-0.5"></i>
                <div>
                    <p class="text-xs text-gray-400">${translations.notes}</p>
                    <p class="font-semibold text-gray-800 text-sm">${b.notes}</p>
                </div>
            </div>` : ''}
        </div>

        <div class="space-y-2">
            ${b.client_phone ? `<a href="${b.whatsapp_url}" target="_blank" class="flex items-center justify-center gap-2 w-full py-2.5 bg-green-500 hover:bg-green-600 text-white rounded-xl font-semibold text-sm transition">
                <i class="fab fa-whatsapp text-lg"></i> WhatsApp
            </a>` : ''}
            <form action="${b.whatsapp_toggle_url}" method="POST" class="w-full">
                <input type="hidden" name="_token" value="${csrfToken}">
                <input type="hidden" name="_method" value="PATCH">
                <button type="submit" class="flex items-center justify-center gap-2 w-full py-2.5 ${remindedClass} border rounded-xl font-semibold text-sm transition">
                    <i class="fas ${remindedIcon}"></i> ${remindedText}
                </button>
            </form>
            <div class="grid grid-cols-2 gap-2">
                <a href="${b.show_url}" class="flex items-center justify-center gap-2 py-2.5 bg-blue-500 hover:bg-blue-600 text-white rounded-xl font-semibold text-sm transition">
                    <i class="fas fa-eye"></i> ${translations.view}
                </a>
                <a href="${b.edit_url}" class="flex items-center justify-center gap-2 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl font-semibold text-sm transition">
                    <i class="fas fa-edit"></i> ${translations.edit}
                </a>
            </div>
            <form action="${b.delete_url}" method="POST" onsubmit="return confirm('${translations.confirm_delete}')">
                <input type="hidden" name="_token" value="${csrfToken}">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="flex items-center justify-center gap-2 w-full py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-xl font-semibold text-sm transition">
                    <i class="fas fa-trash"></i> ${translations.delete}
                </button>
            </form>
        </div>`;

    document.getElementById('panelContent').innerHTML = html;
    document.getElementById('bookingPanel').classList.add('open');
    document.getElementById('panelOverlay').classList.add('open');
}

function closePanel() {
    document.getElementById('bookingPanel').classList.remove('open');
    document.getElementById('panelOverlay').classList.remove('open');
}

function calPrev() { currentDate.setMonth(currentDate.getMonth() - 1); render(); }
function calNext() { currentDate.setMonth(currentDate.getMonth() + 1); render(); }
function calToday() { currentDate = new Date(); render(); }

function setView(view) {
    currentView = view;
    document.querySelectorAll('[data-view]').forEach(btn => btn.classList.remove('active'));
    document.querySelector(`[data-view="${view}"]`).classList.add('active');
    render();
}

function render() {
    if (currentView === 'month') {
        document.getElementById('calendarView').style.display = '';
        document.getElementById('listView').style.display = 'none';
        renderCalendar();
    } else {
        document.getElementById('calendarView').style.display = 'none';
        document.getElementById('listView').style.display = '';
        renderList();
    }
}

renderDayHeaders();
render();

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { closePanel(); closeDayPanel(); }
});
</script>
@endsection
