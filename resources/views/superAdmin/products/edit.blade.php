@extends('superAdmin.layout.app')

@section('page-title', 'تعديل المنتج')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">تعديل المنتج</h1>

        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('superAdmin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PATCH')

            <!-- Salon Info (Read-only) -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">الصالون</p>
                <p class="text-lg font-semibold text-gray-900">{{ $product->salon->name_ar }}</p>
            </div>

            <!-- Name English -->
            <div>
                <label for="name_en" class="block text-sm font-medium text-gray-700 mb-2">اسم المنتج (إنجليزي) *</label>
                <input type="text" name="name_en" id="name_en" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="{{ old('name_en', $product->name_en) }}" required>
                @error('name_en')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Name Arabic -->
            <div>
                <label for="name_ar" class="block text-sm font-medium text-gray-700 mb-2">اسم المنتج (عربي) *</label>
                <input type="text" name="name_ar" id="name_ar" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="{{ old('name_ar', $product->name_ar) }}" required>
                @error('name_ar')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description English -->
            <div>
                <label for="description_en" class="block text-sm font-medium text-gray-700 mb-2">الوصف (إنجليزي) *</label>
                <textarea name="description_en" id="description_en" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>{{ old('description_en', $product->description_en) }}</textarea>
                @error('description_en')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description Arabic -->
            <div>
                <label for="description_ar" class="block text-sm font-medium text-gray-700 mb-2">الوصف (عربي) *</label>
                <textarea name="description_ar" id="description_ar" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>{{ old('description_ar', $product->description_ar) }}</textarea>
                @error('description_ar')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Price -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">السعر *</label>
                <div class="flex gap-2">
                    <input type="number" name="price" id="price" step="0.01" min="0" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="{{ old('price', $product->price) }}" required>
                    <div class="flex items-center px-4 py-2 bg-gray-100 rounded-lg">
                        <span class="text-gray-700 font-medium">{{ $product->salon->currency }}</span>
                    </div>
                </div>
                @error('price')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Stock Quantity -->
            <div>
                <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-2">الكمية المتوفرة *</label>
                <input type="number" name="stock_quantity" id="stock_quantity" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
                @error('stock_quantity')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Image -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">صورة المنتج</label>
                @if($product->image)
                    <div class="mb-4">
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name_ar }}" class="h-40 w-40 object-cover rounded">
                        <p class="text-sm text-gray-600 mt-2">الصورة الحالية</p>
                    </div>
                @endif
                <input type="file" name="image" id="image" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" accept="image/*">
                <p class="text-sm text-gray-600 mt-2">اترك فارغاً للاحتفاظ بالصورة الحالية</p>
                @error('image')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition">
                    حفظ التغييرات
                </button>
                <a href="{{ route('superAdmin.products.show', $product->id) }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg font-medium transition text-center">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
