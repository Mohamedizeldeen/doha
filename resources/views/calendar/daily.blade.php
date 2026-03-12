@extends('admin.layout.app')

@section('page-title', __('admin.daily_calendar'))

@section('content')
<div style="margin-bottom: 1.5rem; display: flex; flex-wrap: wrap; align-items: center; gap: 1rem; justify-content: space-between;">
    <div style="display: flex; align-items: center; gap: 0.75rem;">
        <a href="{{ route('calendar.daily', [$salon, 'date' => $currentDate->copy()->subDay()->toDateString()]) }}" 
           style="width: 36px; height: 36px; border-radius: 0.5rem; border: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: center; color: #6b7280; text-decoration: none; background: #fff;">
            <i class="fas fa-chevron-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i>
        </a>
        <h2 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin: 0;">
            {{ $currentDate->translatedFormat('l, d F Y') }}
        </h2>
        <a href="{{ route('calendar.daily', [$salon, 'date' => $currentDate->copy()->addDay()->toDateString()]) }}" 
           style="width: 36px; height: 36px; border-radius: 0.5rem; border: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: center; color: #6b7280; text-decoration: none; background: #fff;">
            <i class="fas fa-chevron-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}"></i>
        </a>
    </div>
    <div style="display: flex; gap: 0.5rem; align-items: center;">
        <a href="{{ route('calendar.daily', [$salon, 'date' => now()->toDateString()]) }}" 
           style="padding: 0.5rem 1rem; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: #fff; border-radius: 0.5rem; text-decoration: none; font-size: 0.8rem; font-weight: 600;">
            {{ __('admin.today') }}
        </a>
        <a href="{{ route('calendar.weekly', [$salon, 'date' => $currentDate->toDateString()]) }}" 
           style="padding: 0.5rem 1rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; text-decoration: none; font-size: 0.8rem; color: #6b7280; background: #fff;">
            <i class="fas fa-calendar-week"></i> {{ __('admin.weekly_view') }}
        </a>
        <input type="date" value="{{ $currentDate->toDateString() }}" 
               onchange="window.location='{{ route('calendar.daily', $salon) }}?date='+this.value"
               style="padding: 0.4rem 0.75rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; font-size: 0.8rem;">
    </div>
</div>

<!-- Summary Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
    <div style="background: #fff; border-radius: 0.75rem; padding: 1rem; border: 1px solid #e5e7eb;">
        <div style="font-size: 0.75rem; color: #6b7280;">{{ __('admin.total_bookings') }}</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary);">{{ $bookings->count() }}</div>
    </div>
    <div style="background: #fff; border-radius: 0.75rem; padding: 1rem; border: 1px solid #e5e7eb;">
        <div style="font-size: 0.75rem; color: #6b7280;">{{ __('admin.completed') }}</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: #059669;">{{ $bookings->where('status', 'completed')->count() }}</div>
    </div>
    <div style="background: #fff; border-radius: 0.75rem; padding: 1rem; border: 1px solid #e5e7eb;">
        <div style="font-size: 0.75rem; color: #6b7280;">{{ __('admin.scheduled') }}</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: #2563eb;">{{ $bookings->where('status', 'scheduled')->count() }}</div>
    </div>
    <div style="background: #fff; border-radius: 0.75rem; padding: 1rem; border: 1px solid #e5e7eb;">
        <div style="font-size: 0.75rem; color: #6b7280;">{{ __('admin.cancelled') }}</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: #dc2626;">{{ $bookings->where('status', 'canceled')->count() }}</div>
    </div>
</div>

