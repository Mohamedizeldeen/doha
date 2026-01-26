@extends('superAdmin.layout.app')

@section('page-title', $salon->name_ar)

@section('content')

<div class="mb-6">
    <a href="{{ route('superAdmin.salons.index') }}" class="text-blue-600 hover:text-blue-700 font-medium">← العودة للصالونات</a>
</div>

<!-- Salon Header -->
<div class="bg-white rounded-lg shadow-md p-8 mb-6">
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $salon->name_ar }}</h1>
            <p class="text-gray-600 mt-2">{{ $salon->address_ar }}</p>
        </div>
        <div class="text-right">
            @if($salon->logo)
                <img src="{{ asset('storage/' . $salon->logo) }}" alt="{{ $salon->name_ar }}" class="w-24 h-24 rounded-lg object-cover">
            @endif
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
        <div class="bg-blue-50 p-4 rounded-lg">
            <p class="text-gray-600 text-sm">الهاتف</p>
            <p class="text-lg font-semibold text-gray-900 ltr">{{ $salon->phone }}</p>
        </div>
        <div class="bg-green-50 p-4 rounded-lg">
            <p class="text-gray-600 text-sm">البريد الإلكتروني</p>
            <p class="text-lg font-semibold text-gray-900 ltr">{{ $salon->email }}</p>
        </div>
        <div class="bg-purple-50 p-4 rounded-lg">
            <p class="text-gray-600 text-sm">المالك</p>
            <p class="text-lg font-semibold text-gray-900">{{ $salon->user->name }}</p>
        </div>
        <div class="bg-orange-50 p-4 rounded-lg">
            <p class="text-gray-600 text-sm">العملة</p>
            <p class="text-lg font-semibold text-gray-900">{{ $salon->currency }}</p>
        </div>
        <div class="bg-orange-50 p-4 rounded-lg">
            <p class="text-gray-600 text-sm">نوع الاشتراك</p>
            <p class="text-lg font-semibold text-gray-900">{{ $salon->subscription_type }}</p>
        </div>
          <div class="bg-orange-50 p-4 rounded-lg">
            <p class="text-gray-600 text-sm">تاريخ الاشتراك</p>
            <p class="text-lg font-semibold text-gray-900">{{ $salon->subscription_start_date ? $salon->subscription_start_date->format('d/m/Y') : 'غير محدد' }}</p>
        </div>  
        <div class="bg-red-50 p-4 rounded-lg">
            <p class="text-gray-600 text-sm">تاريخ انتهاء الاشتراك</p>
            <p class="text-lg font-semibold text-gray-900">{{ $salon->subscription_end_date ? $salon->subscription_end_date->format('d/m/Y') : 'غير محدد' }}</p>
        </div>  
        
        
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
        <p class="text-gray-600 text-sm font-medium">الخدمات</p>
        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $salon->services->count() }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
        <p class="text-gray-600 text-sm font-medium">الموظفين</p>
        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $salon->staff->count() }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
        <p class="text-gray-600 text-sm font-medium">المنتجات</p>
        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $salon->products->count() }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500">
        <p class="text-gray-600 text-sm font-medium">الحجوزات</p>
        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $total_bookings }}</p>
    </div>
</div>

<!-- Booking Status -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg shadow-md p-6 border-l-4 border-green-600">
        <p class="text-gray-600 text-sm font-medium">الحجوزات المكتملة</p>
        <p class="text-2xl font-bold text-green-700 mt-2">{{ $completed_bookings }}</p>
        <p class="text-sm text-gray-600 mt-2">الإيرادات: {{ number_format($revenue, 2) }}</p>
    </div>
    
    <div class="bg-gradient-to-br from-yellow-50 to-amber-50 rounded-lg shadow-md p-6 border-l-4 border-yellow-600">
        <p class="text-gray-600 text-sm font-medium">الحجوزات المعلقة</p>
        <p class="text-2xl font-bold text-yellow-700 mt-2">{{ $total_bookings - $completed_bookings }}</p>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-indigo-600">
        <p class="text-gray-600 text-sm font-medium">العملاء</p>
        <p class="text-2xl font-bold text-indigo-700 mt-2">{{ $salon->clients->count() }}</p>
    </div>
</div>

<!-- Services Section -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-4">الخدمات ({{ $salon->services->count() }})</h2>
    @if($salon->services->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($salon->services as $service)
                <div class="border rounded-lg p-4 hover:bg-gray-50 transition">
                    <p class="font-semibold text-gray-900">{{ $service->name_ar }}</p>
                    <p class="text-sm text-gray-600">{{ $service->description_ar }}</p>
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-sm text-gray-700">المدة: {{ $service->duration }} دقيقة</span>
                        <span class="font-bold text-blue-600">{{ $service->price }} {{ $salon->currency }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500">لا توجد خدمات</p>
    @endif
</div>

<!-- Products Section -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-4">المنتجات ({{ $salon->products->count() }})</h2>
    @if($salon->products->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($salon->products as $product)
                <div class="border rounded-lg p-4 hover:bg-gray-50 transition">
                    <p class="font-semibold text-gray-900">{{ $product->name_ar }}</p>
                    <p class="text-sm text-gray-600">{{ $product->description_ar }}</p>
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-sm text-gray-700">المخزون: {{ $product->stock_quantity }}</span>
                        <span class="font-bold text-green-600">{{ $product->price }} {{ $salon->currency }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500">لا توجد منتجات</p>
    @endif
</div>

<!-- Recent Bookings -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-4">الحجوزات الأخيرة</h2>
    @if($salon->bookings->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 text-right font-semibold text-gray-700">العميل</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-700">الخدمة</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-700">الموعد</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-700">الحالة</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-700">السعر</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salon->bookings->sortByDesc('appointment_datetime')->take(5) as $booking)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-3">{{ $booking->client->name ?? 'غير محدد' }}</td>
                            <td class="px-4 py-3">{{ $booking->service->name_ar ?? 'غير محدد' }}</td>
                            <td class="px-4 py-3">{{ $booking->appointment_datetime->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    @if($booking->status === 'completed') bg-green-100 text-green-700
                                    @elseif($booking->status === 'scheduled') bg-blue-100 text-blue-700
                                    @else bg-red-100 text-red-700 @endif">
                                    @switch($booking->status)
                                        @case('completed') مكتملة @break
                                        @case('scheduled') مجدولة @break
                                        @default ملغاة @endswitch
                                </span>
                            </td>
                            <td class="px-4 py-3 font-semibold">{{ number_format($booking->price ?? 0, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500">لا توجد حجوزات</p>
    @endif
</div>

@endsection
