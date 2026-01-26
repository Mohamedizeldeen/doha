@extends('superAdmin.layout.app')

@section('page-title', 'عرض الرسالة')

@section('content')

<div class="mb-6">
    <a href="{{ route('superAdmin.contacts.index') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m7-7l-7 7 7 7"></path>
        </svg>
        العودة إلى الرسائل
    </a>
</div>

<div class="grid grid-cols-1 gap-6">
    <!-- Contact Details -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ $contact->name }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Left Column -->
            <div>
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">الاسم</label>
                    <p class="text-lg text-gray-900">{{ $contact->name }}</p>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">البريد الإلكتروني</label>
                    <a href="mailto:{{ $contact->email }}" class="text-lg text-blue-600 hover:text-blue-700 break-all">
                        {{ $contact->email }}
                    </a>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">الهاتف</label>
                    @if($contact->phone)
                        <a href="tel:{{ $contact->phone }}" class="text-lg text-blue-600 hover:text-blue-700">
                            {{ $contact->phone }}
                        </a>
                    @else
                        <p class="text-lg text-gray-500">غير متوفر</p>
                    @endif
                </div>
            </div>

            <!-- Right Column -->
            <div>
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">الموضوع</label>
                    <p class="text-lg text-gray-900">{{ $contact->title ?? 'بدون موضوع' }}</p>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">تاريخ الإرسال</label>
                    <p class="text-lg text-gray-900">{{ $contact->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Message -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">الرسالة</label>
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <p class="text-gray-900 whitespace-pre-wrap leading-relaxed">
                    {{ $contact->message ?? 'بدون رسالة' }}
                </p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 flex-row-reverse pt-6 border-t border-gray-200">
            <form action="{{ route('superAdmin.contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه الرسالة؟');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold shadow-md transition focus:outline-none focus:ring-2 focus:ring-red-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    حذف الرسالة
                </button>
            </form>

            <a href="{{ route('superAdmin.contacts.index') }}" class="inline-flex items-center gap-2 bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg font-semibold shadow-md transition">
                العودة
            </a>
        </div>
    </div>
</div>

@endsection
