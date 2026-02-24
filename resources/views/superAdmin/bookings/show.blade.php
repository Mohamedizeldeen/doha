@extends('superAdmin.layout.app')

@section('page-title', __('admin.booking_details'))

@section('content')

<div class="mb-6">
    <a href="{{ route('superAdmin.bookings.index') }}" class="text-blue-600 hover:text-blue-700 font-medium">← {{ __('admin.back_to_bookings') }}</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Booking Info -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('admin.booking_info') }}</h2>
            
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-gray-600 text-sm">{{ __('admin.booking_number') }}</p>
                    <p class="text-lg font-semibold text-gray-900">#{{ $booking->id }}</p>
                </div>

                <div>
                    <p class="text-gray-600 text-sm">{{ __('admin.status') }}</p>
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold mt-1
                        @if($booking->status === 'completed') bg-green-100 text-green-700
                        @elseif($booking->status === 'scheduled') bg-blue-100 text-blue-700
                        @else bg-red-100 text-red-700 @endif">
                        @switch($booking->status)
                            @case('completed') {{ __('admin.completed_f') }} @break
                            @case('scheduled') {{ __('admin.scheduled_f') }} @break
                            @default {{ __('admin.cancelled_f') }} @endswitch
                    </span>
                </div>

                <div>
                    <p class="text-gray-600 text-sm">{{ __('admin.appointment') }}</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $booking->appointment_datetime->format('d/m/Y H:i') }}</p>
                </div>

                <div>
                    <p class="text-gray-600 text-sm">{{ __('admin.price') }}</p>
                    <p class="text-lg font-semibold text-gray-900">{{ number_format($booking->price ?? 0, 2) }} {{ $booking->salon->currency }}</p>
                </div>

                <div class="col-span-2">
                    <p class="text-gray-600 text-sm">{{ __('admin.notes') }}</p>
                    <p class="text-gray-900 mt-1">{{ $booking->notes ?? __('admin.no_notes') }}</p>
                </div>
            </div>
        </div>

        <!-- Client Info -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">{{ __('admin.client_info') }}</h2>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">{{ __('admin.name') }}:</span>
                    <span class="font-semibold text-gray-900">{{ $booking->client->name_en ?? __('admin.not_specified') }} {{ $booking->client->name_ar ?? __('admin.not_specified') }}</span>
                    
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">{{ __('admin.email') }}:</span>
                    <span class="font-semibold text-gray-900 ltr">{{ $booking->client->email ?? __('admin.not_specified') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">{{ __('admin.phone') }}:</span>
                    <span class="font-semibold text-gray-900 ltr">{{ $booking->client->phone ?? __('admin.not_specified') }}</span>
                </div>
            </div>
        </div>

        <!-- Service & Staff Info -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">{{ __('admin.service_and_staff') }}</h2>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">{{ __('admin.service') }}:</span>
                    <span class="font-semibold text-gray-900">{{ $booking->service->name_ar ?? __('admin.not_specified') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">{{ __('admin.staff_member') }}:</span>
                    <span class="font-semibold text-gray-900">{{ $booking->staff->name_ar ?? __('admin.not_specified') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">{{ __('admin.service_duration') }}:</span>
                    <span class="font-semibold text-gray-900">{{ $booking->service->duration_minutes ?? 0 }} {{ __('admin.minutes') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Salon Info -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">{{ __('admin.salon') }}</h2>
            
            @if($booking->salon->logo)
                <img src="{{ asset('storage/' . $booking->salon->logo) }}" alt="{{ app()->getLocale() === 'ar' ? $booking->salon->name_ar : ($booking->salon->name_en ?? $booking->salon->name_ar) }}" class="w-full h-32 object-cover rounded-lg mb-4">
            @endif

            <div class="space-y-3">
                <div>
                    <p class="text-gray-600 text-sm">{{ __('admin.name') }}</p>
                    <a href="{{ route('superAdmin.salons.show', $booking->salon->id) }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                        {{ app()->getLocale() === 'ar' ? $booking->salon->name_ar : ($booking->salon->name_en ?? $booking->salon->name_ar) }}
                    </a>
                </div>

                <div>
                    <p class="text-gray-600 text-sm">{{ __('admin.phone') }}</p>
                    <p class="font-semibold text-gray-900 ltr">{{ $booking->salon->phone }}</p>
                </div>

                <div>
                    <p class="text-gray-600 text-sm">{{ __('admin.email') }}</p>
                    <p class="font-semibold text-gray-900 ltr">{{ $booking->salon->email }}</p>
                </div>

                <div>
                    <p class="text-gray-600 text-sm">{{ __('admin.address') }}</p>
                    <p class="font-semibold text-gray-900">{{ $booking->salon->address_ar }}</p>
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">{{ __('admin.system_info') }}</h2>
            
            <div class="space-y-3 text-sm">
                <div>
                    <p class="text-gray-600">{{ __('admin.created_at') }}:</p>
                    <p class="font-semibold text-gray-900">{{ $booking->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <div>
                    <p class="text-gray-600">{{ __('admin.last_update') }}:</p>
                    <p class="font-semibold text-gray-900">{{ $booking->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <hr class="border-gray-200 my-4">

            {{-- WhatsApp Reminder --}}
            <h3 class="text-lg font-bold text-gray-900 mb-3">{{ __('admin.whatsapp_remind') }}</h3>
            @if($booking->client->phone ?? false)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $booking->client->phone) }}?text={{ urlencode(__('admin.whatsapp_reminder_text', ['salon' => (app()->getLocale() === 'ar' ? $booking->salon->name_ar : ($booking->salon->name_en ?? $booking->salon->name_ar)), 'date' => $booking->appointment_datetime->format('Y-m-d'), 'time' => $booking->appointment_datetime->format('H:i')])) }}" target="_blank"
                class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 rounded-lg transition flex items-center justify-center gap-2 mb-3">
                <i class="fab fa-whatsapp text-xl"></i> {{ __('admin.send_whatsapp') }}
            </a>
            @endif
            <div class="flex items-center gap-2 {{ $booking->whatsapp_reminded ? 'text-green-600' : 'text-gray-400' }}">
                <i class="fas {{ $booking->whatsapp_reminded ? 'fa-check-circle' : 'fa-circle' }}"></i>
                <span class="text-sm font-medium">{{ $booking->whatsapp_reminded ? __('admin.reminded') : __('admin.not_reminded') }}</span>
                @if($booking->whatsapp_reminded && $booking->whatsapp_reminded_at)
                    <span class="text-xs text-gray-400 ms-auto">{{ $booking->whatsapp_reminded_at->format('d/m H:i') }}</span>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
