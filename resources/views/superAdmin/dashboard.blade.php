@extends('superAdmin.layout.app')

@section('page-title', 'لوحة التحكم الرئيسية')

@section('content')

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Salons -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">إجمالي الصالونات</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalSalons }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-full">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Products -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">إجمالي المنتجات</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalProducts }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-full">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Bookings -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">إجمالي الحجوزات</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalBookings }}</p>
            </div>
            <div class="p-3 bg-purple-100 rounded-full">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">إجمالي الإيرادات</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalRevenue, 2) }}</p>
            </div>
            <div class="p-3 bg-orange-100 rounded-full">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Booking Status Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg shadow-md p-6 border-l-4 border-green-600">
        <p class="text-gray-600 text-sm font-medium">الحجوزات المكتملة</p>
        <p class="text-2xl font-bold text-green-700 mt-2">{{ $completedBookings }}</p>
    </div>
    <div class="bg-gradient-to-br from-yellow-50 to-amber-50 rounded-lg shadow-md p-6 border-l-4 border-yellow-600">
        <p class="text-gray-600 text-sm font-medium">الحجوزات المعلقة</p>
        <p class="text-2xl font-bold text-yellow-700 mt-2">{{ $pendingBookings }}</p>
    </div>
    <div class="bg-gradient-to-br from-red-50 to-rose-50 rounded-lg shadow-md p-6 border-l-4 border-red-600">
        <p class="text-gray-600 text-sm font-medium">الحجوزات الملغاة</p>
        <p class="text-2xl font-bold text-red-700 mt-2">{{ $cancelledBookings }}</p>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Monthly Revenue Chart -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">الإيرادات الشهرية</h3>
        <div style="position: relative; height: 300px;">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Booking Status Chart -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">حالة الحجوزات</h3>
        <div style="position: relative; height: 300px;">
            <canvas id="bookingStatusChart"></canvas>
        </div>
    </div>
</div>

<!-- Recent Bookings -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4">الحجوزات الأخيرة</h3>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">الصالون</th>
                    <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">العميل</th>
                    <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">الخدمة</th>
                    <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">الموعد</th>
                    <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">الحالة</th>
                    <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">الإجراء</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentBookings as $booking)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $booking->salon->name_ar }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $booking->client->name ?? 'غير محدد' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $booking->service->name_ar ?? 'غير محدد' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $booking->appointment_datetime->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($booking->status === 'completed') bg-green-100 text-green-700
                                @elseif($booking->status === 'scheduled') bg-blue-100 text-blue-700
                                @else bg-red-100 text-red-700 @endif">
                                @switch($booking->status)
                                    @case('completed') مكتملة @break
                                    @case('scheduled') مجدولة @break
                                    @default ملغاة @endswitch
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <a href="{{ route('superAdmin.bookings.show', $booking->id) }}" class="text-blue-600 hover:text-blue-700 font-medium">عرض</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">لا توجد حجوزات حديثة</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Monthly Revenue Chart
        const revenueCtx = document.getElementById('revenueChart');
        if (revenueCtx) {
            new Chart(revenueCtx, {
                type: 'bar',
                data: {
                    labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
                    datasets: [{
                        label: 'الإيرادات',
                        data: @json(array_values($monthlyRevenue)),
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1,
                        borderRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }

        // Booking Status Chart
        const statusCtx = document.getElementById('bookingStatusChart');
        if (statusCtx) {
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['مكتملة', 'مجدولة', 'ملغاة'],
                    datasets: [{
                        data: [{{ $completedBookings }}, {{ $pendingBookings }}, {{ $cancelledBookings }}],
                        backgroundColor: [
                            'rgba(34, 197, 94, 0.8)',
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(239, 68, 68, 0.8)',
                        ],
                        borderColor: [
                            'rgba(34, 197, 94, 1)',
                            'rgba(59, 130, 246, 1)',
                            'rgba(239, 68, 68, 1)',
                        ],
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { font: { size: 12 } }
                        }
                    }
                }
            });
        }
    });
</script>

@endsection
