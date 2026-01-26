@extends('superAdmin.layout.app')

@section('page-title', 'إضافة صالون جديد')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">إضافة صالون جديد</h1>

        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('superAdmin.salons.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Owner Selection -->
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">مالك الصالون *</label>
                <select name="user_id" id="user_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                    <option value="">اختر مالك الصالون</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Name English -->
            <div>
                <label for="name_en" class="block text-sm font-medium text-gray-700 mb-2">اسم الصالون (إنجليزي) *</label>
                <input type="text" name="name_en" id="name_en" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="{{ old('name_en') }}" required>
                @error('name_en')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Name Arabic -->
            <div>
                <label for="name_ar" class="block text-sm font-medium text-gray-700 mb-2">اسم الصالون (عربي) *</label>
                <input type="text" name="name_ar" id="name_ar" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="{{ old('name_ar') }}" required>
                @error('name_ar')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">الهاتف</label>
                <input type="tel" name="phone" id="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="{{ old('phone') }}">
                @error('phone')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">البريد الإلكتروني</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="{{ old('email') }}">
                @error('email')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Address English -->
            <div>
                <label for="address_en" class="block text-sm font-medium text-gray-700 mb-2">العنوان (إنجليزي)</label>
                <textarea name="address_en" id="address_en" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('address_en') }}</textarea>
                @error('address_en')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Address Arabic -->
            <div>
                <label for="address_ar" class="block text-sm font-medium text-gray-700 mb-2">العنوان (عربي)</label>
                <textarea name="address_ar" id="address_ar" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('address_ar') }}</textarea>
                @error('address_ar')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description English -->
            <div>
                <label for="description_en" class="block text-sm font-medium text-gray-700 mb-2">الوصف (إنجليزي)</label>
                <textarea name="description_en" id="description_en" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('description_en') }}</textarea>
                @error('description_en')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description Arabic -->
            <div>
                <label for="description_ar" class="block text-sm font-medium text-gray-700 mb-2">الوصف (عربي)</label>
                <textarea name="description_ar" id="description_ar" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('description_ar') }}</textarea>
                @error('description_ar')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Logo -->
            <div>
                <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">الشعار</label>
                <input type="file" name="logo" id="logo" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" accept="image/*">
                @error('logo')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Opening Time -->
            <div>
                <label for="opening_time" class="block text-sm font-medium text-gray-700 mb-2">وقت الفتح</label>
                <input type="time" name="opening_time" id="opening_time" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="{{ old('opening_time') }}">
                @error('opening_time')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Closing Time -->
            <div>
                <label for="closing_time" class="block text-sm font-medium text-gray-700 mb-2">وقت الإغلاق</label>
                <input type="time" name="closing_time" id="closing_time" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="{{ old('closing_time') }}">
                @error('closing_time')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Currency -->
            <div>
                <label for="currency" class="block text-sm font-medium text-gray-700 mb-2">العملة</label>
                <input type="text" name="currency" id="currency" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="مثال: QAR" value="{{ old('currency') }}">
                @error('currency')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Subscription Type -->
            <div>
                <label for="subscription_type" class="block text-sm font-medium text-gray-700 mb-2">نوع الاشتراك *</label>
                <select name="subscription_type" id="subscription_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                    <option value="trial" {{ old('subscription_type') == 'trial' ? 'selected' : '' }}>تجريبي</option>
                    <option value="monthly" {{ old('subscription_type') == 'monthly' ? 'selected' : '' }}>شهري</option>
                    <option value="yearly" {{ old('subscription_type') == 'yearly' ? 'selected' : '' }}>سنوي</option>
                </select>
                @error('subscription_type')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Work Days -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">أيام العمل</label>
                <div class="space-y-2">
                    @foreach(['Saturday' => 'السبت', 'Sunday' => 'الأحد', 'Monday' => 'الإثنين', 'Tuesday' => 'الثلاثاء', 'Wednesday' => 'الأربعاء', 'Thursday' => 'الخميس', 'Friday' => 'الجمعة'] as $key => $label)
                        <label class="flex items-center">
                            <input type="checkbox" name="work_days[]" value="{{ $key }}" class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500" {{ (is_array(old('work_days')) && in_array($key, old('work_days'))) ? 'checked' : '' }}>
                            <span class="mr-2 text-gray-700">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
                @error('work_days')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition">
                    إضافة الصالون
                </button>
                <a href="{{ route('superAdmin.salons.index') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg font-medium transition text-center">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
