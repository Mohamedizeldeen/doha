@extends('superAdmin.layout.app')

@section('page-title', 'الصالونات')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-900">إدارة الصالونات</h1>
    <a href="{{ route('superAdmin.salons.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition">
        + إضافة صالون جديد
    </a>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">اسم الصالون</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">المالك</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">الهاتف</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">الخدمات</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">الموظفين</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">المنتجات</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">الحجوزات</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">الإيرادات</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">الإجراء</th>
                </tr>
            </thead>
            <tbody>
                @forelse($salons as $salon)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $salon->name_ar }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $salon->user->name ?? 'غير محدد' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700 ltr">{{ $salon->phone }}</td>
                        <td class="px-6 py-4 text-sm text-center">
                            <span class="inline-block bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $salon->services_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-center">
                            <span class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $salon->staff_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-center">
                            <span class="inline-block bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $salon->products_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-center">
                            <span class="inline-block bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $salon->bookings_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-center font-semibold text-gray-900">
                            {{ number_format($salon->revenue, 2) }}
                        </td>
                        <td class="px-6 py-4 text-sm text-center">
                            <div class="flex justify-center items-center gap-3 flex-row-reverse">
                                <a href="{{ route('superAdmin.salons.show', $salon->id) }}"
                                   aria-label="عرض الصالون"
                                   class="inline-flex items-center justify-center bg-white border border-blue-500 text-blue-600 hover:bg-blue-50 px-3 py-2 rounded-lg text-sm font-semibold shadow-sm transition focus:outline-none focus:ring-2 focus:ring-blue-300">
                                    عرض
                                </a>

                                <a href="{{ route('superAdmin.salons.edit', $salon->id) }}"
                                   aria-label="تعديل الصالون"
                                   class="inline-flex items-center justify-center bg-white border border-yellow-500 text-yellow-600 hover:bg-yellow-50 px-3 py-2 rounded-lg text-sm font-semibold shadow-sm transition focus:outline-none focus:ring-2 focus:ring-yellow-300">
                                    تعديل
                                </a>

                                <form action="{{ route('superAdmin.salons.destroy', $salon->id) }}" method="POST"
                                      class="inline"
                                      onsubmit="return confirm('هل أنت متأكد من حذف هذا الصالون؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            aria-label="حذف الصالون"
                                            class="inline-flex items-center justify-center bg-red-600 text-white hover:bg-red-700 px-3 py-2 rounded-lg text-sm font-semibold shadow-sm transition focus:outline-none focus:ring-2 focus:ring-red-300">
                                        حذف
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-8 text-center text-gray-500">لا توجد صالونات في النظام</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $salons->links() }}
</div>

@endsection
