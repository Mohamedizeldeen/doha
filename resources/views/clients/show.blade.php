@extends('admin.layout.app')

@section('page-title', __('admin.client_details'))

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">{{ app()->getLocale() === 'ar' ? $client->name_ar : ($client->name_en ?? $client->name_ar) }}</h2>
    <div class="flex gap-3">
        <a href="{{ route('client.edit', [$salon, $client]) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg transition">
            <i class="fas fa-edit ml-2"></i>{{ __('admin.edit') }}
        </a>
        <a href="{{ route('client.index', $salon) }}" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-lg transition">
            <i class="fas fa-arrow-right ml-2"></i>{{ __('admin.back') }}
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Client Information -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md p-8 mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-6">{{ __('admin.client_info') }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h4 class="text-sm font-medium text-gray-600 mb-2"> {{ __('admin.client_name') }}</h4>
                    <p class="text-xl font-bold text-gray-800">{{ app()->getLocale() === 'ar' ? $client->name_ar : ($client->name_en ?? $client->name_ar) }}</p>
                </div>

                

                <div>
                    <h4 class="text-sm font-medium text-gray-600 mb-2">{{ __('admin.phone') }}</h4>
                    <p class="text-lg font-medium text-gray-800">{{ $client->phone }}</p>
                </div>

                <div>
                    <h4 class="text-sm font-medium text-gray-600 mb-2">{{ __('admin.email') }}</h4>
                    <p class="text-lg text-blue-600">{{ $client->email }}</p>
                </div>

                <div>
                    <h4 class="text-sm font-medium text-gray-600 mb-2">{{ __('admin.client_code') }}</h4>
                    <p class="text-lg font-bold text-purple-600">{{ $client->client_code }}</p>
                </div>

                <div>
                    <h4 class="text-sm font-medium text-gray-600 mb-2">{{ __('admin.created_at') }}</h4>
                    <p class="text-gray-800">{{ $client->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Booking History -->
        @if ($client->bookings->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-8">
                <h3 class="text-lg font-bold text-gray-800 mb-6">{{ __('admin.booking_history') }}</h3>
                <div class="space-y-4">
                    @foreach ($client->bookings as $booking)
                        <div class="border-l-4 border-blue-500 bg-blue-50 p-4 rounded">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-gray-800">{{ app()->getLocale() === 'ar' ? $booking->service->name_ar : ($booking->service->name_en ?? $booking->service->name_ar) }}</h4>
                                    <p class="text-sm text-gray-600">{{ __('admin.staff_member') }}: {{ app()->getLocale() === 'ar' ? $booking->staff->name_ar : ($booking->staff->name_en ?? $booking->staff->name_ar) }}</p>
                                    <p class="text-sm text-gray-600">{{ $booking->appointment_datetime->format('d/m/Y H:i') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-green-600">{{ $booking->service->price }} {{ $salon->currency }}</p>
                                    <span class="text-xs px-3 py-1 rounded-full {{ $booking->status == 'completed' ? 'bg-green-100 text-green-800' : ($booking->status == 'scheduled' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                         @switch($booking->status)
                                            @case('completed')
                                                {{ __('admin.completed') }}
                                                @break
                                            @case('scheduled')
                                                {{ __('admin.scheduled') }}
                                                @break
                                            @default
                                                {{ __('admin.cancelled') }}
                                        @endswitch
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <p class="text-gray-600">{{ __('admin.no_bookings_client') }}</p>
            </div>
        @endif
    </div>

    <!-- Statistics -->
    <div>
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-6">{{ __('admin.statistics') }}</h3>
            
            <div class="space-y-4">
                <div class="text-center">
                    <h4 class="text-sm text-gray-600 mb-1">{{ __('admin.total_bookings') }}</h4>
                    <p class="text-3xl font-bold text-blue-600">{{ $client->bookings->count() }}</p>
                </div>

                @php
                    $completedBookings = $client->bookings->where('status', 'completed');
                    $totalSpent = $completedBookings->sum('price');
                @endphp

                <div class="text-center border-t pt-4">
                    <h4 class="text-sm text-gray-600 mb-1">{{ __('admin.completed_bookings') }}</h4>
                    <p class="text-3xl font-bold text-green-600">{{ $completedBookings->count() }}</p>
                </div>

                  <div class="text-center border-t pt-4">
                    <h4 class="text-sm text-gray-600 mb-1">{{ __('admin.scheduled_bookings') }}</h4>
                    <p class="text-3xl font-bold text-yellow-600">{{ $client->bookings->where('status', 'scheduled')->count() }}</p>
                </div>

                 <div class="text-center border-t pt-4">
                    <h4 class="text-sm text-gray-600 mb-1">{{ __('admin.cancelled_bookings') }}</h4>
                    <p class="text-3xl font-bold text-red-600">{{ $client->bookings->where('status', 'canceled')->count() }}</p>
                </div>

                <div class="text-center border-t pt-4">
                    <h4 class="text-sm text-gray-600 mb-1">{{ __('admin.total_spending') }}</h4>
                    <p class="text-2xl font-bold text-purple-600">{{ number_format($totalBookingsMoney, 2) }} {{ $salon->currency }}</p>

                </div>

               
            </div>
        </div>
    </div>
</div>
@endsection
