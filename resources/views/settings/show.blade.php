@extends('admin.layout.app')

@section('page-title', __('admin.view_settings'))

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">{{ __('admin.salon_settings') }}</h2>
    <p class="text-gray-600 mt-2">{{ __('admin.current_salon_details') }}</p>
</div>

<!-- Success Message -->
@if (session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
        <p class="text-green-800 font-medium">✓ {{ session('success') }}</p>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column - Logo and Main Info -->
    <div class="lg:col-span-2">
        <!-- Logo Section -->
        @if ($salon->logo)
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('admin.salon_logo') }}</h3>
                <div class="flex justify-center">
                    <img src="{{ asset('storage/' . $salon->logo) }}" alt="{{ app()->getLocale() === 'ar' ? $salon->name_ar : ($salon->name_en ?? $salon->name_ar) }}" class="h-48 w-48 object-contain rounded-lg border border-gray-200">
                </div>
            </div>
        @endif

        <!-- Information Sections -->
        <div class="space-y-6">
            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 pb-4 border-b-2 border-blue-600">{{ __('admin.basic_info') }}</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('admin.salon_name_ar') }}</label>
                        <p class="text-lg text-gray-900 mt-2">{{ $salon->name_ar }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('admin.salon_name_en') }}</label>
                        <p class="text-lg text-gray-900 mt-2">{{ $salon->name_en }}</p>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 pb-4 border-b-2 border-blue-600">{{ __('admin.contact_info') }}</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('admin.phone_number') }}</label>
                        <p class="text-lg text-gray-900 mt-2 ltr">{{ $salon->phone ?? __('admin.not_specified') }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('admin.email') }}</label>
                        <p class="text-lg text-gray-900 mt-2 ltr">{{ $salon->email ?? __('admin.not_specified') }}</p>
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 pb-4 border-b-2 border-blue-600">{{ __('admin.salon_address') }}</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('admin.address_ar') }}</label>
                        <p class="text-gray-900 mt-2 whitespace-pre-line">{{ $salon->address_ar ?? __('admin.not_specified') }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('admin.address_en') }}</label>
                        <p class="text-gray-900 mt-2 whitespace-pre-line ltr">{{ $salon->address_en ?? __('admin.not_specified') }}</p>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 pb-4 border-b-2 border-blue-600">{{ __('admin.salon_description') }}</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('admin.description_ar_setting') }}</label>
                        <p class="text-gray-900 mt-2 whitespace-pre-line">{{ $salon->description_ar ?? __('admin.not_specified') }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('admin.description_en_setting') }}</label>
                        <p class="text-gray-900 mt-2 whitespace-pre-line ltr">{{ $salon->description_en ?? __('admin.not_specified') }}</p>
                    </div>
                </div>
            </div>

            <!-- Change Password Section -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 pb-4 border-b-2 border-[#dd208e]">
                    <i class="fas fa-key text-[#dd208e] {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                    {{ __('auth.change_password') }}
                </h3>

                <!-- Password Change Success -->
                @if (session('password_success'))
                    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                        <p class="text-green-800 font-medium">✓ {{ session('password_success') }}</p>
                    </div>
                @endif

                <!-- Password Change Errors -->
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                        @foreach ($errors->all() as $error)
                            <p class="text-red-700 text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('change-password') }}" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">{{ __('auth.current_password') }}</label>
                        <div class="relative">
                            <input type="password" name="current_password" id="current_password" required
                                   class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-[#dd208e] focus:ring-0 focus:outline-none transition text-sm"
                                   placeholder="{{ __('auth.current_password_placeholder') }}">
                            <button type="button" onclick="togglePw('current_password', 'cp-icon')"
                                    class="absolute top-1/2 -translate-y-1/2 {{ app()->getLocale() === 'ar' ? 'left-3' : 'right-3' }} text-gray-400 hover:text-[#dd208e]">
                                <i id="cp-icon" class="fas fa-eye text-sm"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">{{ __('auth.new_password') }}</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" required
                                   class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-[#dd208e] focus:ring-0 focus:outline-none transition text-sm"
                                   placeholder="{{ __('auth.new_password_placeholder') }}">
                            <button type="button" onclick="togglePw('password', 'np-icon')"
                                    class="absolute top-1/2 -translate-y-1/2 {{ app()->getLocale() === 'ar' ? 'left-3' : 'right-3' }} text-gray-400 hover:text-[#dd208e]">
                                <i id="np-icon" class="fas fa-eye text-sm"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">{{ __('auth.confirm_new_password') }}</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                   class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-[#dd208e] focus:ring-0 focus:outline-none transition text-sm"
                                   placeholder="{{ __('auth.confirm_new_password_placeholder') }}">
                            <button type="button" onclick="togglePw('password_confirmation', 'cnp-icon')"
                                    class="absolute top-1/2 -translate-y-1/2 {{ app()->getLocale() === 'ar' ? 'left-3' : 'right-3' }} text-gray-400 hover:text-[#dd208e]">
                                <i id="cnp-icon" class="fas fa-eye text-sm"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="w-full px-6 py-2.5 text-white font-medium rounded-lg transition text-sm"
                            style="background: linear-gradient(135deg, #dd208e, #b01670);">
                        <i class="fas fa-save {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}"></i>
                        {{ __('auth.change_password_button') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Right Column - Summary & Actions -->
    <div>
        <!-- Account Summary -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6 sticky top-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 pb-4 border-b-2 border-blue-600">{{ __('admin.account_summary') }}</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('admin.account_owner') }}</label>
                    <p class="text-gray-900 font-medium mt-2">{{ $salon->user?->name ?? 'N/A' }}</p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('admin.owner_email') }}</label>
                    <p class="text-gray-900 ltr mt-2">{{ $salon->user?->email ?? 'N/A' }}</p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('admin.created_at') }}</label>
                    <p class="text-gray-900 mt-2">{{ $salon->created_at->format('d/m/Y') }}</p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('admin.last_update') }}</label>
                    <p class="text-gray-900 mt-2">{{ $salon->updated_at->format('d/m/Y H:i') }}</p>
                </div>

                 <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('admin.working_hours') }}</label>
                    <p class="text-gray-900 mt-2">{{ __('admin.from_time') }} {{ \Carbon\Carbon::parse($salon->opening_time)->format('H:i') }} - {{ __('admin.to_time') }} {{ \Carbon\Carbon::parse($salon->closing_time)->format('H:i') }}</p>
                </div>

                 <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('admin.currency') }}</label>
                    <p class="text-gray-900 mt-2">{{ $salon->currency }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('admin.subscription_end') }}</label>
                    <p class="text-gray-900 mt-2">{{ \Carbon\Carbon::parse($salon->subscription_end_date)->format('d/m/Y') }}</p>
                </div>
                 <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('admin.subscription_type') }}</label>
                    <p class="text-gray-900 mt-2">{{ $salon->subscription_type }}</p>
                </div>
                 <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('admin.working_days') }}</label>
                    <p class="text-gray-900 mt-2">{{ is_array($workDays = json_decode($salon->work_days, true)) ? implode(', ', $workDays) : __('admin.not_specified') }}</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 space-y-3">
                <a href="{{ route('settings.edit') }}" class="w-full inline-block bg-blue-600 text-white font-medium px-4 py-2 rounded-lg hover:bg-blue-700 transition text-center">
                    ✎ {{ __('admin.edit_settings') }}
                </a>
                
                <a href="{{ route('admin.dashboard') }}" class="w-full inline-block bg-gray-600 text-white font-medium px-4 py-2 rounded-lg hover:bg-gray-700 transition text-center">
                    ← {{ __('admin.back_to_dashboard') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePw(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
@endpush
