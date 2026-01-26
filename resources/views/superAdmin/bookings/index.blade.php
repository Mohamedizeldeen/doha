@extends('superAdmin.layout.app')

@section('page-title', 'الحجوزات')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-900">إدارة الحجوزات</h1>
</div>

<!-- Filter Form -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">الصالون</label>
            <select name="salon_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">الكل</option>
                @foreach($salons as $salon)
                    <option value="{{ $salon->id }}" {{ request('salon_id') == $salon->id ? 'selected' : '' }}>
                        {{ $salon->name_ar }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">الحالة</label>
            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">الكل</option>
                <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>مجدولة</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتملة</option>
                <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>ملغاة</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">من التاريخ</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">إلى التاريخ</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="flex items-end gap-2">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition">
                بحث
            </button>
            <a href="{{ route('superAdmin.bookings.index') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg font-medium transition text-center">
                مسح
            </a>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">الصالون</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">العميل</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">الخدمة</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">الموعد</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">السعر</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">الحالة</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">الإجراء</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $booking->salon->name_ar }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $booking->client->name_ar ?? 'غير محدد' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $booking->service->name_ar ?? 'غير محدد' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $booking->appointment_datetime->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 text-sm text-center font-semibold">
                            {{ number_format($booking->price ?? 0, 2) }} {{ $booking->salon->currency }}
                        </td>
                        <td class="px-6 py-4 text-sm text-center">
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
                        <td class="px-6 py-4 text-sm text-center">
                            <a href="{{ route('superAdmin.bookings.show', $booking->id) }}" class="text-blue-600 hover:text-blue-700 font-medium">عرض</a>
                            <form action="{{ route('superAdmin.bookings.destroy', $booking->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا الحجز؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700 font-medium ml-4 border-0 bg-none cursor-pointer">حذف</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">لا توجد حجوزات</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $bookings->links() }}
</div>

@endsection
