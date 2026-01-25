@extends('admin.layout.app')

@section('page-title', 'الحجوزات')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">جميع الحجوزات</h2>
    <a href="{{ route('booking.create', $salon) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">
        + حجز جديد
    </a>
</div>

<!-- Search and Filter Section -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Search by client name or phone -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">البحث عن عميل</label>
            <input type="text" id="searchInput" placeholder="اسم العميل أو رقم الهاتف..." 
                class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                onkeyup="filterBookings()">
        </div>

        <!-- Filter by status -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">حسب الحالة</label>
            <select id="statusFilter" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                onchange="filterBookings()">
                <option value="">جميع الحالات</option>
                <option value="scheduled">مجدول</option>
                <option value="completed">مكتمل</option>
                <option value="cancelled">ملغي</option>
            </select>
        </div>

        <!-- Filter by service -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">حسب الخدمة</label>
            <select id="serviceFilter" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                onchange="filterBookings()">
                <option value="">جميع الخدمات</option>
                @foreach($bookings->pluck('service')->unique('id') as $service)
                    <option value="{{ $service->name_ar }}">{{ $service->name_ar }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Reset button -->
    <div class="mt-4">
        <button onclick="resetFilters()" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-6 rounded-lg transition">
            إعادة تعيين
        </button>
    </div>
</div>

@if($bookings->isEmpty())
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <p class="text-gray-500 text-lg">لا توجد حجوزات حالياً</p>
    </div>
@else
    <div class="grid grid-cols-1 gap-6" id="bookingsContainer">
        @foreach($bookings->sortByDesc('appointment_datetime') as $booking)
            <div class="booking-card bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition"
                data-client-name="{{ strtolower($booking->client->name_ar) }}"
                data-client-phone="{{ $booking->client->phone }}"
                data-service="{{ strtolower($booking->service->name_ar) }}"
                data-status="{{ $booking->status }}">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <h5 class="text-sm font-medium text-gray-600">العميل</h5>
                        <p class="text-lg font-semibold text-gray-900">{{ $booking->client->name_ar }}</p>
                        <p class="text-sm text-gray-500">{{ $booking->client->phone }}</p>
                    </div>
                    <div>
                        <h5 class="text-sm font-medium text-gray-600">الخدمة</h5>
                        <p class="text-lg font-semibold text-gray-900">{{ $booking->service->name_ar }}</p>
                        <p class="text-sm text-gray-500">{{ $booking->service->price }} {{ $salon->currency }}</p>
                    </div>
                    <div>
                        <h5 class="text-sm font-medium text-gray-600">الموظفة</h5>
                        <p class="text-lg font-semibold text-gray-900">{{ $booking->staff->name_ar }}</p>
                    </div>
                    <div>
                        <h5 class="text-sm font-medium text-gray-600">الموعد</h5>
                        <p class="text-lg font-semibold text-gray-900">{{ $booking->appointment_datetime->format('Y-m-d') }}</p>
                        <p class="text-sm text-gray-500">{{ $booking->appointment_datetime->format('H:i') }}</p>
                    </div>
                    <div>
                        <h5 class="text-sm font-medium text-gray-600">الحالة</h5>
                        <p class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                            @if($booking->status === 'scheduled') bg-blue-100 text-blue-800
                            @elseif($booking->status === 'completed') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            @if($booking->status === 'scheduled') مجدول
                            @elseif($booking->status === 'completed') مكتمل
                            @else ملغي
                            @endif
                        </p>
                    </div>
                </div>
                <div class="flex gap-2 mt-4">
                    <a href="{{ route('booking.show', [$salon, $booking]) }}" class="inline-flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition text-sm">
                        عرض
                    </a>
                    <a href="{{ route('booking.edit', [$salon, $booking]) }}" class="inline-flex items-center justify-center bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded transition text-sm">
                        تعديل
                    </a>
                    <form action="{{ route('booking.destroy', [$salon, $booking]) }}" method="POST" class="inline" onsubmit="return confirm('هل تريد حذف هذا الحجز؟');">
                        @csrf @method('DELETE')
                        <button type="submit" class="inline-flex items-center justify-center bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition text-sm">
                            حذف
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endif

<script>
    // Filter bookings based on search and filters
    function filterBookings() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const serviceFilter = document.getElementById('serviceFilter').value.toLowerCase();
        const bookingCards = document.querySelectorAll('.booking-card');
        let visibleCount = 0;

        bookingCards.forEach(card => {
            const clientName = card.getAttribute('data-client-name');
            const clientPhone = card.getAttribute('data-client-phone');
            const service = card.getAttribute('data-service');
            const status = card.getAttribute('data-status');

            // Check search criteria
            const matchesSearch = !searchTerm || 
                                 clientName.includes(searchTerm) || 
                                 clientPhone.includes(searchTerm);

            // Check status filter
            const matchesStatus = !statusFilter || status === statusFilter;

            // Check service filter
            const matchesService = !serviceFilter || service === serviceFilter;

            // Show or hide based on all criteria
            if (matchesSearch && matchesStatus && matchesService) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Show "no results" message if needed
        const container = document.getElementById('bookingsContainer');
        let noResultsMsg = container.querySelector('.no-results-msg');
        
        if (visibleCount === 0) {
            if (!noResultsMsg) {
                noResultsMsg = document.createElement('div');
                noResultsMsg.className = 'no-results-msg bg-gray-50 rounded-lg shadow-md p-8 text-center';
                noResultsMsg.innerHTML = '<p class="text-gray-500 text-lg">لا توجد حجوزات تطابق معايير البحث</p>';
                container.appendChild(noResultsMsg);
            }
        } else if (noResultsMsg) {
            noResultsMsg.remove();
        }
    }

    // Reset all filters
    function resetFilters() {
        document.getElementById('searchInput').value = '';
        document.getElementById('statusFilter').value = '';
        document.getElementById('serviceFilter').value = '';
        filterBookings();
    }
</script>
@endsection
