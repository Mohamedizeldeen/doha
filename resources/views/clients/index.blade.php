@extends('admin.layout.app')

@section('page-title', 'العملاء')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <h2 class="text-xl sm:text-2xl font-bold text-gray-800">العملاء</h2>
    <a href="{{ route('client.create', $salon) }}" class="bg-gray-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition text-sm sm:text-base">
        <i class="fas fa-plus ml-2"></i>إضافة عميل
    </a>
</div>

@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 gap-4 md:gap-6">
    @forelse ($clients as $client)
        <div class="bg-white rounded-lg shadow-md p-4 md:p-6 hover:shadow-lg transition">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-1">{{ $client->name_ar }}</h3>
                    <p class="text-gray-600 mb-3 text-sm md:text-base">{{ $client->name_en }}</p>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-4 text-xs md:text-sm">
                        <div>
                            <span class="text-gray-600 block">الرمز:</span>
                            <p class="font-medium">{{ $client->client_code }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600 block">الهاتف:</span>
                            <p class="font-medium">{{ $client->phone }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600 block">البريد:</span>
                            <p class="font-medium text-gray-600 text-xs md:text-sm">{{ $client->email }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600 block">الحجوزات:</span>
                            <p class="font-medium">{{ $client->bookings->count() }} حجز</p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-2 flex-wrap self-start">
                    <a href="{{ route('client.edit', [$salon, $client]) }}" class="inline-flex items-center justify-center bg-gray-500 hover:bg-yellow-600 text-white py-1.5 px-2 md:py-2 md:px-3 rounded transition text-xs md:text-sm whitespace-nowrap">
                        تعديل
                    </a>
                    <a href="{{ route('client.show', [$salon, $client]) }}" class="inline-flex items-center justify-center bg-gray-500 hover:bg-blue-600 text-white py-1.5 px-2 md:py-2 md:px-3 rounded transition text-xs md:text-sm whitespace-nowrap">
                        عرض
                    </a>
                    <form method="POST" action="{{ route('client.destroy', [$salon, $client]) }}" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="inline-flex items-center justify-center bg-gray-500 hover:bg-red-600 text-white py-1.5 px-2 md:py-2 md:px-3 rounded transition text-xs md:text-sm whitespace-nowrap" onclick="return confirm('هل أنت متأكد؟')">
                            حذف
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-12 bg-white rounded-lg">
            <p class="text-gray-600 text-lg">لا يوجد عملاء حالياً</p>
        </div>
    @endforelse
</div>
@endsection
