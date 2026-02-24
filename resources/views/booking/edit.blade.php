@extends('admin.layout.app')

@section('page-title', __('admin.edit_booking'))

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">{{ __('admin.edit_booking') }}</h2>
</div>

<div class="bg-white rounded-lg shadow-md p-8 max-w-2xl">
    <form method="POST" action="{{ route('booking.update', [$salon, $booking]) }}" class="space-y-6" id="bookingForm">
        @csrf @method('PUT')

        <!-- Client Selection -->
        <div>
            <label for="client_id" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.client') }}</label>
            <select id="client_id" name="client_id" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" @selected($booking->client_id == $client->id)>
                        {{ app()->getLocale() === 'ar' ? $client->name_ar : ($client->name_en ?? $client->name_ar) }} ({{ $client->phone }})
                    </option>
                @endforeach
            </select>
            @error('client_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Service Selection -->
        <div>
            <label for="service_id" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.service') }}</label>
            <select id="service_id" name="service_id" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @foreach($services as $service)
                    <option value="{{ $service->id }}" data-duration="{{ $service->duration_minutes }}" @selected($booking->service_id == $service->id)>
                        {{ app()->getLocale() === 'ar' ? $service->name_ar : ($service->name_en ?? $service->name_ar) }} - {{ $service->price }} {{ $salon->currency }}
                    </option>
                @endforeach
            </select>
            @error('service_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Appointment DateTime -->
        <div>
            <label for="appointment_datetime" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.date') }} & {{ __('admin.time') }}</label>
            <input type="text" id="appointment_datetime" name="appointment_datetime" 
                placeholder="YYYY-MM-DD HH:MM" value="{{ $booking->appointment_datetime->format('Y-m-d H:i') }}" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('appointment_datetime') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Staff Selection (dynamic) -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.staff_member') }}</label>
            <div id="staff-availability-hint" class="text-sm text-amber-600 mb-2 hidden">
                <i class="fas fa-info-circle"></i>
                {{ app()->getLocale() === 'ar' ? 'اختر الخدمة والوقت أولاً لعرض الموظفين المتاحين' : 'Select service and date/time first to see available staff' }}
            </div>
            <div id="staff-loading" class="hidden text-sm text-gray-500 mb-2">
                <i class="fas fa-spinner fa-spin"></i>
                {{ app()->getLocale() === 'ar' ? 'جاري التحقق من التوفر...' : 'Checking availability...' }}
            </div>
            <div id="staff-list" class="grid grid-cols-1 gap-2">
                {{-- Staff cards will be injected by JS --}}
            </div>
            <input type="hidden" name="staff_id" id="staff_id" value="{{ $booking->staff_id }}" required>
            @error('staff_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Notes -->
        <div>
            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.notes') }}</label>
            <textarea id="notes" name="notes" rows="3"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ $booking->notes }}</textarea>
            @error('notes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex gap-4 pt-6">
            <button type="submit" id="submitBtn" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">
                {{ __('admin.save_changes') }}
            </button>
            <a href="{{ route('booking.show', [$salon, $booking]) }}" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-6 rounded-lg transition">
                {{ __('admin.cancel') }}
            </a>
        </div>
    </form>
</div>

<style>
    .staff-card-option { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; cursor: pointer; transition: all 0.2s; }
    .staff-card-option:hover:not(.unavailable) { border-color: #dd208e; background: #fdf2f8; }
    .staff-card-option.selected { border-color: #dd208e; background: #fdf2f8; box-shadow: 0 0 0 1px #dd208e; }
    .staff-card-option.unavailable { opacity: 0.45; cursor: not-allowed; background: #f8fafc; }
    .staff-avatar-sm { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #dd208e, #b01670); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 0.8rem; flex-shrink: 0; }
    .staff-card-option.unavailable .staff-avatar-sm { background: #94a3b8; }
    .avail-badge { font-size: 0.7rem; padding: 0.15rem 0.5rem; border-radius: 999px; font-weight: 600; }
    .avail-badge.free { background: #dcfce7; color: #166534; }
    .avail-badge.busy { background: #fee2e2; color: #991b1b; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const serviceSelect = document.getElementById('service_id');
    const datetimeInput = document.getElementById('appointment_datetime');
    const staffInput = document.getElementById('staff_id');
    const staffList = document.getElementById('staff-list');
    const staffHint = document.getElementById('staff-availability-hint');
    const staffLoading = document.getElementById('staff-loading');
    const salonId = {{ $salon->id }};
    const bookingId = {{ $booking->id }};
    const currentStaffId = {{ $booking->staff_id ?? 'null' }};
    const isAr = '{{ app()->getLocale() }}' === 'ar';
    const freeLabel = isAr ? 'متاح' : 'Available';
    const busyLabel = isAr ? 'مشغول' : 'Busy';

    let fetchTimeout = null;

    function fetchAvailableStaff() {
        const serviceId = serviceSelect.value;
        const datetime = datetimeInput.value;

        if (!serviceId || !datetime || datetime.length < 16) {
            staffList.innerHTML = '';
            staffHint.classList.remove('hidden');
            return;
        }

        const parts = datetime.split(' ');
        if (parts.length < 2) return;
        const date = parts[0];
        const time = parts[1];

        staffHint.classList.add('hidden');
        staffLoading.classList.remove('hidden');

        fetch(`/api/salon/${salonId}/available-staff?date=${date}&time=${time}&service_id=${serviceId}&exclude_booking_id=${bookingId}`)
            .then(r => r.json())
            .then(data => {
                staffLoading.classList.add('hidden');
                renderStaffCards(data.staff || []);
            })
            .catch(() => {
                staffLoading.classList.add('hidden');
                staffList.innerHTML = `<p class="text-red-500 text-sm">${isAr ? 'حدث خطأ' : 'Error loading staff'}</p>`;
            });
    }

    function renderStaffCards(staffData) {
        if (staffData.length === 0) {
            staffList.innerHTML = `<p class="text-sm text-gray-500">${isAr ? 'لا يوجد موظفين لهذه الخدمة' : 'No staff available for this service'}</p>`;
            return;
        }

        const selectedId = staffInput.value;
        let html = '';
        staffData.forEach(s => {
            const name = isAr ? s.name_ar : s.name_en;
            const initial = name.charAt(0);
            const isSelected = String(s.id) === String(selectedId);
            const cls = s.available ? (isSelected ? ' selected' : '') : ' unavailable';
            const badge = s.available
                ? `<span class="avail-badge free"><i class="fas fa-check-circle" style="margin-inline-end:3px;"></i>${freeLabel}</span>`
                : `<span class="avail-badge busy"><i class="fas fa-times-circle" style="margin-inline-end:3px;"></i>${busyLabel}</span>`;

            html += `
                <div class="staff-card-option${cls}" data-staff-id="${s.id}" onclick="pickStaff(this, ${s.id}, ${s.available})">
                    <div class="staff-avatar-sm">${initial}</div>
                    <div class="flex-1">
                        <div class="font-semibold text-sm text-gray-800">${name}</div>
                    </div>
                    ${badge}
                </div>`;
        });

        staffList.innerHTML = html;

        // If current staff is no longer available, clear selection
        const currentCard = staffList.querySelector(`.staff-card-option[data-staff-id="${selectedId}"]`);
        if (!currentCard || currentCard.classList.contains('unavailable')) {
            // Auto-select first available
            const firstAvailable = staffList.querySelector('.staff-card-option:not(.unavailable)');
            if (firstAvailable) {
                firstAvailable.classList.add('selected');
                staffInput.value = firstAvailable.dataset.staffId;
            } else {
                staffInput.value = '';
            }
        }
    }

    window.pickStaff = function(card, id, isAvailable) {
        if (!isAvailable) return;
        document.querySelectorAll('.staff-card-option').forEach(c => c.classList.remove('selected'));
        card.classList.add('selected');
        staffInput.value = id;
    };

    serviceSelect.addEventListener('change', function() {
        clearTimeout(fetchTimeout);
        fetchTimeout = setTimeout(fetchAvailableStaff, 300);
    });

    datetimeInput.addEventListener('input', function() {
        clearTimeout(fetchTimeout);
        fetchTimeout = setTimeout(fetchAvailableStaff, 500);
    });

    datetimeInput.addEventListener('change', function() {
        clearTimeout(fetchTimeout);
        fetchTimeout = setTimeout(fetchAvailableStaff, 300);
    });

    // Load staff on page load since we already have service + datetime
    fetchAvailableStaff();
});
</script>
@endsection
