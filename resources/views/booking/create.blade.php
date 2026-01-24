@extends('admin.layout.app')

@section('page-title', 'حجز جديد')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">إنشاء حجز جديد</h2>
</div>

<div class="bg-white rounded-lg shadow-md p-8 max-w-2xl">
    <form method="POST" action="{{ route('booking.store', $salon) }}" class="space-y-6">
        @csrf

        <!-- Client Selection -->
        <div>
            <label for="client_id" class="block text-sm font-medium text-gray-700 mb-2">العميل</label>
            <select id="client_id" name="client_id" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">-- اختر عميل --</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" @selected(old('client_id') == $client->id)>
                        {{ $client->name_ar }} ({{ $client->phone }})
                    </option>
                @endforeach
            </select>
            @error('client_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Staff Selection -->
        <div>
            <label for="staff_id" class="block text-sm font-medium text-gray-700 mb-2">الموظفة</label>
            <select id="staff_id" name="staff_id" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                data-staff-services="{{ route('staff.services', [$salon, 0]) }}">
                <option value="">-- اختر موظفة --</option>
                @foreach($staff as $member)
                    <option value="{{ $member->id }}" @selected(old('staff_id') == $member->id)>
                        {{ $member->name_ar }}
                    </option>
                @endforeach
            </select>
            @error('staff_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Service Selection -->
        <div>
            <label for="service_id" class="block text-sm font-medium text-gray-700 mb-2">الخدمة</label>
            <select id="service_id" name="service_id" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">-- اختر خدمة --</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}" data-staff-id="" @selected(old('service_id') == $service->id)>
                        {{ $service->name_ar }} - {{ $service->price }} ريال
                    </option>
                @endforeach
            </select>
            <div id="service-warning" class="mt-2 text-amber-600 text-sm hidden">
                💡 الرجاء اختيار موظفة أولاً لعرض الخدمات المتاحة
            </div>
            @error('service_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Appointment DateTime -->
        <div>
            <label for="appointment_datetime" class="block text-sm font-medium text-gray-700 mb-2">التاريخ والوقت</label>
            <input type="text" id="appointment_datetime" name="appointment_datetime" 
                placeholder="YYYY-MM-DD HH:MM" value="{{ old('appointment_datetime') }}" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('appointment_datetime') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Notes -->
        <div>
            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">ملاحظات</label>
            <textarea id="notes" name="notes" rows="3"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('notes') }}</textarea>
            @error('notes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex gap-4 pt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">
                حفظ الحجز
            </button>
            <a href="{{ route('booking.index', $salon) }}" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-6 rounded-lg transition">
                إلغاء
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const staffSelect = document.getElementById('staff_id');
    const serviceSelect = document.getElementById('service_id');
    const serviceWarning = document.getElementById('service-warning');
    const baseUrl = staffSelect.dataset.staffServices.replace('/0', '');

    // Store all services with their associated staff
    const allServices = {!! json_encode($services->map(function($s) use ($staff) { return ['id' => $s->id, 'name_ar' => $s->name_ar, 'name_en' => $s->name_en ?? $s->name_ar, 'price' => $s->price, 'staff_ids' => $staff->filter(function($member) use ($s) { return $member->services->contains('id', $s->id); })->pluck('id')->toArray()]; })) !!};

    function filterServices() {
        const selectedStaffId = staffSelect.value;
        
        if (!selectedStaffId) {
            // Show warning and disable all services
            serviceWarning.classList.remove('hidden');
            Array.from(serviceSelect.options).forEach(option => {
                if (option.value !== '') {
                    option.hidden = true;
                }
            });
            serviceSelect.value = '';
            return;
        }

        // Hide warning
        serviceWarning.classList.add('hidden');

        // Filter services
        const filteredServiceIds = new Set();
        allServices.forEach(service => {
            if (service.staff_ids.includes(parseInt(selectedStaffId))) {
                filteredServiceIds.add(service.id);
            }
        });

        // Update service options visibility
        Array.from(serviceSelect.options).forEach(option => {
            if (option.value === '') {
                option.hidden = false;
            } else {
                option.hidden = !filteredServiceIds.has(parseInt(option.value));
            }
        });

        // Reset service selection if it's not in filtered list
        if (serviceSelect.value && !filteredServiceIds.has(parseInt(serviceSelect.value))) {
            serviceSelect.value = '';
        }
    }

    staffSelect.addEventListener('change', filterServices);
    filterServices();
});
</script>
@endsection

