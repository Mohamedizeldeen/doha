@extends('admin.layout.app')

@section('page-title', 'لوحة التحكم')

@section('content')
<!-- Welcome Section -->

     
    <div class="card p-4 mb-6" style="background: white; border-radius: 12px; box-shadow: 0 8px 32px rgba(0,0,0,0.05);">
        <h5 class="mb-4" style="font-weight: 600; font-size: 18px; color: #333;">إيرادات هذا الاسبوع</h5>
        <canvas id="revenueChart" style="width: 100%; height: 300px;"></canvas>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
        <div class="card p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <h5 class="text-gray-600 text-sm font-medium">الحجوزات الكلية</h5>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalBookings }}</h3>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="card p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <h5 class="text-gray-600 text-sm font-medium">الحجوزات المكتملة</h5>
                    <h3 class="text-2xl font-bold text-green-600">{{ $confirmedBookings }}</h3>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="card p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <h5 class="text-gray-600 text-sm font-medium">الحجوزات المجدولة</h5>
                    <h3 class="text-2xl font-bold text-yellow-600">{{ $pendingBookings }}</h3>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="card p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <h5 class="text-gray-600 text-sm font-medium">الحجوزات الملغاة</h5>
                    <h3 class="text-2xl font-bold text-red-600">{{ $cancelledBookings }}</h3>
                </div>
                <div class="p-3 bg-red-100 rounded-full">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
        <div class="card p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <h5 class="text-gray-600 text-sm font-medium">إجمالي العملاء</h5>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalClients }}</h3>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 12H9m6 0H9m6 0H9m0 5.646a4 4 0 110-5.292M9 12h6"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="card p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <h5 class="text-gray-600 text-sm font-medium">إجمالي الخدمات</h5>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalServices }}</h3>
                </div>
                <div class="p-3 bg-indigo-100 rounded-full">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="card p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <h5 class="text-gray-600 text-sm font-medium">إجمالي الموظفين</h5>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalStaff }}</h3>
                </div>
                <div class="p-3 bg-pink-100 rounded-full">
                    <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="card p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <h5 class="text-gray-600 text-sm font-medium">إجمالي المنتجات</h5>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalProducts }}</h3>
                </div>
                <div class="p-3 bg-orange-100 rounded-full">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- #copy link of booking -->
    <div class="card p-6 mt-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300" style="border-radius: 12px;">
        <div class="flex items-center mb-4">
            <div class="p-2 bg-blue-100 rounded-full ml-3">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                </svg>
            </div>
            <h5 class="text-lg font-semibold text-gray-900">رابط الحجز السريع</h5>
        </div>
        <div class="flex">
            <input  type="text" class="flex-1 px-4 py-2 border border-gray-300 rounded-r-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ url('/book/' . ($salon->name_en ?? '')) }}" readonly>
            <button class="px-6 py-2 bg-blue-600 text-white rounded-l-lg hover:bg-blue-700 transition-colors duration-300 flex items-center" onclick="navigator.clipboard.writeText('{{ url('/book/' . ($salon->name_en ?? '')) }}')">
            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
            </svg>
            نسخ الرابط
            </button>
        </div>
    </div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Modern Revenue Chart with minimal styling
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($dayLabels),
            datasets: [{
                label: 'الإيرادات',
                data: @json($weeklyRevenue),
                borderColor: 'rgba(0,0,0,0.2)',
                backgroundColor: 'rgba(0,0,0,0.02)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgba(0,0,0,0.8)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgba(255,255,255,0.2)',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y.toLocaleString('ar-SA') + ' ريال';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        callback: function(value) {
                            return (value / 1000).toLocaleString('ar-SA') + 'k';
                        },
                        color: 'rgba(0,0,0,0.5)',
                        font: {
                            weight: '600',
                            size: 12
                        }
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        color: 'rgba(0,0,0,0.5)',
                        font: {
                            weight: '600',
                            size: 12
                        }
                    }
                }
            }
        }
    });
</script>

<style>
    body {
        background: linear-gradient(135deg, #f5f5f5 0%, #fafafa 100%);
    }

    .card:hover {
        box-shadow: 0 16px 64px rgba(0,0,0,0.08) !important;
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }

    a.card:hover {
        border-color: rgba(0,0,0,0.1) !important;
    }

    table tr:hover {
        background: rgba(0,0,0,0.02);
    }
</style>
@endsection
