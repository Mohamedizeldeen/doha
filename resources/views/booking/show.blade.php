@extends('admin.layout.app')

@section('page-title', __('admin.booking_details'))

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">{{ __('admin.booking_details') }}</h2>
    <div class="flex gap-2">
        <a href="{{ route('booking.edit', [$salon, $booking]) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded transition">
            {{ __('admin.edit') }}
        </a>
        <a href="{{ route('booking.index', $salon) }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded transition">
            {{ __('admin.back') }}
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Info -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md p-6 space-y-6">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <h5 class="text-sm font-medium text-gray-600">{{ __('admin.client') }}</h5>
                    <p class="text-lg font-semibold text-gray-900">{{ app()->getLocale() === 'ar' ? $booking->client->name_ar : ($booking->client->name_en ?? $booking->client->name_ar) }}</p>
                    <p class="text-sm text-gray-500">{{ $booking->client->phone }}</p>
                </div>
                <div>
                    <h5 class="text-sm font-medium text-gray-600">{{ __('admin.email') }}</h5>
                    <p class="text-lg font-semibold text-gray-900">{{ $booking->client->email ?? '-' }}</p>
                </div>
            </div>

            <hr class="border-gray-200">

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <h5 class="text-sm font-medium text-gray-600">{{ __('admin.service') }}</h5>
                    <p class="text-lg font-semibold text-gray-900">{{ app()->getLocale() === 'ar' ? $booking->service->name_ar : ($booking->service->name_en ?? $booking->service->name_ar) }}</p>
                    <p class="text-sm text-gray-500">{{ $booking->service->duration_minutes }} {{ __('admin.minutes') }}</p>
                </div>
                <div>
                    <h5 class="text-sm font-medium text-gray-600">{{ __('admin.price') }}</h5>
                    <p class="text-lg font-semibold text-gray-900">{{ $booking->price }} {{ $salon->currency }}</p>
                </div>
            </div>

            <hr class="border-gray-200">

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <h5 class="text-sm font-medium text-gray-600">{{ __('admin.staff_member') }}</h5>
                    @if($booking->staff)
                    <p class="text-lg font-semibold text-gray-900">{{ app()->getLocale() === 'ar' ? $booking->staff->name_ar : ($booking->staff->name_en ?? $booking->staff->name_ar) }}</p>
                    <p class="text-sm text-gray-500">{{ app()->getLocale() === 'ar' ? $booking->staff->position_ar : ($booking->staff->position_en ?? $booking->staff->position_ar) }}</p>
                    @else
                    <p class="text-lg font-semibold text-gray-400">{{ app()->getLocale() === 'ar' ? 'غير محدد' : 'Unassigned' }}</p>
                    @endif
                </div>
                <div>
                    <h5 class="text-sm font-medium text-gray-600">{{ __('admin.email') }}</h5>
                    <p class="text-lg font-semibold text-gray-900">{{ $booking->staff->email ?? '-' }}</p>
                </div>
            </div>

            <hr class="border-gray-200">

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <h5 class="text-sm font-medium text-gray-600">{{ __('admin.date') }}</h5>
                    <p class="text-lg font-semibold text-gray-900">{{ $booking->appointment_datetime->format('Y-m-d') }}</p>
                </div>
                <div>
                    <h5 class="text-sm font-medium text-gray-600">{{ __('admin.time') }}</h5>
                    <p class="text-lg font-semibold text-gray-900">{{ $booking->appointment_datetime->format('H:i') }}</p>
                </div>
            </div>

            @if($booking->notes)
                <hr class="border-gray-200">
                <div>
                    <h5 class="text-sm font-medium text-gray-600">{{ __('admin.notes') }}</h5>
                    <p class="text-gray-700">{{ $booking->notes }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Status Card -->
    <div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h5 class="text-lg font-semibold text-gray-900 mb-4">{{ __('admin.status') }}</h5>
            <p class="inline-block px-4 py-2 rounded-full text-sm font-semibold mb-6 w-full text-center
                @if($booking->status === 'scheduled') bg-blue-100 text-blue-800
                @elseif($booking->status === 'completed') bg-green-100 text-green-800
                @else bg-red-100 text-red-800
                @endif">
                @if($booking->status === 'scheduled') {{ __('admin.pending') }}
                @elseif($booking->status === 'completed') {{ __('admin.completed') }}
                @else {{ __('admin.cancelled') }}
                @endif
            </p>

            <form action="{{ route('booking.status.update', [$salon, $booking]) }}" method="POST" class="space-y-3">
                @csrf @method('PATCH')
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    <option value="scheduled" @selected($booking->status === 'scheduled')>{{ __('admin.pending') }}</option>
                    <option value="completed" @selected($booking->status === 'completed')>{{ __('admin.completed') }}</option>
                    <option value="canceled" @selected($booking->status === 'canceled')>{{ __('admin.cancelled') }}</option>
                </select>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded transition">
                    {{ __('admin.update') }}
                </button>
            </form>

            <hr class="border-gray-200 my-6">

            <form action="{{ route('booking.destroy', [$salon, $booking]) }}" method="POST" onsubmit="return confirm('{{ __('admin.confirm_delete') }}');">
                @csrf @method('DELETE')
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 rounded transition">
                    {{ __('admin.delete') }}
                </button>
            </form>

            <hr class="border-gray-200 my-6">

            {{-- WhatsApp Reminder Section --}}
            <h5 class="text-lg font-semibold text-gray-900 mb-3">{{ __('admin.whatsapp_remind') }}</h5>
            @if($booking->client->phone)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $booking->client->phone) }}?text={{ urlencode(__('admin.whatsapp_reminder_text', ['salon' => (app()->getLocale() === 'ar' ? $salon->name_ar : ($salon->name_en ?? $salon->name_ar)), 'date' => $booking->appointment_datetime->format('Y-m-d'), 'time' => $booking->appointment_datetime->format('H:i')])) }}" target="_blank"
                class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 rounded transition flex items-center justify-center gap-2 mb-3">
                <i class="fab fa-whatsapp text-xl"></i> {{ __('admin.send_whatsapp') }}
            </a>
            @endif
            <form action="{{ route('booking.whatsapp.toggle', [$salon, $booking]) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit" class="w-full py-2 rounded transition font-semibold flex items-center justify-center gap-2 {{ $booking->whatsapp_reminded ? 'bg-green-100 text-green-700 border border-green-300' : 'bg-gray-100 text-gray-500 border border-gray-200 hover:bg-gray-200' }}">
                    <i class="fas {{ $booking->whatsapp_reminded ? 'fa-check-circle' : 'fa-circle' }}"></i>
                    {{ $booking->whatsapp_reminded ? __('admin.reminded') . ' ✓' : __('admin.mark_as_reminded') }}
                </button>
            </form>
            @if($booking->whatsapp_reminded && $booking->whatsapp_reminded_at)
            <p class="text-xs text-gray-400 mt-1 text-center">{{ $booking->whatsapp_reminded_at->format('d/m/Y H:i') }}</p>
            @endif
        </div>
    </div>
</div>
@endsection
