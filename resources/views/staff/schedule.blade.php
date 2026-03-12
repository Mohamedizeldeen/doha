@extends('admin.layout.app')

@section('page-title', __('admin.staff_schedule'))

@section('content')
<div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
    <h2 style="font-size: 1.15rem; font-weight: 700; color: #1f2937;">{{ __('admin.staff_schedule') }}</h2>
</div>

@if(session('success'))
<div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1rem; font-size: 0.85rem;">
    {{ session('success') }}
</div>
@endif

<!-- Staff Tabs -->
<div style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem; overflow-x: auto; padding-bottom: 0.5rem;">
    @foreach($staffMembers as $index => $member)
    <button onclick="showStaffTab({{ $member->id }})" id="tab-{{ $member->id }}" class="staff-tab" style="padding: 0.5rem 1rem; border-radius: 0.75rem; border: 2px solid {{ $index === 0 ? 'var(--primary)' : '#e5e7eb' }}; background: {{ $index === 0 ? 'var(--primary)' : '#fff' }}; color: {{ $index === 0 ? '#fff' : '#6b7280' }}; font-size: 0.8rem; font-weight: 600; cursor: pointer; white-space: nowrap;">
        {{ app()->getLocale() === 'ar' ? $member->name_ar : $member->name_en }}
    </button>
    @endforeach
</div>

