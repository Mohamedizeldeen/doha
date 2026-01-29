@extends('superAdmin.layout.app')

@section('page-title', 'المقالات')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-900">إدارة المقالات</h1>
    <a href="{{ route('superAdmin.blogs.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition">
        + إضافة مقالة جديدة
    </a>
</div>

@if ($message = Session::get('success'))
    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        {{ $message }}
    </div>
@endif

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">عنوان المقالة</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">الفئة</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">الصورة</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">الوصف</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">تاريخ الإنشاء</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">الإجراء</th>
                </tr>
            </thead>
            <tbody>
                @forelse($blogs as $blog)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $blog->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <span class="inline-block bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $blog->category ?? 'عام' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-center">
                            @if($blog->image)
                                <img src="{{ Storage::url($blog->image) }}" alt="{{ $blog->name }}" class="h-12 w-12 object-cover rounded">
                            @else
                                <span class="text-gray-500">بدون صورة</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 truncate max-w-xs">
                            {{ Str::limit($blog->short_description, 50) }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 text-center">
                            {{ $blog->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-center">
                            <div class="flex justify-center items-center gap-3 flex-row-reverse">
                                <a href="{{ route('superAdmin.blogs.edit', $blog->id) }}"
                                   aria-label="تعديل المقالة"
                                   class="inline-flex items-center justify-center bg-white border border-yellow-500 text-yellow-600 hover:bg-yellow-50 px-3 py-2 rounded-lg text-sm font-semibold shadow-sm transition focus:outline-none focus:ring-2 focus:ring-yellow-300">
                                    تعديل
                                </a>

                                <form action="{{ route('superAdmin.blogs.destroy', $blog->id) }}" method="POST"
                                      class="inline"
                                      onsubmit="return confirm('هل أنت متأكد من حذف هذه المقالة؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            aria-label="حذف المقالة"
                                            class="inline-flex items-center justify-center bg-red-600 text-white hover:bg-red-700 px-3 py-2 rounded-lg text-sm font-semibold shadow-sm transition focus:outline-none focus:ring-2 focus:ring-red-300">
                                        حذف
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">لا توجد مقالات في النظام</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $blogs->links() }}
</div>

@endsection
