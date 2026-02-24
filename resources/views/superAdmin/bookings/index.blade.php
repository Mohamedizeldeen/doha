@extends('superAdmin.layout.app')

@section('page-title', __('admin.bookings'))

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-900">{{ __('admin.manage_bookings') }}</h1>
</div>

<!-- Filter Form -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.salon') }}</label>
            <select name="salon_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">{{ __('admin.all') }}</option>
                @foreach($salons as $salon)
                    <option value="{{ $salon->id }}" {{ request('salon_id') == $salon->id ? 'selected' : '' }}>
                        {{ app()->getLocale() === 'ar' ? $salon->name_ar : ($salon->name_en ?? $salon->name_ar) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.status') }}</label>
            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">{{ __('admin.all') }}</option>
                <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>{{ __('admin.scheduled_f') }}</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('admin.completed_f') }}</option>
                <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>{{ __('admin.cancelled_f') }}</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.date_from') }}</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.date_to') }}</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="flex items-end gap-2">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition">
                {{ __('admin.search') }}
            </button>
            <a href="{{ route('superAdmin.bookings.index') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg font-medium transition text-center">
                {{ __('admin.clear') }}
            </a>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">{{ __('admin.salon') }}</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">{{ __('admin.client') }}</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">{{ __('admin.service') }}</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">{{ __('admin.appointment') }}</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">{{ __('admin.price') }}</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">{{ __('admin.status') }}</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">{{ __('admin.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ app()->getLocale() === 'ar' ? $booking->salon->name_ar : ($booking->salon->name_en ?? $booking->salon->name_ar) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $booking->client->name_ar ?? __('admin.not_specified') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $booking->service->name_ar ?? __('admin.not_specified') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $booking->appointment_datetime->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 text-sm text-center font-semibold">
                            {{ number_format($booking->price ?? 0, 2) }} {{ $booking->salon->currency }}
                        </td>
                        <td class="px-6 py-4 text-sm text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($booking->status === 'completed') bg-green-100 text-green-700
                                @elseif($booking->status === 'scheduled') bg-blue-100 text-blue-700
                                @else bg-red-100 text-red-700 @endif">
                                @switch($booking->status)
                                    @case('completed') {{ __('admin.completed_f') }} @break
                                    @case('scheduled') {{ __('admin.scheduled_f') }} @break
                                    @default {{ __('admin.cancelled_f') }} @endswitch
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-center">
                            <div class="flex justify-center items-center gap-3 flex-row-reverse">
                                <a href="{{ route('superAdmin.bookings.show', $booking->id) }}"
                                   aria-label="{{ __('admin.view') }}"
                                   class="inline-flex items-center justify-center bg-white border border-blue-500 text-blue-600 hover:bg-blue-50 px-3 py-2 rounded-lg text-sm font-semibold shadow-sm transition focus:outline-none focus:ring-2 focus:ring-blue-300">
                                    {{ __('admin.view') }}
                                </a>

                               

                                <form action="{{ route('superAdmin.bookings.destroy', $booking->id) }}" method="POST"
                                      class="inline"
                                      onsubmit="return confirm('{{ __('admin.confirm_delete_booking') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            aria-label="{{ __('admin.delete') }}"
                                            class="inline-flex items-center justify-center bg-red-600 text-white hover:bg-red-700 px-3 py-2 rounded-lg text-sm font-semibold shadow-sm transition focus:outline-none focus:ring-2 focus:ring-red-300">
                                        {{ __('admin.delete') }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">{{ __('admin.no_bookings') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $bookings->links() }}
</div>

@endsection
