@extends('admin.layout.app')

@section('page-title', 'الموظفون')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <h2 class="text-xl sm:text-2xl font-bold text-gray-800">الموظفون</h2>
    <a href="{{ route('staff.create', $salon) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition text-sm sm:text-base">
        <i class="fas fa-plus ml-2"></i>إضافة موظف
    </a>
</div>

@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
    @forelse ($staff as $member)
        <div class="bg-white rounded-lg shadow-md p-4 md:p-6 hover:shadow-lg transition">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-1">{{ $member->name_ar }}</h3>
                    <p class="text-gray-600 mb-3 text-sm md:text-base">{{ $member->name_en }}</p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 md:gap-4 text-xs md:text-sm mb-4">
                        <div>
                            <span class="text-gray-600 block">المنصب:</span>
                            <p class="font-medium">{{ $member->position_ar }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600 block">البريد الإلكتروني:</span>
                            <p class="font-medium text-blue-600 text-xs">{{ $member->email }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600 block">رقم الهاتف:</span>
                            <p class="font-medium">{{ $member->phone }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600 block">الخدمات:</span>
                            <p class="font-medium">{{ $member->services->count() }} خدمة</p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-2 flex-wrap self-start">
                    <a href="{{ route('staff.edit', [$salon, $member]) }}" class="inline-flex items-center justify-center bg-yellow-500 hover:bg-yellow-600 text-white py-1.5 px-2 md:py-2 md:px-3 rounded transition text-xs md:text-sm whitespace-nowrap">
                        تعديل
                    </a>
                    <a href="{{ route('staff.show', [$salon, $member]) }}" class="inline-flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white py-1.5 px-2 md:py-2 md:px-3 rounded transition text-xs md:text-sm whitespace-nowrap">
                        عرض
                    </a>
                    <form method="POST" action="{{ route('staff.destroy', [$salon, $member]) }}" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="inline-flex items-center justify-center bg-red-500 hover:bg-red-600 text-white py-1.5 px-2 md:py-2 md:px-3 rounded transition text-xs md:text-sm whitespace-nowrap" onclick="return confirm('هل أنت متأكد؟')">
                            حذف
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-12 bg-white rounded-lg">
            <p class="text-gray-600 text-lg">لا يوجد موظفون حالياً</p>
        </div>
    @endforelse
</div>
@endsection
