@extends('admin.layout.app')

@section('page-title', 'تفاصيل الموظف')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">{{ $staff->name_ar }}</h2>
    <div class="flex gap-3">
        <a href="{{ route('staff.edit', [$salon, $staff]) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg transition">
            <i class="fas fa-edit ml-2"></i>تعديل
        </a>
        <a href="{{ route('staff.index', $salon) }}" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-lg transition">
            <i class="fas fa-arrow-right ml-2"></i>رجوع
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow-md p-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <div>
            <h3 class="text-sm font-medium text-gray-600 mb-2">الاسم (عربي)</h3>
            <p class="text-xl font-bold text-gray-800">{{ $staff->name_ar }}</p>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-600 mb-2">Name (English)</h3>
            <p class="text-xl font-bold text-gray-800">{{ $staff->name_en }}</p>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-600 mb-2">البريد الإلكتروني</h3>
            <p class="text-lg text-blue-600">{{ $staff->email }}</p>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-600 mb-2">رقم الهاتف</h3>
            <p class="text-lg font-medium text-gray-800">{{ $staff->phone }}</p>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-600 mb-2">المنصب (عربي)</h3>
            <p class="text-lg font-medium text-gray-800">{{ $staff->position_ar }}</p>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-600 mb-2">Position (English)</h3>
            <p class="text-lg font-medium text-gray-800">{{ $staff->position_en }}</p>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-600 mb-2">تاريخ الإنشاء</h3>
            <p class="text-gray-800">{{ $staff->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    @if ($staff->services->count() > 0)
        <div class="border-t pt-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">الخدمات المسندة</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($staff->services as $service)
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <p class="font-medium text-gray-800">{{ $service->name_ar }}</p>
                        <p class="text-sm text-gray-600">{{ $service->name_en }}</p>
                        <p class="text-lg font-bold text-green-600 mt-2">{{ $service->price }} ريال</p>
                        <p class="text-sm text-gray-600">{{ $service->duration_minutes }} دقيقة</p>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="border-t pt-6">
            <p class="text-gray-600 italic">لا يوجد خدمات مسندة حالياً</p>
        </div>
    @endif
</div>
@endsection
