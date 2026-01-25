@extends('admin.layout.app')

@section('page-title', 'تعديل المنتج')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">تعديل: {{ $product->name_ar }}</h2>
</div>

<div class="bg-white rounded-lg shadow-md p-8 max-w-2xl">
    <form method="POST" action="{{ route('product.update', [$salon, $product]) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded">
                <p class="text-red-700 font-semibold">There were problems with your input:</p>
                <ul class="mt-2 list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name Arabic -->
            <div>
                <label for="name_ar" class="block text-sm font-medium text-gray-700 mb-2">اسم المنتج (عربي)</label>
                <input type="text" id="name_ar" name="name_ar" value="{{ old('name_ar', $product->name_ar) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('name_ar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Name English -->
            <div>
                <label for="name_en" class="block text-sm font-medium text-gray-700 mb-2">Product Name (English)</label>
                <input type="text" id="name_en" name="name_en" value="{{ old('name_en', $product->name_en) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('name_en') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Price -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">السعر</label>
                <input type="number" id="price" name="price" step="0.01" value="{{ old('price', $product->price) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Stock Quantity -->
            <div>
                <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-2">كمية المخزون</label>
                <input type="number" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('stock_quantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Description Arabic -->
        <div>
            <label for="description_ar" class="block text-sm font-medium text-gray-700 mb-2">الوصف (عربي)</label>
            <textarea id="description_ar" name="description_ar" rows="3" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description_ar', $product->description_ar) }}</textarea>
            @error('description_ar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Description English -->
        <div>
            <label for="description_en" class="block text-sm font-medium text-gray-700 mb-2">Description (English)</label>
            <textarea id="description_en" name="description_en" rows="3" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description_en', $product->description_en) }}</textarea>
            @error('description_en') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Image -->
        <div>
            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">صورة المنتج</label>
            @if ($product->image)
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name_ar }}" class="max-w-xs h-32 object-cover rounded">
                    <p class="text-xs text-gray-500 mt-2">الصورة الحالية</p>
                </div>
            @endif
            <input type="file" id="image" name="image" accept="image/*"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <p class="text-xs text-gray-500 mt-1">اترك فارغاً للاحتفاظ بالصورة الحالية</p>
            @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex gap-4 pt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">
                حفظ التعديلات
            </button>
            <a href="{{ route('product.show', [$salon, $product]) }}" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-6 rounded-lg transition">
                إلغاء
            </a>
        </div>
    </form>
</div>
@endsection