@foreach($staffMembers as $index => $member)
<div id="staff-panel-{{ $member->id }}" class="staff-panel" style="display: {{ $index === 0 ? 'block' : 'none' }};">
    <!-- Weekly Schedule Form -->
    <form action="{{ route('staff-schedule.update', $salon) }}" method="POST">
        @csrf
        <input type="hidden" name="staff_id" value="{{ $member->id }}">
        <div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; padding: 1.25rem; margin-bottom: 1.5rem;">
            <h3 style="font-size: 0.95rem; font-weight: 700; color: #1f2937; margin-bottom: 1rem;">
                <i class="fas fa-clock" style="color: var(--primary);"></i> {{ __('admin.weekly_schedule') }}
            </h3>
            @php
                $days = [0 => 'Sunday', 1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday'];
                $daysAr = [0 => 'الأحد', 1 => 'الإثنين', 2 => 'الثلاثاء', 3 => 'الأربعاء', 4 => 'الخميس', 5 => 'الجمعة', 6 => 'السبت'];
                $memberSchedules = $schedules->where('staff_id', $member->id)->keyBy('day_of_week');
            @endphp
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                @foreach($days as $dayNum => $dayName)
                @php $schedule = $memberSchedules->get($dayNum); @endphp
                <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.6rem; background: #f9fafb; border-radius: 0.5rem; flex-wrap: wrap;">
                    <label style="display: flex; align-items: center; gap: 0.3rem; min-width: 90px; cursor: pointer;">
                        <input type="checkbox" name="days[{{ $dayNum }}][enabled]" value="1" {{ ($schedule && !$schedule->is_day_off) ? 'checked' : '' }} onchange="toggleDay(this, {{ $member->id }}, {{ $dayNum }})" style="accent-color: var(--primary);">
                        <span style="font-size: 0.8rem; font-weight: 600; color: #374151;">{{ app()->getLocale() === 'ar' ? $daysAr[$dayNum] : $dayName }}</span>
                    </label>
                    <div id="times-{{ $member->id }}-{{ $dayNum }}" style="display: {{ ($schedule && !$schedule->is_day_off) ? 'flex' : 'none' }}; gap: 0.5rem; align-items: center;">
                        <input type="time" name="days[{{ $dayNum }}][start_time]" value="{{ $schedule ? substr($schedule->start_time, 0, 5) : '09:00' }}" style="padding: 0.35rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.8rem;">
                        <span style="font-size: 0.75rem; color: #9ca3af;">-</span>
                        <input type="time" name="days[{{ $dayNum }}][end_time]" value="{{ $schedule ? substr($schedule->end_time, 0, 5) : '18:00' }}" style="padding: 0.35rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.8rem;">
                    </div>
                </div>
                @endforeach
            </div>
            <button type="submit" style="margin-top: 1rem; padding: 0.6rem 1.5rem; background: var(--primary); color: #fff; border: none; border-radius: 0.5rem; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                <i class="fas fa-save"></i> {{ __('admin.save') }}
            </button>
        </div>
    </form>

    <!-- Leaves Section -->
    <div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; padding: 1.25rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h3 style="font-size: 0.95rem; font-weight: 700; color: #1f2937;">
                <i class="fas fa-calendar-minus" style="color: #ef4444;"></i> {{ __('admin.leaves') }}
            </h3>
            <button onclick="document.getElementById('leave-form-{{ $member->id }}').style.display = document.getElementById('leave-form-{{ $member->id }}').style.display === 'none' ? 'block' : 'none'" style="padding: 0.4rem 0.8rem; background: #fef2f2; border: 1px solid #fecaca; color: #ef4444; border-radius: 0.5rem; font-size: 0.75rem; cursor: pointer;">
                <i class="fas fa-plus"></i> {{ __('admin.add_leave') }}
            </button>
        </div>

        <!-- Add Leave Form -->
        <form action="{{ route('staff-schedule.leave.store', $salon) }}" method="POST" id="leave-form-{{ $member->id }}" style="display: none; margin-bottom: 1rem; padding: 1rem; background: #fef2f2; border-radius: 0.5rem;">
            @csrf
            <input type="hidden" name="staff_id" value="{{ $member->id }}">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                <div>
                    <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.start_date') }}</label>
                    <input type="date" name="start_date" required style="width: 100%; padding: 0.4rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.8rem;">
                </div>
                <div>
                    <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.end_date') }}</label>
                    <input type="date" name="end_date" required style="width: 100%; padding: 0.4rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.8rem;">
                </div>
            </div>
            <div style="margin-top: 0.5rem;">
                <label style="font-size: 0.75rem; color: #6b7280; display: block; margin-bottom: 0.25rem;">{{ __('admin.reason') }}</label>
                <input type="text" name="reason" style="width: 100%; padding: 0.4rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.8rem;">
            </div>
            <button type="submit" style="margin-top: 0.75rem; padding: 0.4rem 1rem; background: #ef4444; color: #fff; border: none; border-radius: 0.375rem; font-size: 0.8rem; cursor: pointer;">
                {{ __('admin.save') }}
            </button>
        </form>

        @php $memberLeaves = $leaves->where('staff_id', $member->id); @endphp
        @forelse($memberLeaves as $leave)
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.6rem; border-bottom: 1px solid #f3f4f6; flex-wrap: wrap; gap: 0.5rem;">
            <div>
                <span style="font-size: 0.8rem; font-weight: 600; color: #374151;">{{ $leave->start_date->format('d/m/Y') }} - {{ $leave->end_date->format('d/m/Y') }}</span>
                @if($leave->reason)
                <span style="font-size: 0.75rem; color: #6b7280; margin-inline-start: 0.5rem;">{{ $leave->reason }}</span>
                @endif
                <span style="font-size: 0.65rem; padding: 0.1rem 0.35rem; border-radius: 9999px; margin-inline-start: 0.25rem;
                    background: {{ $leave->status === 'approved' ? '#dcfce7' : ($leave->status === 'rejected' ? '#fee2e2' : '#fef9c3') }};
                    color: {{ $leave->status === 'approved' ? '#166534' : ($leave->status === 'rejected' ? '#991b1b' : '#854d0e') }};">
                    {{ __('admin.' . $leave->status) }}
                </span>
            </div>
            <form action="{{ route('staff-schedule.leave.destroy', [$salon, $leave]) }}" method="POST" onsubmit="return confirm('{{ __('admin.confirm_delete') }}')">
                @csrf @method('DELETE')
                <button type="submit" style="padding: 0.25rem 0.5rem; color: #ef4444; background: none; border: none; cursor: pointer; font-size: 0.75rem;">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
        @empty
        <p style="text-align: center; color: #9ca3af; font-size: 0.8rem; padding: 1rem;">{{ __('admin.no_leaves') }}</p>
        @endforelse
    </div>
</div>
@endforeach

<script>
function showStaffTab(staffId) {
    document.querySelectorAll('.staff-panel').forEach(p => p.style.display = 'none');
    document.querySelectorAll('.staff-tab').forEach(t => { t.style.borderColor = '#e5e7eb'; t.style.background = '#fff'; t.style.color = '#6b7280'; });
    document.getElementById('staff-panel-' + staffId).style.display = 'block';
    const tab = document.getElementById('tab-' + staffId);
    tab.style.borderColor = 'var(--primary)';
    tab.style.background = 'var(--primary)';
    tab.style.color = '#fff';
}
function toggleDay(checkbox, staffId, dayNum) {
    document.getElementById('times-' + staffId + '-' + dayNum).style.display = checkbox.checked ? 'flex' : 'none';
}
</script>
@endsection
