@extends('admin.layout.app')

@section('page-title', 'تعديل الموظف')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">تعديل: {{ $staff->name_ar }}</h2>
</div>

<div class="bg-white rounded-lg shadow-md p-8 max-w-2xl">
    <form method="POST" action="{{ route('staff.update', [$salon, $staff]) }}" class="space-y-6">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name Arabic -->
            <div>
                <label for="name_ar" class="block text-sm font-medium text-gray-700 mb-2">الاسم (عربي)</label>
                <input type="text" id="name_ar" name="name_ar" value="{{ $staff->name_ar }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('name_ar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Name English -->
            <div>
                <label for="name_en" class="block text-sm font-medium text-gray-700 mb-2">Name (English)</label>
                <input type="text" id="name_en" name="name_en" value="{{ $staff->name_en }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('name_en') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">البريد الإلكتروني</label>
                <input type="email" id="email" name="email" value="{{ $staff->email }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">رقم الهاتف</label>
                <input type="tel" id="phone" name="phone" value="{{ $staff->phone }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Position Arabic -->
            <div>
                <label for="position_ar" class="block text-sm font-medium text-gray-700 mb-2">المنصب (عربي)</label>
                <input type="text" id="position_ar" name="position_ar" value="{{ $staff->position_ar }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('position_ar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Position English -->
            <div>
                <label for="position_en" class="block text-sm font-medium text-gray-700 mb-2">Position (English)</label>
                <input type="text" id="position_en" name="position_en" value="{{ $staff->position_en }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('position_en') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Services -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">الخدمات المسندة (حد أقصى 5 خدمات)</label>
            <div class="border border-gray-300 rounded-lg p-4 max-h-60 overflow-y-auto">
                @forelse ($services as $service)
                    <div class="flex items-center mb-3">
                        <input type="checkbox" name="services[]" value="{{ $service->id }}" id="service_{{ $service->id }}"
                            {{ $staff->services->contains($service->id) ? 'checked' : '' }}
                            class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500 service-checkbox"
                            onchange="limitServices()">
                        <label for="service_{{ $service->id }}" class="ml-2 text-sm text-gray-700">
                            {{ $service->name_ar }} ({{ $service->price }} ريال)
                        </label>
                    </div>
                @empty
                    <p class="text-gray-600 text-sm">لا توجد خدمات متاحة</p>
                @endforelse
            </div>
            @error('services') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex gap-4 pt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">
                حفظ التعديلات
            </button>
            <a href="{{ route('staff.show', [$salon, $staff]) }}" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-6 rounded-lg transition">
                إلغاء
            </a>
        </div>
    </form>
</div>

<script>
    function limitServices() {
        const checkboxes = document.querySelectorAll('.service-checkbox');
        const checked = Array.from(checkboxes).filter(cb => cb.checked);
        
        if (checked.length > 5) {
            checked[checked.length - 1].checked = false;
            alert('يمكنك اختيار 5 خدمات كحد أقصى');
        }
        
        checkboxes.forEach(cb => {
            cb.disabled = checked.length >= 5 && !cb.checked;
        });
    }
    
    // Run on page load to disable checkboxes if 5 are already selected
    document.addEventListener('DOMContentLoaded', limitServices);
</script>
@endsection
