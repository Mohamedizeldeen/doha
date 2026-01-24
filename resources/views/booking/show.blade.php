@extends('admin.layout.app')

@section('page-title', 'تفاصيل الحجز')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">تفاصيل الحجز</h2>
    <div class="flex gap-2">
        <a href="{{ route('booking.edit', [$salon, $booking]) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded transition">
            تعديل
        </a>
        <a href="{{ route('booking.index', $salon) }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded transition">
            العودة
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Info -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md p-6 space-y-6">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <h5 class="text-sm font-medium text-gray-600">العميل</h5>
                    <p class="text-lg font-semibold text-gray-900">{{ $booking->client->name_ar }}</p>
                    <p class="text-sm text-gray-500">{{ $booking->client->phone }}</p>
                </div>
                <div>
                    <h5 class="text-sm font-medium text-gray-600">البريد الإلكتروني</h5>
                    <p class="text-lg font-semibold text-gray-900">{{ $booking->client->email ?? 'غير متوفر' }}</p>
                </div>
            </div>

            <hr class="border-gray-200">

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <h5 class="text-sm font-medium text-gray-600">الخدمة</h5>
                    <p class="text-lg font-semibold text-gray-900">{{ $booking->service->name_ar }}</p>
                    <p class="text-sm text-gray-500">{{ $booking->service->duration_minutes }} دقيقة</p>
                </div>
                <div>
                    <h5 class="text-sm font-medium text-gray-600">السعر</h5>
                    <p class="text-lg font-semibold text-gray-900">{{ $booking->price }} ريال</p>
                </div>
            </div>

            <hr class="border-gray-200">

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <h5 class="text-sm font-medium text-gray-600">الموظفة</h5>
                    <p class="text-lg font-semibold text-gray-900">{{ $booking->staff->name_ar }}</p>
                    <p class="text-sm text-gray-500">{{ $booking->staff->position_ar }}</p>
                </div>
                <div>
                    <h5 class="text-sm font-medium text-gray-600">البريد الإلكتروني</h5>
                    <p class="text-lg font-semibold text-gray-900">{{ $booking->staff->email }}</p>
                </div>
            </div>

            <hr class="border-gray-200">

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <h5 class="text-sm font-medium text-gray-600">التاريخ</h5>
                    <p class="text-lg font-semibold text-gray-900">{{ $booking->appointment_datetime->format('Y-m-d') }}</p>
                </div>
                <div>
                    <h5 class="text-sm font-medium text-gray-600">الوقت</h5>
                    <p class="text-lg font-semibold text-gray-900">{{ $booking->appointment_datetime->format('H:i') }}</p>
                </div>
            </div>

            @if($booking->notes)
                <hr class="border-gray-200">
                <div>
                    <h5 class="text-sm font-medium text-gray-600">الملاحظات</h5>
                    <p class="text-gray-700">{{ $booking->notes }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Status Card -->
    <div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h5 class="text-lg font-semibold text-gray-900 mb-4">حالة الحجز</h5>
            <p class="inline-block px-4 py-2 rounded-full text-sm font-semibold mb-6 w-full text-center
                @if($booking->status === 'scheduled') bg-blue-100 text-blue-800
                @elseif($booking->status === 'completed') bg-green-100 text-green-800
                @else bg-red-100 text-red-800
                @endif">
                @if($booking->status === 'scheduled') مجدول
                @elseif($booking->status === 'completed') مكتمل
                @else ملغي
                @endif
            </p>

            <form action="{{ route('booking.status.update', [$salon, $booking]) }}" method="POST" class="space-y-3">
                @csrf @method('PATCH')
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    <option value="scheduled" @selected($booking->status === 'scheduled')>مجدول</option>
                    <option value="completed" @selected($booking->status === 'completed')>مكتمل</option>
                    <option value="canceled" @selected($booking->status === 'canceled')>ملغي</option>
                </select>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded transition">
                    تحديث الحالة
                </button>
            </form>

            <hr class="border-gray-200 my-6">

            <form action="{{ route('booking.destroy', [$salon, $booking]) }}" method="POST" onsubmit="return confirm('هل تريد حذف هذا الحجز؟');">
                @csrf @method('DELETE')
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 rounded transition">
                    حذف الحجز
                </button>
            </form>

            <div class="text-xs text-gray-500 mt-6 space-y-1">
                <p>تم الإنشاء: {{ $booking->created_at->format('Y-m-d H:i') }}</p>
                <p>آخر تحديث: {{ $booking->updated_at->format('Y-m-d H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
