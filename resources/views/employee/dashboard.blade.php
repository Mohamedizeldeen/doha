@extends('admin.layout.app')

@section('page-title', __('admin.employee_dashboard'))

@section('content')
<!-- Welcome -->
<div style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border-radius: 1rem; padding: 1.5rem; margin-bottom: 1.5rem; color: #fff;">
    <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.25rem;">
        {{ __('admin.welcome') }}, {{ auth()->user()->name }}
    </h2>
    <p style="font-size: 0.85rem; opacity: 0.8;">{{ now()->format('l, d M Y') }}</p>
</div>

<!-- Stats -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
    <div style="background: #fff; border-radius: 1rem; padding: 1rem; border: 1px solid #e5e7eb;">
        <div style="font-size: 0.7rem; color: #6b7280;">{{ __('admin.today_bookings') }}</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary);">{{ $todayBookings }}</div>
    </div>
    <div style="background: #fff; border-radius: 1rem; padding: 1rem; border: 1px solid #e5e7eb;">
        <div style="font-size: 0.7rem; color: #6b7280;">{{ __('admin.pending_bookings') }}</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: #d97706;">{{ $pendingBookings }}</div>
    </div>
    <div style="background: #fff; border-radius: 1rem; padding: 1rem; border: 1px solid #e5e7eb;">
        <div style="font-size: 0.7rem; color: #6b7280;">{{ __('admin.completed_today') }}</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: #059669;">{{ $completedToday }}</div>
    </div>
    <div style="background: #fff; border-radius: 1rem; padding: 1rem; border: 1px solid #e5e7eb;">
        <div style="font-size: 0.7rem; color: #6b7280;">{{ __('admin.total_completed') }}</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: #2563eb;">{{ $totalCompleted }}</div>
    </div>
</div>

<!-- Today's Bookings -->
<div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; overflow: hidden; margin-bottom: 1.5rem;">
    <div style="padding: 1rem 1.25rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-size: 0.95rem; font-weight: 700; color: #1f2937;">
            <i class="fas fa-calendar-day" style="color: var(--primary);"></i> {{ __('admin.today_bookings') }}
        </h3>
        <a href="{{ route('booking.index', $salon) }}" style="font-size: 0.75rem; color: var(--primary); text-decoration: none;">{{ __('admin.view_all') }} →</a>
    </div>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f9fafb;">
                    <th style="padding: 0.6rem 1rem; font-size: 0.7rem; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.time') }}</th>
                    <th style="padding: 0.6rem 1rem; font-size: 0.7rem; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.client') }}</th>
                    <th style="padding: 0.6rem 1rem; font-size: 0.7rem; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.service') }}</th>
                    <th style="padding: 0.6rem 1rem; font-size: 0.7rem; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.status') }}</th>
                    <th style="padding: 0.6rem 1rem; font-size: 0.7rem; color: #6b7280; text-align: center;">{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($todayBookingsList as $booking)
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding: 0.6rem 1rem; font-size: 0.8rem; font-weight: 600; color: #1f2937;">
                        {{ \Carbon\Carbon::parse($booking->appointment_datetime)->format('h:i A') }}
                    </td>
                    <td style="padding: 0.6rem 1rem; font-size: 0.8rem; color: #374151;">
                        {{ $booking->client ? (app()->getLocale() === 'ar' ? $booking->client->name_ar : $booking->client->name_en) : '-' }}
                    </td>
                    <td style="padding: 0.6rem 1rem; font-size: 0.8rem; color: #374151;">
                        {{ $booking->service ? (app()->getLocale() === 'ar' ? $booking->service->name_ar : $booking->service->name_en) : '-' }}
                    </td>
                    <td style="padding: 0.6rem 1rem;">
                        @php
                            $colors = ['pending' => '#d97706', 'confirmed' => '#2563eb', 'completed' => '#059669', 'cancelled' => '#ef4444'];
                            $bgs = ['pending' => '#fef3c7', 'confirmed' => '#dbeafe', 'completed' => '#dcfce7', 'cancelled' => '#fee2e2'];
                        @endphp
                        <span style="font-size: 0.65rem; padding: 0.15rem 0.4rem; border-radius: 9999px; background: {{ $bgs[$booking->status] ?? '#f3f4f6' }}; color: {{ $colors[$booking->status] ?? '#6b7280' }};">
                            {{ __('admin.status_' . $booking->status) }}
                        </span>
                    </td>
                    <td style="padding: 0.6rem 1rem; text-align: center;">
                        <a href="{{ route('booking.status.form', [$salon, $booking]) }}" style="color: var(--primary); font-size: 0.8rem; text-decoration: none;">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 2rem; text-align: center; color: #9ca3af; font-size: 0.85rem;">
                        {{ __('admin.no_bookings_today') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
