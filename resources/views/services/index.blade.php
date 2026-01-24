@extends('admin.layout.app')

@section('page-title', 'الخدمات')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <h2 class="text-xl sm:text-2xl font-bold text-gray-800">الخدمات</h2>
    <a href="{{ route('service.create', $salon) }}" class="bg-gray-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition text-sm sm:text-base">
        <i class="fas fa-plus ml-2"></i>إضافة خدمة
    </a>
</div>

@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
    @forelse ($services as $service)
        <div class="bg-white rounded-lg shadow-md p-4 md:p-6 hover:shadow-lg transition">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-1">{{ $service->name_ar }}</h3>
                    <p class="text-gray-600 mb-2 text-sm md:text-base">{{ $service->name_en }}</p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 md:gap-4 mt-3 md:mt-4 text-xs md:text-sm">
                        <div>
                            <span class="text-gray-600 block">السعر:</span>
                            <p class="text-base md:text-lg font-bold text-gray-600">{{ $service->price }} {{ $salon->currency ?? 'ريال' }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600 block">المدة:</span>
                            <p class="text-base md:text-lg font-bold">{{ $service->duration_minutes }} دقيقة</p>
                        </div>
                    </div>

                    @if ($service->description_ar)
                        <p class="text-gray-700 mt-2 md:mt-3 text-xs md:text-sm line-clamp-2">{{ $service->description_ar }}</p>
                    @endif

                    <div class="mt-3 md:mt-4">
                        <span class="text-xs px-2 md:px-3 py-0.5 md:py-1 rounded-full {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $service->is_active ? 'نشطة' : 'معطلة' }}
                        </span>
                    </div>
                </div>

                <div class="flex gap-2 flex-wrap self-start">
                    <a href="{{ route('service.edit', [$salon, $service]) }}" class="inline-flex items-center justify-center bg-gray-500 hover:bg-yellow-600 text-white py-1.5 px-2 md:py-2 md:px-3 rounded transition text-xs md:text-sm whitespace-nowrap">
                        تعديل
                    </a>
                    <a href="{{ route('service.show', [$salon, $service]) }}" class="inline-flex items-center justify-center bg-gray-500 hover:bg-blue-600 text-white py-1.5 px-2 md:py-2 md:px-3 rounded transition text-xs md:text-sm whitespace-nowrap">
                        عرض
                    </a>
                    <form method="POST" action="{{ route('service.destroy', [$salon, $service]) }}" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="inline-flex items-center justify-center bg-gray-500 hover:bg-red-600 text-white py-1.5 px-2 md:py-2 md:px-3 rounded transition text-xs md:text-sm whitespace-nowrap" onclick="return confirm('هل أنت متأكد؟')">
                            حذف
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-12 bg-white rounded-lg">
            <p class="text-gray-600 text-lg">لا توجد خدمات حالياً</p>
        </div>
    @endforelse
</div>
@endsection
