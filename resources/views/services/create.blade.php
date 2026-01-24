@extends('admin.layout.app')

@section('page-title', 'إضافة خدمة')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">إضافة خدمة جديدة</h2>
</div>

<div class="bg-white rounded-lg shadow-md p-8 max-w-2xl">
    <form method="POST" action="{{ route('service.store', $salon) }}" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name Arabic -->
            <div>
                <label for="name_ar" class="block text-sm font-medium text-gray-700 mb-2">اسم الخدمة (عربي)</label>
                <input type="text" id="name_ar" name="name_ar" value="{{ old('name_ar') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('name_ar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Name English -->
            <div>
                <label for="name_en" class="block text-sm font-medium text-gray-700 mb-2">Service Name (English)</label>
                <input type="text" id="name_en" name="name_en" value="{{ old('name_en') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('name_en') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Price -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">السعر</label>
                <input type="number" id="price" name="price" step="0.01" value="{{ old('price') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Duration -->
            <div>
                <label for="duration_minutes" class="block text-sm font-medium text-gray-700 mb-2">المدة (دقائق)</label>
                <input type="number" id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('duration_minutes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Description Arabic -->
        <div>
            <label for="description_ar" class="block text-sm font-medium text-gray-700 mb-2">الوصف (عربي)</label>
            <textarea id="description_ar" name="description_ar" rows="3"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description_ar') }}</textarea>
            @error('description_ar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Description English -->
        <div>
            <label for="description_en" class="block text-sm font-medium text-gray-700 mb-2">Description (English)</label>
            <textarea id="description_en" name="description_en" rows="3"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description_en') }}</textarea>
            @error('description_en') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex gap-4 pt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">
                حفظ الخدمة
            </button>
            <a href="{{ route('service.index', $salon) }}" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-6 rounded-lg transition">
                إلغاء
            </a>
        </div>
    </form>
</div>
@endsection
