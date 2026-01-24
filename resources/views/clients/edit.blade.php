@extends('admin.layout.app')

@section('page-title', 'تعديل العميل')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">تعديل: {{ $client->name_ar }}</h2>
</div>

<div class="bg-white rounded-lg shadow-md p-8 max-w-2xl">
    <form method="POST" action="{{ route('client.update', [$salon, $client]) }}" class="space-y-6">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name Arabic -->
            <div>
                <label for="name_ar" class="block text-sm font-medium text-gray-700 mb-2">الاسم (عربي)</label>
                <input type="text" id="name_ar" name="name_ar" value="{{ $client->name_ar }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('name_ar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Name English -->
            <div>
                <label for="name_en" class="block text-sm font-medium text-gray-700 mb-2">Name (English)</label>
                <input type="text" id="name_en" name="name_en" value="{{ $client->name_en }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('name_en') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">رقم الهاتف</label>
                <input type="tel" id="phone" name="phone" value="{{ $client->phone }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">البريد الإلكتروني</label>
                <input type="email" id="email" name="email" value="{{ $client->email }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Client Code -->
            <div>
                <label for="client_code" class="block text-sm font-medium text-gray-700 mb-2">رمز العميل</label>
                <input type="text" id="client_code" name="client_code" value="{{ $client->client_code }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('client_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex gap-4 pt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">
                حفظ التعديلات
            </button>
            <a href="{{ route('client.show', [$salon, $client]) }}" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-6 rounded-lg transition">
                إلغاء
            </a>
        </div>
    </form>
</div>
@endsection
