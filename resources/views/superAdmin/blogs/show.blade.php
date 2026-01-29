@extends('superAdmin.layout.app')

@section('page-title', 'عرض المقالة')

@section('content')

<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="mb-8">
            <a href="{{ route('superAdmin.blogs.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                ← العودة إلى المقالات
            </a>
        </div>

        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $blog->name }}</h1>
            
            <div class="flex flex-wrap gap-4 items-center text-sm text-gray-600 mb-6">
                <span class="inline-block bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-semibold">
                    {{ $blog->category ?? 'عام' }}
                </span>
                <span>تم الإنشاء في: {{ $blog->created_at->format('d/m/Y H:i') }}</span>
                <span>آخر تحديث: {{ $blog->updated_at->format('d/m/Y H:i') }}</span>
            </div>

            @if($blog->image)
                <div class="mb-8">
                    <img src="{{ Storage::url($blog->image) }}" alt="{{ $blog->name }}" class="w-full h-96 object-cover rounded-lg">
                </div>
            @endif
        </div>

        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">الوصف المختصر</h2>
            <p class="text-gray-700 leading-relaxed bg-gray-50 p-4 rounded-lg">
                {{ $blog->short_description }}
            </p>
        </div>

        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">محتوى المقالة</h2>
            <div class="text-gray-700 leading-relaxed bg-gray-50 p-6 rounded-lg prose max-w-none">
                {!! nl2br(e($blog->content)) !!}
            </div>
        </div>

        <div class="flex gap-4 pt-8 border-t">
            <a href="{{ route('superAdmin.blogs.edit', $blog->id) }}" class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-medium transition text-center">
                تعديل المقالة
            </a>
            
            <form action="{{ route('superAdmin.blogs.destroy', $blog->id) }}" method="POST" class="flex-1"
                  onsubmit="return confirm('هل أنت متأكد من حذف هذه المقالة؟');">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition">
                    حذف المقالة
                </button>
            </form>

            <a href="{{ route('superAdmin.blogs.index') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg font-medium transition text-center">
                العودة
            </a>
        </div>
    </div>
</div>

@endsection
