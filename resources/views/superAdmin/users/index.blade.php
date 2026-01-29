@extends('superAdmin.layout.app')

@section('page-title', 'المستخدمين')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-900">إدارة المستخدمين</h1>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">الاسم</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">الدور</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">الايميل</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">كلمة السر</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">تاريخ الإنشاء</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">الإجراء</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <span class="inline-block bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                            {{ $user->email }}
                        </td>
                      
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                            {{ $user->password }}
                        </td>
                    
                        <td class="px-6 py-4 text-sm text-gray-600 text-center">
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-center">
                            <div class="flex justify-center items-center gap-3 flex-row-reverse">
                              

                        

                                <form action="{{ route('superAdmin.users.destroy', $user->id) }}" method="POST"
                                      class="inline"
                                      onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            aria-label="حذف المستخدم"
                                            class="inline-flex items-center justify-center bg-red-600 text-white hover:bg-red-700 px-3 py-2 rounded-lg text-sm font-semibold shadow-sm transition focus:outline-none focus:ring-2 focus:ring-red-300">
                                        حذف
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">لا يوجد مستخدمين في النظام</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>



@endsection
