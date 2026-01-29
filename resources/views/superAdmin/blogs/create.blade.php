@extends('superAdmin.layout.app')

@section('page-title', 'إنشاء مقالة جديدة')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">إنشاء مقالة جديدة</h1>

        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('superAdmin.blogs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Title -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">عنوان المقالة *</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="أدخل عنوان المقالة" value="{{ old('name') }}" required>
                @error('name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">الفئة</label>
                <input type="text" name="category" id="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="مثال: تقنية، نصائح، إلخ" value="{{ old('category') }}">
                @error('category')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Short Description -->
            <div>
                <label for="short_description" class="block text-sm font-medium text-gray-700 mb-2">الوصف المختصر *</label>
                <textarea name="short_description" id="short_description" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="أدخل وصفاً مختصراً للمقالة" required>{{ old('short_description') }}</textarea>
                @error('short_description')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">محتوى المقالة *</label>
                <textarea name="content" id="content" rows="8" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 font-mono text-sm" placeholder="أدخل محتوى المقالة هنا" required>{{ old('content') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">يمكنك استخدام أي نص أو HTML</p>
                @error('content')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Image -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">صورة المقالة</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition cursor-pointer" id="image-drop-zone">
                    <input type="file" name="image" id="image" class="hidden" accept="image/*">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v4a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32 0h-9.172a2 2 0 00-1.414.586l-7.071 7.071a2 2 0 01-2.828 0l-7.071-7.071A2 2 0 006.172 20H4m32 0a2 2 0 012 2v10a2 2 0 01-2 2m0-14H4m32 0H4m0 0a2 2 0 00-2 2v10a2 2 0 002 2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <p class="mt-2 text-sm font-medium text-gray-700">اسحب الصورة هنا أو انقر للاختيار</p>
                    <p class="text-xs text-gray-500">PNG, JPG, GIF (حد أقصى 2MB)</p>
                </div>
                <div id="image-preview" class="mt-4 hidden">
                    <img id="preview-img" src="" alt="preview" class="h-40 w-full object-cover rounded-lg">
                </div>
                @error('image')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition">
                    إنشاء المقالة
                </button>
                <a href="{{ route('superAdmin.blogs.index') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg font-medium transition text-center">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Image upload handling
    const imageDropZone = document.getElementById('image-drop-zone');
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');

    // Click to select
    imageDropZone.addEventListener('click', () => imageInput.click());

    // Drag and drop
    imageDropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        imageDropZone.classList.add('border-blue-500', 'bg-blue-50');
    });

    imageDropZone.addEventListener('dragleave', () => {
        imageDropZone.classList.remove('border-blue-500', 'bg-blue-50');
    });

    imageDropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        imageDropZone.classList.remove('border-blue-500', 'bg-blue-50');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            imageInput.files = files;
            handleImageSelect();
        }
    });

    // File input change
    imageInput.addEventListener('change', handleImageSelect);

    function handleImageSelect() {
        const file = imageInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImg.src = e.target.result;
                imagePreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }
</script>

@endsection