<!-- Timeline View -->
<div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; overflow: hidden;">
    <!-- Staff columns header -->
    <div style="display: grid; grid-template-columns: 80px repeat({{ count($staffBookings) }}, 1fr); border-bottom: 2px solid #e5e7eb; background: #f9fafb;">
        <div style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: center;">
            {{ __('admin.time') }}
        </div>
        @foreach($staffBookings as $id => $data)
        <div style="padding: 0.75rem; text-align: center; border-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}: 1px solid #e5e7eb;">
            <div style="font-size: 0.8rem; font-weight: 700; color: #1f2937;">
                {{ app()->getLocale() === 'ar' ? $data['staff']->name_ar : $data['staff']->name_en }}
            </div>
            <div style="font-size: 0.65rem; color: #9ca3af;">
                {{ $data['bookings']->count() }} {{ __('admin.booking') }}
            </div>
        </div>
        @endforeach
    </div>

    <!-- Time slots -->
    @php
        $openingHour = 8;
        $closingHour = 22;
    @endphp
    @for($hour = $openingHour; $hour < $closingHour; $hour++)
    <div style="display: grid; grid-template-columns: 80px repeat({{ count($staffBookings) }}, 1fr); min-height: 60px; border-bottom: 1px solid #f3f4f6;">
        <div style="padding: 0.5rem; font-size: 0.7rem; color: #9ca3af; text-align: center; border-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}: 1px solid #f3f4f6;">
            {{ sprintf('%02d:00', $hour) }}
        </div>
        @foreach($staffBookings as $id => $data)
        <div style="padding: 0.25rem; border-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}: 1px solid #f3f4f6; position: relative;">
            @foreach($data['bookings'] as $booking)
                @if($booking->appointment_datetime->hour == $hour)
                @php
                    $statusColors = [
                        'scheduled' => ['bg' => '#dbeafe', 'border' => '#3b82f6', 'text' => '#1e40af'],
                        'completed' => ['bg' => '#dcfce7', 'border' => '#22c55e', 'text' => '#166534'],
                        'canceled' => ['bg' => '#fee2e2', 'border' => '#ef4444', 'text' => '#991b1b'],
                    ];
                    $colors = $statusColors[$booking->status] ?? $statusColors['scheduled'];
                @endphp
                <a href="{{ route('booking.show', [$salon, $booking]) }}" 
                   style="display: block; background: {{ $colors['bg'] }}; border-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}: 3px solid {{ $colors['border'] }}; border-radius: 0.375rem; padding: 0.375rem 0.5rem; margin-bottom: 0.25rem; text-decoration: none; font-size: 0.7rem;">
                    <div style="font-weight: 700; color: {{ $colors['text'] }};">
                        {{ $booking->appointment_datetime->format('H:i') }} - {{ app()->getLocale() === 'ar' ? $booking->service->name_ar : $booking->service->name_en }}
                    </div>
                    <div style="color: {{ $colors['text'] }}; opacity: 0.8;">
                        {{ app()->getLocale() === 'ar' ? $booking->client->name_ar : $booking->client->name_en }}
                    </div>
                </a>
                @endif
            @endforeach
        </div>
        @endforeach
    </div>
    @endfor
</div>

@if($unassigned->count() > 0)
<div style="margin-top: 1.5rem; background: #fffbeb; border: 1px solid #fbbf24; border-radius: 0.75rem; padding: 1rem;">
    <h3 style="font-size: 0.9rem; font-weight: 700; color: #92400e; margin-bottom: 0.75rem;">
        <i class="fas fa-exclamation-triangle"></i> {{ __('admin.unassigned_bookings') }} ({{ $unassigned->count() }})
    </h3>
    @foreach($unassigned as $booking)
    <a href="{{ route('booking.edit', [$salon, $booking]) }}" 
       style="display: inline-block; background: #fff; border: 1px solid #fbbf24; border-radius: 0.5rem; padding: 0.5rem 0.75rem; margin: 0.25rem; text-decoration: none; font-size: 0.75rem; color: #92400e;">
        {{ $booking->appointment_datetime->format('H:i') }} - {{ app()->getLocale() === 'ar' ? $booking->client->name_ar : $booking->client->name_en }}
    </a>
    @endforeach
</div>
@endif
@endsection
