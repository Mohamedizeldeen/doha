@extends('superAdmin.layout.app')

@section('page-title', __('admin.add_sales_user'))

@section('content')

<div class="mb-4">
    <a href="{{ route('superAdmin.salesUsers.index') }}" class="text-gray-500 hover:text-gray-700 text-sm inline-flex items-center gap-1">
        <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i>
        {{ __('admin.back') }}
    </a>
</div>

<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-pink-500 to-purple-600 flex items-center justify-center text-white">
                <i class="fas fa-user-plus text-lg"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ __('admin.add_sales_user') }}</h2>
                <p class="text-sm text-gray-500">{{ __('admin.add_sales_user_desc') }}</p>
            </div>
        </div>

        @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('superAdmin.salesUsers.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('admin.name') }} *</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition text-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('admin.email') }} *</label>
                <input type="email" name="email" value="{{ old('email') }}" required dir="ltr"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition text-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('admin.password') }} *</label>
                <input type="password" name="password" required dir="ltr"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition text-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('admin.phone') }}</label>
                <input type="text" name="phone" value="{{ old('phone') }}" dir="ltr"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition text-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('admin.commission_rate') }} (%) *</label>
                <input type="number" name="commission_rate" value="{{ old('commission_rate', 10) }}" step="0.01" min="0" max="100" required
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition text-sm">
                <p class="text-xs text-gray-400 mt-1">{{ __('admin.commission_rate_hint') }}</p>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('superAdmin.salesUsers.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 transition">
                    {{ __('admin.cancel') }}
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-pink-600 to-purple-600 hover:from-pink-700 hover:to-purple-700 transition shadow-lg shadow-pink-200">
                    <i class="fas fa-check me-1"></i> {{ __('admin.create') }}
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
