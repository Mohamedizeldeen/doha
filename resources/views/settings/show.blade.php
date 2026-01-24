@extends('admin.layout.app')

@section('page-title', 'عرض إعدادات الصالون')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">إعدادات الصالون</h2>
    <p class="text-gray-600 mt-2">تفاصيل صالونك الحالية</p>
</div>

<!-- Success Message -->
@if (session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
        <p class="text-green-800 font-medium">✓ {{ session('success') }}</p>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column - Logo and Main Info -->
    <div class="lg:col-span-2">
        <!-- Logo Section -->
        @if ($salon->logo)
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">شعار الصالون</h3>
                <div class="flex justify-center">
                    <img src="{{ asset('storage/' . $salon->logo) }}" alt="{{ $salon->name_ar }}" class="h-48 w-48 object-contain rounded-lg border border-gray-200">
                </div>
            </div>
        @endif

        <!-- Information Sections -->
        <div class="space-y-6">
            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 pb-4 border-b-2 border-blue-600">المعلومات الأساسية</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium text-gray-500">اسم الصالون (عربي)</label>
                        <p class="text-lg text-gray-900 mt-2">{{ $salon->name_ar }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Salon Name (English)</label>
                        <p class="text-lg text-gray-900 mt-2">{{ $salon->name_en }}</p>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 pb-4 border-b-2 border-blue-600">معلومات الاتصال</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium text-gray-500">رقم الهاتف</label>
                        <p class="text-lg text-gray-900 mt-2 ltr">{{ $salon->phone ?? 'غير محدد' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">البريد الإلكتروني</label>
                        <p class="text-lg text-gray-900 mt-2 ltr">{{ $salon->email ?? 'غير محدد' }}</p>
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 pb-4 border-b-2 border-blue-600">العنوان</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">العنوان (عربي)</label>
                        <p class="text-gray-900 mt-2 whitespace-pre-line">{{ $salon->address_ar ?? 'غير محدد' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Address (English)</label>
                        <p class="text-gray-900 mt-2 whitespace-pre-line ltr">{{ $salon->address_en ?? 'Not specified' }}</p>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 pb-4 border-b-2 border-blue-600">الوصف</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">الوصف (عربي)</label>
                        <p class="text-gray-900 mt-2 whitespace-pre-line">{{ $salon->description_ar ?? 'غير محدد' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Description (English)</label>
                        <p class="text-gray-900 mt-2 whitespace-pre-line ltr">{{ $salon->description_en ?? 'Not specified' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column - Summary & Actions -->
    <div>
        <!-- Account Summary -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6 sticky top-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 pb-4 border-b-2 border-blue-600">ملخص الحساب</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-500">مالك الحساب</label>
                    <p class="text-gray-900 font-medium mt-2">{{ $salon->user?->name ?? 'N/A' }}</p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500">البريد الإلكتروني للمالك</label>
                    <p class="text-gray-900 ltr mt-2">{{ $salon->user?->email ?? 'N/A' }}</p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500">تاريخ الإنشاء</label>
                    <p class="text-gray-900 mt-2">{{ $salon->created_at->format('d/m/Y') }}</p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500">آخر تحديث</label>
                    <p class="text-gray-900 mt-2">{{ $salon->updated_at->format('d/m/Y H:i') }}</p>
                </div>

                 <div>
                    <label class="text-sm font-medium text-gray-500"> مواعيد العمل</label>
                    <p class="text-gray-900 mt-2">من {{ \Carbon\Carbon::parse($salon->opening_time)->format('H:i') }} - الي {{ \Carbon\Carbon::parse($salon->closing_time)->format('H:i') }}</p>
                </div>

                 <div>
                    <label class="text-sm font-medium text-gray-500">  العملة</label>
                    <p class="text-gray-900 mt-2">{{ $salon->currency }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">  انتهاء الاشتراك</label>
                    <p class="text-gray-900 mt-2">{{ \Carbon\Carbon::parse($salon->subscription_end_date)->format('d/m/Y') }}</p>
                </div>
                 <div>
                    <label class="text-sm font-medium text-gray-500">  نوع الاشتراك</label>
                    <p class="text-gray-900 mt-2">{{ $salon->subscription_type }}</p>
                </div>
                 <div>
                    <label class="text-sm font-medium text-gray-500">  أيام العمل</label>
                    <p class="text-gray-900 mt-2">{{ is_array($workDays = json_decode($salon->work_days, true)) ? implode(', ', $workDays) : 'غير محدد' }}</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 space-y-3">
                <a href="{{ route('settings.edit') }}" class="w-full inline-block bg-blue-600 text-white font-medium px-4 py-2 rounded-lg hover:bg-blue-700 transition text-center">
                    ✎ تعديل الإعدادات
                </a>
                
                <a href="{{ route('admin.dashbord') }}" class="w-full inline-block bg-gray-600 text-white font-medium px-4 py-2 rounded-lg hover:bg-gray-700 transition text-center">
                    ← العودة للوحة التحكم
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
