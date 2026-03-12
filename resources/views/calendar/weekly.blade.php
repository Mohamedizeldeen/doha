@extends('admin.layout.app')

@section('page-title', __('admin.weekly_calendar'))

@section('content')
<div style="margin-bottom: 1.5rem; display: flex; flex-wrap: wrap; align-items: center; gap: 1rem; justify-content: space-between;">
    <div style="display: flex; align-items: center; gap: 0.75rem;">
        <a href="{{ route('calendar.weekly', [$salon, 'date' => $startOfWeek->copy()->subWeek()->toDateString()]) }}" 
           style="width: 36px; height: 36px; border-radius: 0.5rem; border: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: center; color: #6b7280; text-decoration: none; background: #fff;">
            <i class="fas fa-chevron-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i>
        </a>
        <h2 style="font-size: 1.1rem; font-weight: 700; color: #1f2937; margin: 0;">
            {{ $startOfWeek->format('d M') }} - {{ $endOfWeek->format('d M Y') }}
        </h2>
        <a href="{{ route('calendar.weekly', [$salon, 'date' => $startOfWeek->copy()->addWeek()->toDateString()]) }}" 
           style="width: 36px; height: 36px; border-radius: 0.5rem; border: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: center; color: #6b7280; text-decoration: none; background: #fff;">
            <i class="fas fa-chevron-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}"></i>
        </a>
    </div>
    <div style="display: flex; gap: 0.5rem; align-items: center;">
        <a href="{{ route('calendar.weekly', [$salon, 'date' => now()->toDateString()]) }}" 
           style="padding: 0.5rem 1rem; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: #fff; border-radius: 0.5rem; text-decoration: none; font-size: 0.8rem; font-weight: 600;">
            {{ __('admin.this_week') }}
        </a>
        <a href="{{ route('calendar.daily', [$salon, 'date' => now()->toDateString()]) }}" 
           style="padding: 0.5rem 1rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; text-decoration: none; font-size: 0.8rem; color: #6b7280; background: #fff;">
            <i class="fas fa-calendar-day"></i> {{ __('admin.daily_view') }}
        </a>
    </div>
</div>

<!-- Weekly Grid -->
<div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 0.5rem;">
    @foreach($weekDays as $dayData)
    @php
        $isToday = $dayData['date']->isToday();
        $dayBookings = $dayData['bookings'];
    @endphp
    <div style="background: {{ $isToday ? '#fdf2f8' : '#fff' }}; border-radius: 0.75rem; border: {{ $isToday ? '2px solid var(--primary)' : '1px solid #e5e7eb' }}; overflow: hidden; min-height: 300px;">
        <!-- Day Header -->
        <div style="padding: 0.75rem; text-align: center; background: {{ $isToday ? 'var(--primary)' : '#f9fafb' }}; border-bottom: 1px solid #e5e7eb;">
            <div style="font-size: 0.65rem; font-weight: 600; color: {{ $isToday ? '#fff' : '#6b7280' }}; text-transform: uppercase;">
                {{ $dayData['date']->translatedFormat('D') }}
            </div>
            <div style="font-size: 1.25rem; font-weight: 800; color: {{ $isToday ? '#fff' : '#1f2937' }};">
                {{ $dayData['date']->format('d') }}
            </div>
            <div style="font-size: 0.6rem; color: {{ $isToday ? 'rgba(255,255,255,0.8)' : '#9ca3af' }};">
                {{ $dayBookings->count() }} {{ __('admin.booking') }}
            </div>
        </div>

        <!-- Bookings -->
        <div style="padding: 0.375rem;">
            @forelse($dayBookings as $booking)
            @php
                $statusColors = [
                    'scheduled' => ['bg' => '#dbeafe', 'dot' => '#3b82f6'],
                    'completed' => ['bg' => '#dcfce7', 'dot' => '#22c55e'],
                    'canceled' => ['bg' => '#fee2e2', 'dot' => '#ef4444'],
                ];
                $c = $statusColors[$booking->status] ?? $statusColors['scheduled'];
            @endphp
            <a href="{{ route('booking.show', [$salon, $booking]) }}" 
               style="display: block; background: {{ $c['bg'] }}; border-radius: 0.375rem; padding: 0.375rem; margin-bottom: 0.25rem; text-decoration: none;">
                <div style="display: flex; align-items: center; gap: 0.25rem;">
                    <div style="width: 6px; height: 6px; border-radius: 50%; background: {{ $c['dot'] }}; flex-shrink: 0;"></div>
                    <span style="font-size: 0.6rem; font-weight: 700; color: #374151;">{{ $booking->appointment_datetime->format('H:i') }}</span>
                </div>
                <div style="font-size: 0.6rem; color: #4b5563; margin-top: 0.125rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    {{ app()->getLocale() === 'ar' ? $booking->service->name_ar : $booking->service->name_en }}
                </div>
                <div style="font-size: 0.55rem; color: #6b7280; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    {{ app()->getLocale() === 'ar' ? $booking->client->name_ar : $booking->client->name_en }}
                </div>
            </a>
            @empty
            <div style="text-align: center; padding: 1rem 0.5rem; color: #d1d5db; font-size: 0.65rem;">
                {{ __('admin.no_bookings') }}
            </div>
            @endforelse
        </div>

        <!-- Add booking link -->
        <div style="padding: 0.375rem;">
            <a href="{{ route('booking.create', $salon) }}" 
               style="display: block; border: 1px dashed #d1d5db; border-radius: 0.375rem; padding: 0.25rem; text-align: center; text-decoration: none; color: #9ca3af; font-size: 0.6rem; transition: all 0.2s;"
               onmouseover="this.style.borderColor='var(--primary)'; this.style.color='var(--primary)'"
               onmouseout="this.style.borderColor='#d1d5db'; this.style.color='#9ca3af'">
                <i class="fas fa-plus"></i>
            </a>
        </div>
    </div>
    @endforeach
</div>

<!-- Legend -->
<div style="margin-top: 1rem; display: flex; gap: 1.5rem; justify-content: center;">
    <div style="display: flex; align-items: center; gap: 0.375rem; font-size: 0.7rem; color: #6b7280;">
        <div style="width: 10px; height: 10px; border-radius: 50%; background: #3b82f6;"></div> {{ __('admin.scheduled') }}
    </div>
    <div style="display: flex; align-items: center; gap: 0.375rem; font-size: 0.7rem; color: #6b7280;">
        <div style="width: 10px; height: 10px; border-radius: 50%; background: #22c55e;"></div> {{ __('admin.completed') }}
    </div>
    <div style="display: flex; align-items: center; gap: 0.375rem; font-size: 0.7rem; color: #6b7280;">
        <div style="width: 10px; height: 10px; border-radius: 50%; background: #ef4444;"></div> {{ __('admin.cancelled') }}
    </div>
</div>
@endsection
