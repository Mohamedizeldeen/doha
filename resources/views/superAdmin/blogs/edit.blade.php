@extends('superAdmin.layout.app')

@section('page-title', 'تعديل المقالة')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">تعديل المقالة</h1>

        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('superAdmin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PATCH')

            <!-- Title -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">عنوان المقالة *</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="{{ old('name', $blog->name) }}" required>
                @error('name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">الفئة</label>
                <input type="text" name="category" id="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="مثال: تقنية، نصائح، إلخ" value="{{ old('category', $blog->category) }}">
                @error('category')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Short Description -->
            <div>
                <label for="short_description" class="block text-sm font-medium text-gray-700 mb-2">الوصف المختصر *</label>
                <textarea name="short_description" id="short_description" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>{{ old('short_description', $blog->short_description) }}</textarea>
                @error('short_description')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">محتوى المقالة *</label>
                <textarea name="content" id="content" rows="6" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 font-mono text-sm" required>{{ old('content', $blog->content) }}</textarea>
                <p class="text-xs text-gray-500 mt-1">يمكنك استخدام أي نص أو HTML</p>
                @error('content')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Image -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">صورة المقالة</label>
                @if($blog->image)
                    <div class="mb-4">
                        <img src="{{ Storage::url($blog->image) }}" alt="{{ $blog->name }}" class="h-40 w-full object-cover rounded">
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
                <a href="{{ route('superAdmin.blogs.index') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg font-medium transition text-center">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
