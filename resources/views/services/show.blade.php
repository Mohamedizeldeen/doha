@extends('admin.layout.app')

@section('page-title', 'تفاصيل الخدمة')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">{{ $service->name_ar }}</h2>
    <div class="flex gap-3">
        <a href="{{ route('service.edit', [$salon, $service]) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg transition">
            <i class="fas fa-edit ml-2"></i>تعديل
        </a>
        <a href="{{ route('service.index', $salon) }}" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-lg transition">
            <i class="fas fa-arrow-right ml-2"></i>رجوع
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow-md p-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <div>
            <h3 class="text-sm font-medium text-gray-600 mb-2">الاسم (عربي)</h3>
            <p class="text-xl font-bold text-gray-800">{{ $service->name_ar }}</p>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-600 mb-2">Service Name (English)</h3>
            <p class="text-xl font-bold text-gray-800">{{ $service->name_en }}</p>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-600 mb-2">السعر</h3>
            <p class="text-2xl font-bold text-green-600">{{ $service->price }} {{ $salon->currency ?? 'ريال' }}</p>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-600 mb-2">المدة</h3>
            <p class="text-xl font-bold text-gray-800">{{ $service->duration_minutes }} دقيقة</p>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-600 mb-2">الحالة</h3>
            <span class="text-lg px-4 py-1 rounded-full {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $service->is_active ? 'نشطة' : 'معطلة' }}
            </span>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-600 mb-2">التاريخ</h3>
            <p class="text-gray-800">{{ $service->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    @if ($service->description_ar || $service->description_ar)
        <div class="border-t pt-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">الوصف</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if ($service->description_ar)
                    <div>
                        <h4 class="font-medium text-gray-700 mb-2">عربي</h4>
                        <p class="text-gray-600">{{ $service->description_ar }}</p>
                    </div>
                @endif
                @if ($service->description_en)
                    <div>
                        <h4 class="font-medium text-gray-700 mb-2">English</h4>
                        <p class="text-gray-600">{{ $service->description_en }}</p>
                    </div>
                @endif
            </div>
        </div>
    @endif

    @if ($service->staff->count() > 0)
        <div class="border-t pt-6 mt-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">الموظفون المسندة إليهم الخدمة</h3>
            <div class="grid grid-cols-1 gap-3">
                @foreach ($service->staff as $staff)
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="font-medium text-gray-800">{{ $staff->name_ar }} ({{ $staff->name_en }})</p>
                        <p class="text-sm text-gray-600">{{ $staff->position_ar }} - {{ $staff->position_en }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="border-t pt-6 mt-6">
            <p class="text-gray-600 italic">لا يوجد موظفون مسندة إليهم هذه الخدمة حالياً</p>
        </div>
    @endif
</div>
@endsection
