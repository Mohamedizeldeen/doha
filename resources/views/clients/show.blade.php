@extends('admin.layout.app')

@section('page-title', 'تفاصيل العميل')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">{{ $client->name_ar }}</h2>
    <div class="flex gap-3">
        <a href="{{ route('client.edit', [$salon, $client]) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg transition">
            <i class="fas fa-edit ml-2"></i>تعديل
        </a>
        <a href="{{ route('client.index', $salon) }}" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-lg transition">
            <i class="fas fa-arrow-right ml-2"></i>رجوع
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Client Information -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md p-8 mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-6">معلومات العميل</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h4 class="text-sm font-medium text-gray-600 mb-2"> اسم العميل</h4>
                    <p class="text-xl font-bold text-gray-800">{{ $client->name_ar }}</p>
                </div>

                

                <div>
                    <h4 class="text-sm font-medium text-gray-600 mb-2">رقم الهاتف</h4>
                    <p class="text-lg font-medium text-gray-800">{{ $client->phone }}</p>
                </div>

                <div>
                    <h4 class="text-sm font-medium text-gray-600 mb-2">البريد الإلكتروني</h4>
                    <p class="text-lg text-blue-600">{{ $client->email }}</p>
                </div>

                <div>
                    <h4 class="text-sm font-medium text-gray-600 mb-2">رمز العميل</h4>
                    <p class="text-lg font-bold text-purple-600">{{ $client->client_code }}</p>
                </div>

                <div>
                    <h4 class="text-sm font-medium text-gray-600 mb-2">تاريخ الإنشاء</h4>
                    <p class="text-gray-800">{{ $client->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Booking History -->
        @if ($client->bookings->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-8">
                <h3 class="text-lg font-bold text-gray-800 mb-6">سجل الحجوزات</h3>
                <div class="space-y-4">
                    @foreach ($client->bookings as $booking)
                        <div class="border-l-4 border-blue-500 bg-blue-50 p-4 rounded">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-gray-800">{{ $booking->service->name_ar }}</h4>
                                    <p class="text-sm text-gray-600">الموظف: {{ $booking->staff->name_ar }}</p>
                                    <p class="text-sm text-gray-600">{{ $booking->appointment_datetime->format('d/m/Y H:i') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-green-600">{{ $booking->service->price }} {{ $salon->currency }}</p>
                                    <span class="text-xs px-3 py-1 rounded-full {{ $booking->status == 'completed' ? 'bg-green-100 text-green-800' : ($booking->status == 'scheduled' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                         @switch($booking->status)
                                            @case('completed')
                                                مكتمل
                                                @break
                                            @case('scheduled')
                                                مجدول
                                                @break
                                            @default
                                                ملغي
                                        @endswitch
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <p class="text-gray-600">لا يوجد حجوزات لهذا العميل</p>
            </div>
        @endif
    </div>

    <!-- Statistics -->
    <div>
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-6">الإحصائيات</h3>
            
            <div class="space-y-4">
                <div class="text-center">
                    <h4 class="text-sm text-gray-600 mb-1">إجمالي الحجوزات</h4>
                    <p class="text-3xl font-bold text-blue-600">{{ $client->bookings->count() }}</p>
                </div>

                @php
                    $completedBookings = $client->bookings->where('status', 'completed');
                    $totalSpent = $completedBookings->sum('price');
                @endphp

                <div class="text-center border-t pt-4">
                    <h4 class="text-sm text-gray-600 mb-1">الحجوزات المكتملة</h4>
                    <p class="text-3xl font-bold text-green-600">{{ $completedBookings->count() }}</p>
                </div>

                  <div class="text-center border-t pt-4">
                    <h4 class="text-sm text-gray-600 mb-1">الحجوزات المجدولة</h4>
                    <p class="text-3xl font-bold text-yellow-600">{{ $client->bookings->where('status', 'scheduled')->count() }}</p>
                </div>

                 <div class="text-center border-t pt-4">
                    <h4 class="text-sm text-gray-600 mb-1">الحجوزات الملغاة</h4>
                    <p class="text-3xl font-bold text-red-600">{{ $client->bookings->where('status', 'canceled')->count() }}</p>
                </div>

                <div class="text-center border-t pt-4">
                    <h4 class="text-sm text-gray-600 mb-1">إجمالي الإنفاق</h4>
                    <p class="text-2xl font-bold text-purple-600">{{ number_format($totalBookingsMoney, 2) }} {{ $salon->currency }}</p>

                </div>

               
            </div>
        </div>
    </div>
</div>
@endsection
