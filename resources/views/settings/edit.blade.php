@extends('admin.layout.app')

@section('page-title', __('admin.salon_settings'))

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">{{ __('admin.salon_settings') }}</h2>
    <p class="text-gray-600 mt-2">{{ __('admin.edit_salon_details') }}</p>
</div>

<div class="bg-white rounded-lg shadow-md p-8 max-w-4xl">
    <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf @method('PATCH')

        <!-- Basic Information Section -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-6 pb-4 border-b-2 border-blue-600">{{ __('admin.basic_info') }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name Arabic -->
                <div>
                    <label for="name_ar" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.salon_name_ar') }}</label>
                    <input type="text" id="name_ar" name="name_ar" value="{{ $salon->name_ar }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('name_ar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Name English -->
                <div>
                    <label for="name_en" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.salon_name_en') }}</label>
                    <input type="text" id="name_en" name="name_en" value="{{ $salon->name_en }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('name_en') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Contact Information Section -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-6 pb-4 border-b-2 border-blue-600">{{ __('admin.contact_info') }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.phone_number') }}</label>
                    <input type="tel" id="phone" name="phone" value="{{ $salon->phone }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.email') }}</label>
                    <input type="email" id="email" name="email" value="{{ $salon->email }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Address Section -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-6 pb-4 border-b-2 border-blue-600">{{ __('admin.salon_address') }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Address Arabic -->
                <div>
                    <label for="address_ar" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.address_ar') }}</label>
                    <textarea id="address_ar" name="address_ar" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ $salon->address_ar }}</textarea>
                    @error('address_ar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Address English -->
                <div>
                    <label for="address_en" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.address_en') }}</label>
                    <textarea id="address_en" name="address_en" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ $salon->address_en }}</textarea>
                    @error('address_en') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Description Section -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-6 pb-4 border-b-2 border-blue-600">{{ __('admin.salon_description') }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Description Arabic -->
                <div>
                    <label for="description_ar" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.description_ar_setting') }}</label>
                    <textarea id="description_ar" name="description_ar" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ $salon->description_ar }}</textarea>
                    @error('description_ar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Description English -->
                <div>
                    <label for="description_en" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.description_en_setting') }}</label>
                    <textarea id="description_en" name="description_en" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ $salon->description_en }}</textarea>
                    @error('description_en') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Logo Section -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-6 pb-4 border-b-2 border-blue-600">{{ __('admin.salon_logo') }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.logo_image') }}</label>
                    <input type="file" id="logo" name="logo" accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-2">{{ __('admin.supported_formats') }}</p>
                    @error('logo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                @if ($salon->logo)
                    <div>
                        <p class="text-sm font-medium text-gray-700 mb-2">{{ __('admin.current_logo') }}</p>
                        <img src="{{ asset('storage/' . $salon->logo) }}" alt="{{ app()->getLocale() === 'ar' ? $salon->name_ar : ($salon->name_en ?? $salon->name_ar) }}" class="w-full h-32 object-contain rounded-lg border border-gray-300">
                    </div>
                @endif
            </div>
        </div>

        <!-- Working Hours Section -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-6 pb-4 border-b-2 border-blue-600">{{ __('admin.working_hours') }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Opening Time -->
                <div>
                    <label for="opening_time" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.opening_time') }}</label>
                    <input type="time" id="opening_time" name="opening_time" value="{{ $salon->opening_time }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('opening_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Closing Time -->
                <div>
                    <label for="closing_time" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.closing_time') }}</label>
                    <input type="time" id="closing_time" name="closing_time" value="{{ $salon->closing_time }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('closing_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Currency -->
                <div>
                    <label for="currency" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.currency') }}</label>
                    <select id="currency" name="currency"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="SAR" {{ $salon->currency === 'SAR' ? 'selected' : '' }}>{{ __('admin.currency_sar') }}</option>
                        <option value="AED" {{ $salon->currency === 'AED' ? 'selected' : '' }}>{{ __('admin.currency_aed') }}</option>
                        <option value="EGP" {{ $salon->currency === 'EGP' ? 'selected' : '' }}>{{ __('admin.currency_egp') }}</option>
                        <option value="SDG" {{ $salon->currency === 'SDG' ? 'selected' : '' }}>{{ __('admin.currency_sdg') }}</option>
                        <option value="KWD" {{ $salon->currency === 'KWD' ? 'selected' : '' }}>{{ __('admin.currency_kwd') }}</option>
                        <option value="BHD" {{ $salon->currency === 'BHD' ? 'selected' : '' }}>{{ __('admin.currency_bhd') }}</option>
                        <option value="QAR" {{ $salon->currency === 'QAR' ? 'selected' : '' }}>{{ __('admin.currency_qar') }}</option>
                        <option value="OMR" {{ $salon->currency === 'OMR' ? 'selected' : '' }}>{{ __('admin.currency_omr') }}</option>
                        <option value="JOD" {{ $salon->currency === 'JOD' ? 'selected' : '' }}>{{ __('admin.currency_jod') }}</option>
                        <option value="IQD" {{ $salon->currency === 'IQD' ? 'selected' : '' }}>{{ __('admin.currency_iqd') }}</option>
                        <option value="LBP" {{ $salon->currency === 'LBP' ? 'selected' : '' }}>{{ __('admin.currency_lbp') }}</option>
                        <option value="SYP" {{ $salon->currency === 'SYP' ? 'selected' : '' }}>{{ __('admin.currency_syp') }}</option>
                        <option value="YER" {{ $salon->currency === 'YER' ? 'selected' : '' }}>{{ __('admin.currency_yer') }}</option>
                        <option value="LYD" {{ $salon->currency === 'LYD' ? 'selected' : '' }}>{{ __('admin.currency_lyd') }}</option>
                        <option value="TND" {{ $salon->currency === 'TND' ? 'selected' : '' }}>{{ __('admin.currency_tnd') }}</option>
                        <option value="DZD" {{ $salon->currency === 'DZD' ? 'selected' : '' }}>{{ __('admin.currency_dzd') }}</option>
                        <option value="MAD" {{ $salon->currency === 'MAD' ? 'selected' : '' }}>{{ __('admin.currency_mad') }}</option>
                        <option value="MRU" {{ $salon->currency === 'MRU' ? 'selected' : '' }}>{{ __('admin.currency_mru') }}</option>
                        <option value="SOS" {{ $salon->currency === 'SOS' ? 'selected' : '' }}>{{ __('admin.currency_sos') }}</option>
                        <option value="DJF" {{ $salon->currency === 'DJF' ? 'selected' : '' }}>{{ __('admin.currency_djf') }}</option>
                        <option value="KMF" {{ $salon->currency === 'KMF' ? 'selected' : '' }}>{{ __('admin.currency_kmf') }}</option>
                        <option value="USD" {{ $salon->currency === 'USD' ? 'selected' : '' }}>{{ __('admin.currency_usd') }}</option>
                        <option value="EUR" {{ $salon->currency === 'EUR' ? 'selected' : '' }}>{{ __('admin.currency_eur') }}</option>
                        <option value="GBP" {{ $salon->currency === 'GBP' ? 'selected' : '' }}>{{ __('admin.currency_gbp') }}</option>
                    </select>
                    @error('currency') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Work Days (JSON) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-4">{{ __('admin.working_days') }}</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @php
                        $workDays = is_array($salon->work_days) ? $salon->work_days : (is_string($salon->work_days) ? json_decode($salon->work_days, true) : []);
                        $allDays = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                    @endphp
                    @foreach($allDays as $index => $day)
                        <label class="flex items-center gap-3 p-3 border border-gray-300 rounded-lg hover:bg-blue-50 cursor-pointer">
                            <input type="checkbox" name="work_days[]" value="{{ $day }}"
                                {{ in_array($day, $workDays ?? []) ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                            <span class="text-sm font-medium text-gray-700">{{ __('admin.' . strtolower($day)) }}</span>
                        </label>
                    @endforeach
                </div>
                @error('work_days') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Subscription Information -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-6 pb-4 border-b-2 border-blue-600">{{ __('admin.subscription_info') }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.subscription_type') }}</label>
                    <p class="text-lg font-semibold text-gray-900 px-4 py-2 bg-gray-100 rounded">
                        @if($salon->subscription_type === 'trial') {{ __('admin.trial') }}
                        @elseif($salon->subscription_type === 'monthly') {{ __('admin.monthly_sub') }}
                        @elseif($salon->subscription_type === 'yearly') {{ __('admin.yearly_sub') }}
                        @endif
                    </p>
                </div>

                @if($salon->subscription_start_date)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.start_date') }}</label>
                        <p class="text-lg font-semibold text-gray-900 px-4 py-2 bg-gray-100 rounded">
                            {{ $salon->subscription_start_date->format('Y-m-d') }}
                        </p>
                    </div>
                @endif

                @if($salon->subscription_end_date)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.end_date') }}</label>
                        <p class="text-lg font-semibold text-gray-900 px-4 py-2 bg-gray-100 rounded">
                            {{ $salon->subscription_end_date->format('Y-m-d') }}
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Account Information -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-6 pb-4 border-b-2 border-blue-600">{{ __('admin.account_info') }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.owner_name') }}</label>
                    <p class="text-lg font-semibold text-gray-900 px-4 py-2 bg-gray-100 rounded">
                        {{ $salon->user->name }}
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.account_email') }}</label>
                    <p class="text-lg font-semibold text-gray-900 px-4 py-2 bg-gray-100 rounded">
                        {{ $salon->user->email }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4 pt-8 border-t-2 border-gray-200">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition">
                {{ __('admin.save_changes') }}
            </button>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-3 px-8 rounded-lg transition">
                {{ __('admin.back') }}
            </a>
        </div>
    </form>
</div>
@endsection
