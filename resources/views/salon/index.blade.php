<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('admin.my_salons') }} - ضحي</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            font-family: '{{ app()->getLocale() === 'ar' ? 'Cairo' : 'Inter' }}', sans-serif;
        }
    </style>
</head>
<body>
    <div class="min-h-screen bg-gradient-to-br from-[#fde4f1] to-white">
        <!-- Header -->
        <div class="bg-gradient-to-r from-[#dd208e] to-[#b01670] text-white py-8 sm:py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-bold">{{ __('admin.my_salons') }}</h1>
                    <p class="text-red-100 text-sm sm:text-base mt-2">{{ __('admin.welcome') }} {{ Auth::user()->name }}</p>
                </div>
                <div class="flex gap-3">
                   
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-800 px-4 sm:px-6 py-2 sm:py-3 bg-white bg-opacity-20  font-bold text-xs sm:text-sm sm:text-base rounded-lg hover:bg-opacity-30 transition">
                            {{ __('admin.logout') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 sm:mb-8 p-4 sm:p-6 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-xs sm:text-sm text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Salons List -->
            @if ($salons->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    @foreach ($salons as $salon)
                        <div class="bg-white rounded-lg sm:rounded-2xl shadow-lg hover:shadow-2xl transition p-6 sm:p-8 border border-[#f0b3d8]">
                            <!-- Logo -->
                            @if ($salon->logo)
                                <div class="mb-4 sm:mb-6 h-32 sm:h-40 bg-gray-100 rounded-lg overflow-hidden">
                                    <img src="{{ asset('storage/' . $salon->logo) }}" alt="{{ app()->getLocale() === 'ar' ? $salon->name_ar : ($salon->name_en ?? $salon->name_ar) }}" class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="mb-4 sm:mb-6 h-32 sm:h-40 bg-gradient-to-br from-[#dd208e] to-[#b01670] rounded-lg flex items-center justify-center">
                                    <span class="text-4xl sm:text-5xl">💄</span>
                                </div>
                            @endif

                            <!-- Name -->
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2 sm:mb-3">{{ app()->getLocale() === 'ar' ? $salon->name_ar : ($salon->name_en ?? $salon->name_ar) }}</h3>
                            <p class="text-xs sm:text-sm text-gray-600 mb-4 sm:mb-6">{{ $salon->name_en }}</p>

                            <!-- Status -->
                            <div class="mb-4 sm:mb-6 space-y-2">
                                @if ($salon->isSubscriptionActive())
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                        <span class="text-xs sm:text-sm text-green-700 font-medium">
                                            {{ __('admin.active_status') }}
                                        </span>
                                    </div>
                                @else
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                        <span class="text-xs sm:text-sm text-red-700 font-medium">{{ __('admin.expired_status') }}</span>
                                    </div>
                                @endif

                                <div class="text-xs sm:text-sm text-gray-600">
                                    <span class="font-medium">{{ __('admin.subscription_label') }}</span>
                                    @if ($salon->subscription_type === 'trial')
                                        🎁 {{ __('admin.free_trial') }}
                                    @elseif ($salon->subscription_type === 'monthly')
                                        {{ __('admin.monthly_sub_price') }}
                                    @elseif ($salon->subscription_type === 'yearly')
                                        {{ __('admin.yearly_sub_price') }}
                                    @endif
                                </div>
                            </div>

                            <!-- Dates -->
                            <div class="mb-6 sm:mb-8 p-3 sm:p-4 bg-gray-50 rounded-lg text-xs sm:text-sm text-gray-700 space-y-1">
                                <div><strong>{{ __('admin.start_date') }}:</strong> {{ Carbon\Carbon::parse($salon->subscription_start_date)->format('d/m/Y') }}</div>
                                <div><strong>{{ __('admin.end_date') }}:</strong> {{ Carbon\Carbon::parse($salon->subscription_end_date)->format('d/m/Y') }}</div>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2 sm:gap-3">
                                <a href="{{ route('salon.show', $salon->id) }}" class="flex-1 text-center px-3 sm:px-4 py-2 sm:py-2.5 bg-gradient-to-r from-[#dd208e] to-[#b01670] text-white font-bold text-xs sm:text-sm rounded-lg hover:shadow-lg transition">
                                    {{ __('admin.view') }}
                                </a>
                                <a href="{{ route('salon.edit', $salon->id) }}" class="flex-1 text-center px-3 sm:px-4 py-2 sm:py-2.5 border-2 border-[#dd208e] text-[#dd208e] font-bold text-xs sm:text-sm rounded-lg hover:bg-red-50 transition">
                                    {{ __('admin.edit') }}
                                </a>
                                
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- No Salons -->
                <div class="text-center py-12 sm:py-16">
                    <div class="text-6xl mb-4">🏪</div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-3">{{ __('admin.no_salons') }}</h2>
                    <p class="text-gray-600 mb-8 text-sm sm:text-base">{{ __('admin.no_salons_description') }}</p>
                    <a href="{{ route('salon.create') }}" class="inline-block px-8 py-3 bg-gradient-to-r from-[#dd208e] to-[#b01670] text-white font-bold rounded-lg hover:shadow-xl transition">
                        + {{ __('admin.create_salon') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
