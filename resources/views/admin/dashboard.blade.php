@extends('admin.layout.app')

@section('page-title', 'لوحة التحكم')

@section('content')
<!-- Welcome Section -->

     
    <!-- Revenue Overview Cards -->
    <div class="card p-6 mb-6 bg-[#a73b6a]" style=" border-radius: 12px; box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
        <h5 class="mb-6" style="font-weight: 700; font-size: 22px; color: white;">📊 ملخص الإيرادات</h5>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="p-6 bg-white/20 backdrop-blur-sm rounded-lg border border-white/30 hover:bg-white/30 transition">
                <p class="text-sm text-white/80 font-medium">هذا الأسبوع</p>
                <p class="text-3xl font-bold text-white mt-2">{{ number_format($weeklyTotal ?? 0, 2) }} {{ $salon->currency }}</p>
                <p class="text-xs text-white/70 mt-1">آخر 7 أيام</p>
            </div>
            <div class="p-6 bg-white/20 backdrop-blur-sm rounded-lg border border-white/30 hover:bg-white/30 transition">
                <p class="text-sm text-white/80 font-medium">هذا الشهر</p>
                <p class="text-3xl font-bold text-white mt-2">{{ number_format($monthlyTotal ?? 0, 2) }} {{ $salon->currency }}</p>
                <p class="text-xs text-white/70 mt-1">الشهر الحالي</p>
            </div>
            <div class="p-6 bg-white/20 backdrop-blur-sm rounded-lg border border-white/30 hover:bg-white/30 transition">
                <p class="text-sm text-white/80 font-medium">هذا العام</p>
                <p class="text-3xl font-bold text-white mt-2">{{ number_format($yearlyTotal ?? 0, 2) }} {{ $salon->currency }}</p>
                <p class="text-xs text-white/70 mt-1">السنة الحالية</p>
            </div>
        </div>
    </div>

    <!-- Weekly Revenue Chart -->
    <div class="card p-6 mb-6 bg-white rounded-lg shadow-md">
        <h5 class="mb-4 font-bold text-lg text-gray-800">📈 إيرادات الأسبوع الحالي</h5>
        <div style="position: relative; height: 300px;">
            <canvas id="weeklyChart"></canvas>
        </div>
    </div>

    <!-- Monthly Revenue Chart -->
    <div class="card p-6 mb-6 bg-white rounded-lg shadow-md">
        <h5 class="mb-4 font-bold text-lg text-gray-800">📊 إيرادات السنة الحالية (شهري)</h5>
        <div style="position: relative; height: 300px;">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>

    <!-- Filter Section with Filtered Chart -->
    <div class="card p-3 sm:p-4 md:p-6 mb-6 bg-white rounded-lg shadow-md">
        <h5 class="mb-3 sm:mb-4 font-bold text-base sm:text-lg md:text-xl text-gray-800">🔍 تصفية الإيرادات</h5>
        <form id="filterForm" class="flex flex-col gap-3 sm:gap-4 mb-4 sm:mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">تاريخ محدد</label>
                    <input type="date" id="filterDate" name="date" class="w-full px-2 sm:px-4 py-1 sm:py-2 text-xs sm:text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">شهر</label>
                    <input type="month" id="filterMonth" name="month" class="w-full px-2 sm:px-4 py-1 sm:py-2 text-xs sm:text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">سنة</label>
                    <input type="number" id="filterYear" name="year" min="2000" max="2100" value="{{ now()->year }}" class="w-full px-2 sm:px-4 py-1 sm:py-2 text-xs sm:text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div class="flex gap-2 col-span-1 sm:col-span-2 lg:col-span-1 pt-6 sm:pt-0">
                    <button type="button" id="filterBtn" class="flex-1 sm:flex-none px-3 sm:px-6 py-1 sm:py-2 text-xs sm:text-sm bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-md flex items-center justify-center gap-1 sm:gap-2">
                        <span id="filterBtnText">عرض</span>
                        <span id="filterSpinner" class="hidden">
                            <svg class="animate-spin h-4 w-4 sm:h-5 sm:w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                    <button type="button" id="clearBtn" class="flex-1 sm:flex-none px-3 sm:px-6 py-1 sm:py-2 text-xs sm:text-sm bg-gray-300 text-gray-800 font-semibold rounded-lg hover:bg-gray-400 transition shadow-md">مسح</button>
                </div>
            </div>
        </form>

        <div id="filterResult" class="hidden">
            <div id="resultBox" class="p-3 sm:p-4 md:p-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded">
                <p class="text-xs sm:text-sm md:text-base text-gray-700 font-medium break-words">إجمالي الإيرادات لـ <strong class="text-green-700" id="resultLabel"></strong>:</p>
                <p class="text-lg sm:text-2xl md:text-3xl font-bold text-green-700 mt-2 sm:mt-3 break-words" id="resultAmount">0.00</p>
            </div>

            <div id="chartContainer" class="hidden mt-4 sm:mt-6">
                <h6 class="text-xs sm:text-sm md:text-base font-bold text-gray-800 mb-2 sm:mb-3 md:mb-4">📅 تفصيل الإيرادات اليومية</h6>
                <div style="position: relative; height: 200px; width: 100%;" class="sm:h-64 md:h-80">
                    <canvas id="filteredChart"></canvas>
                </div>
            </div>
        </div>
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
        <div class="flex gap-2">
            <input type="text" id="bookingLink" class="flex-1 px-4 py-2 border border-gray-300 rounded-r-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ url('/book/' . ($salon->name_en ?? '')) }}" readonly>
            <button type="button" id="copyBtn" class="px-6 py-2 bg-blue-600 text-white rounded-l-lg hover:bg-blue-700 transition-colors duration-300 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                <span id="copyBtnText">نسخ الرابط</span>
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
                            label: 'إيرادات الأسبوع',
                            data: @json($weeklyRevenue),
                            borderColor: '#667eea',
                            backgroundColor: 'rgba(102, 126, 234, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#667eea',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                labels: { font: { size: 14 }, color: '#333' }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { color: '#666' },
                                grid: { color: 'rgba(0,0,0,0.05)' }
                            },
                            x: {
                                ticks: { color: '#666' },
                                grid: { color: 'rgba(0,0,0,0.05)' }
                            }
                        }
                    }
                });
            }

            // Monthly Revenue Chart (Bar)
            const monthlyCtx = document.getElementById('monthlyChart');
            if (monthlyCtx) {
                new Chart(monthlyCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($monthLabels),
                        datasets: [{
                            label: 'إيرادات الشهر',
                            data: @json($monthlyData),
                            backgroundColor: [
                                'rgba(102, 126, 234, 0.8)',
                                'rgba(118, 75, 162, 0.8)',
                                'rgba(237, 100, 166, 0.8)',
                                'rgba(255, 154, 158, 0.8)',
                                'rgba(250, 208, 196, 0.8)',
                                'rgba(255, 179, 71, 0.8)',
                                'rgba(255, 235, 59, 0.8)',
                                'rgba(102, 187, 106, 0.8)',
                                'rgba(66, 165, 245, 0.8)',
                                'rgba(171, 71, 188, 0.8)',
                                'rgba(229, 57, 53, 0.8)',
                                'rgba(63, 81, 181, 0.8)',
                            ],
                            borderColor: [
                                'rgba(102, 126, 234, 1)',
                                'rgba(118, 75, 162, 1)',
                                'rgba(237, 100, 166, 1)',
                                'rgba(255, 154, 158, 1)',
                                'rgba(250, 208, 196, 1)',
                                'rgba(255, 179, 71, 1)',
                                'rgba(255, 235, 59, 1)',
                                'rgba(102, 187, 106, 1)',
                                'rgba(66, 165, 245, 1)',
                                'rgba(171, 71, 188, 1)',
                                'rgba(229, 57, 53, 1)',
                                'rgba(63, 81, 181, 1)',
                            ],
                            borderWidth: 1,
                            borderRadius: 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                labels: { font: { size: 14 }, color: '#333' }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { color: '#666' },
                                grid: { color: 'rgba(0,0,0,0.05)' }
                            },
                            x: {
                                ticks: { color: '#666' },
                                grid: { color: 'rgba(0,0,0,0.05)' }
                            }
                        }
                    }
                });
            }
        }, 100);

        // Filter functionality with AJAX
        const filterBtn = document.getElementById('filterBtn');
        const clearBtn = document.getElementById('clearBtn');
        const filterForm = document.getElementById('filterForm');

        filterBtn.addEventListener('click', function() {
            applyFilter();
        });

        clearBtn.addEventListener('click', function() {
            document.getElementById('filterDate').value = '';
            document.getElementById('filterMonth').value = '';
            document.getElementById('filterYear').value = '{{ now()->year }}';
            document.getElementById('filterResult').classList.add('hidden');
            if (filteredChartInstance) {
                filteredChartInstance.destroy();
                filteredChartInstance = null;
            }
        });

        function applyFilter() {
            const date = document.getElementById('filterDate').value;
            const month = document.getElementById('filterMonth').value;
            const year = document.getElementById('filterYear').value;

            // Only proceed if at least one filter is selected
            if (!date && !month && !year) {
                alert('Please select at least one filter');
                return;
            }

            const filterBtn = document.getElementById('filterBtn');
            const filterBtnText = document.getElementById('filterBtnText');
            const filterSpinner = document.getElementById('filterSpinner');

            filterBtn.disabled = true;
            filterBtnText.classList.add('hidden');
            filterSpinner.classList.remove('hidden');

            const params = new URLSearchParams();
            if (date) params.append('date', date);
            if (month) params.append('month', month);
            if (year) params.append('year', year);

            fetch('{{ route("admin.filter-revenue") }}?' + params, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                document.getElementById('filterResult').classList.remove('hidden');
                document.getElementById('resultLabel').textContent = data.filterLabel || 'Unknown';
                document.getElementById('resultAmount').textContent = parseFloat(data.filteredRevenue || 0).toFixed(2);

                // Render filtered chart if data exists
                if (data.filteredChartData && data.filteredChartData.length > 0) {
                    document.getElementById('chartContainer').classList.remove('hidden');
                    
                    if (filteredChartInstance) {
                        filteredChartInstance.destroy();
                    }

                    const filteredCtx = document.getElementById('filteredChart');
                    filteredChartInstance = new Chart(filteredCtx, {
                        type: 'line',
                        data: {
                            labels: data.filteredChartLabels,
                            datasets: [{
                                label: 'الإيرادات اليومية',
                                data: data.filteredChartData,
                                borderColor: '#10b981',
                                backgroundColor: 'rgba(16, 185, 129, 0.15)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: '#10b981',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: true,
                                    labels: { font: { size: 14 }, color: '#333' }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: { color: '#666' },
                                    grid: { color: 'rgba(0,0,0,0.05)' }
                                },
                                x: {
                                    ticks: { color: '#666' },
                                    grid: { color: 'rgba(0,0,0,0.05)' }
                                }
                            }
                        }
                    });
                } else {
                    document.getElementById('chartContainer').classList.add('hidden');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error fetching data. Please try again.');
            })
            .finally(() => {
                filterBtn.disabled = false;
                filterBtnText.classList.remove('hidden');
                filterSpinner.classList.add('hidden');
            });
        }

        // Copy booking link functionality
        const copyBtn = document.getElementById('copyBtn');
        const copyBtnText = document.getElementById('copyBtnText');
        const bookingLink = document.getElementById('bookingLink');

        copyBtn.addEventListener('click', function() {
            const linkText = bookingLink.value;
            
            navigator.clipboard.writeText(linkText).then(function() {
                // Show success message
                const originalText = copyBtnText.textContent;
                copyBtnText.textContent = '✓ تم النسخ';
                copyBtn.classList.add('bg-green-600');
                copyBtn.classList.remove('bg-blue-600');
                
                // Reset button after 2 seconds
                setTimeout(function() {
                    copyBtnText.textContent = originalText;
                    copyBtn.classList.remove('bg-green-600');
                    copyBtn.classList.add('bg-blue-600');
                }, 2000);
            }).catch(function(err) {
                console.error('Failed to copy:', err);
                alert('فشل نسخ الرابط. الرجاء محاولة مرة أخرى.');
            });
        });
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
