@extends('superAdmin.layout.app')

@section('page-title', 'تفاصيل الحجز')

@section('content')

<div class="mb-6">
    <a href="{{ route('superAdmin.bookings.index') }}" class="text-blue-600 hover:text-blue-700 font-medium">← العودة للحجوزات</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Booking Info -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">معلومات الحجز</h2>
            
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-gray-600 text-sm">رقم الحجز</p>
                    <p class="text-lg font-semibold text-gray-900">#{{ $booking->id }}</p>
                </div>

                <div>
                    <p class="text-gray-600 text-sm">الحالة</p>
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold mt-1
                        @if($booking->status === 'completed') bg-green-100 text-green-700
                        @elseif($booking->status === 'scheduled') bg-blue-100 text-blue-700
                        @else bg-red-100 text-red-700 @endif">
                        @switch($booking->status)
                            @case('completed') مكتملة @break
                            @case('scheduled') مجدولة @break
                            @default ملغاة @endswitch
                    </span>
                </div>

                <div>
                    <p class="text-gray-600 text-sm">الموعد</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $booking->appointment_datetime->format('d/m/Y H:i') }}</p>
                </div>

                <div>
                    <p class="text-gray-600 text-sm">السعر</p>
                    <p class="text-lg font-semibold text-gray-900">{{ number_format($booking->price ?? 0, 2) }} {{ $booking->salon->currency }}</p>
                </div>

                <div class="col-span-2">
                    <p class="text-gray-600 text-sm">ملاحظات</p>
                    <p class="text-gray-900 mt-1">{{ $booking->notes ?? 'لا توجد ملاحظات' }}</p>
                </div>
            </div>
        </div>

        <!-- Client Info -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">معلومات العميل</h2>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">الاسم:</span>
                    <span class="font-semibold text-gray-900">{{ $booking->client->name_en ?? 'غير محدد' }} {{ $booking->client->name_ar ?? 'غير محدد' }}</span>
                    
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">البريد الإلكتروني:</span>
                    <span class="font-semibold text-gray-900 ltr">{{ $booking->client->email ?? 'غير محدد' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">الهاتف:</span>
                    <span class="font-semibold text-gray-900 ltr">{{ $booking->client->phone ?? 'غير محدد' }}</span>
                </div>
            </div>
        </div>

        <!-- Service & Staff Info -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">الخدمة والموظف</h2>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">الخدمة:</span>
                    <span class="font-semibold text-gray-900">{{ $booking->service->name_ar ?? 'غير محدد' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">الموظف:</span>
                    <span class="font-semibold text-gray-900">{{ $booking->staff->name_ar ?? 'غير محدد' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">مدة الخدمة:</span>
                    <span class="font-semibold text-gray-900">{{ $booking->service->duration_minutes ?? 0 }} دقيقة</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Salon Info -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">الصالون</h2>
            
            @if($booking->salon->logo)
                <img src="{{ asset('storage/' . $booking->salon->logo) }}" alt="{{ $booking->salon->name_ar }}" class="w-full h-32 object-cover rounded-lg mb-4">
            @endif

            <div class="space-y-3">
                <div>
                    <p class="text-gray-600 text-sm">الاسم</p>
                    <a href="{{ route('superAdmin.salons.show', $booking->salon->id) }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                        {{ $booking->salon->name_ar }}
                    </a>
                </div>

                <div>
                    <p class="text-gray-600 text-sm">الهاتف</p>
                    <p class="font-semibold text-gray-900 ltr">{{ $booking->salon->phone }}</p>
                </div>

                <div>
                    <p class="text-gray-600 text-sm">البريد الإلكتروني</p>
                    <p class="font-semibold text-gray-900 ltr">{{ $booking->salon->email }}</p>
                </div>

                <div>
                    <p class="text-gray-600 text-sm">العنوان</p>
                    <p class="font-semibold text-gray-900">{{ $booking->salon->address_ar }}</p>
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">معلومات النظام</h2>
            
            <div class="space-y-3 text-sm">
                <div>
                    <p class="text-gray-600">تاريخ الإنشاء:</p>
                    <p class="font-semibold text-gray-900">{{ $booking->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <div>
                    <p class="text-gray-600">آخر تحديث:</p>
                    <p class="font-semibold text-gray-900">{{ $booking->updated_at->format('d/m/Y H:i') }}</p>
                </div>

                
            </div>
        </div>
    </div>
</div>

@endsection
