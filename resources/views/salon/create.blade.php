<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>إنشاء صالون جديد - ضحي</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            font-family: 'Cairo', sans-serif;
        }
    </style>
</head>
<body>
    <div class="min-h-screen bg-gradient-to-br from-[#fde4f1] to-white px-4 sm:px-6 lg:px-8 py-8 sm:py-12 md:py-16">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8 sm:mb-12">
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900 mb-3 sm:mb-4">
                    <span class="bg-gradient-to-r from-[#dd208e] to-[#b01670] bg-clip-text text-transparent">أنشئ صالونك</span>
                </h1>
                <p class="text-sm sm:text-base md:text-lg text-gray-600 max-w-xl mx-auto px-2">
                    أكمل معنا لإنشاء صالونك وابدأ مع 14 يوم تجربة مجانية
                </p>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-lg sm:rounded-2xl shadow-lg sm:shadow-2xl p-6 sm:p-8 md:p-12 border border-[#f0b3d8]">
                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mb-6 sm:mb-8 p-4 sm:p-6 bg-red-50 border border-red-200 rounded-lg">
                        @foreach ($errors->all() as $error)
                            <p class="text-xs sm:text-sm text-red-700 mb-1">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('salon.store') }}" enctype="multipart/form-data" class="space-y-6 sm:space-y-8">
                    @csrf

                    <!-- Salon Names -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <label for="name_en" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">اسم الصالون (إنجليزي)</label>
                            <input 
                                type="text" 
                                id="name_en" 
                                name="name_en" 
                                value="{{ old('name_en') }}"
                                placeholder="Your Salon Name"
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm border-2 border-gray-200 rounded-lg focus:border-[#dd208e] focus:outline-none transition"
                                required
                            >
                        </div>
                        <div>
                            <label for="name_ar" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">اسم الصالون (العربية)</label>
                            <input 
                                type="text" 
                                id="name_ar" 
                                name="name_ar" 
                                value="{{ old('name_ar') }}"
                                placeholder="اسم الصالون"
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm border-2 border-gray-200 rounded-lg focus:border-[#dd208e] focus:outline-none transition"
                                required
                            >
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <label for="phone" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">رقم الهاتف</label>
                            <input 
                                type="text" 
                                id="phone" 
                                name="phone" 
                                value="{{ old('phone') }}"
                                placeholder="+966..."
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm border-2 border-gray-200 rounded-lg focus:border-[#dd208e] focus:outline-none transition"
                            >
                        </div>
                        <div>
                            <label for="email" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">البريد الإلكتروني</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                placeholder="salon@example.com"
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm border-2 border-gray-200 rounded-lg focus:border-[#dd208e] focus:outline-none transition"
                            >
                        </div>
                    </div>

                    <!-- Addresses -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <label for="address_en" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">العنوان (إنجليزي)</label>
                            <input 
                                type="text" 
                                id="address_en" 
                                name="address_en" 
                                value="{{ old('address_en') }}"
                                placeholder="123 Main Street"
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm border-2 border-gray-200 rounded-lg focus:border-[#dd208e] focus:outline-none transition"
                            >
                        </div>
                        <div>
                            <label for="address_ar" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">العنوان (العربية)</label>
                            <input 
                                type="text" 
                                id="address_ar" 
                                name="address_ar" 
                                value="{{ old('address_ar') }}"
                                placeholder="شارع النيل"
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm border-2 border-gray-200 rounded-lg focus:border-[#dd208e] focus:outline-none transition"
                            >
                        </div>
                    </div>

                    <!-- Descriptions -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <label for="description_en" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">الوصف (إنجليزي)</label>
                            <textarea 
                                id="description_en" 
                                name="description_en"
                                rows="3"
                                placeholder="Describe your salon..."
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm border-2 border-gray-200 rounded-lg focus:border-[#dd208e] focus:outline-none transition resize-none"
                            ></textarea>
                        </div>
                        <div>
                            <label for="description_ar" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">الوصف (العربية)</label>
                            <textarea 
                                id="description_ar" 
                                name="description_ar"
                                rows="3"
                                placeholder="اوصف صالونك..."
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm border-2 border-gray-200 rounded-lg focus:border-[#dd208e] focus:outline-none transition resize-none"
                            ></textarea>
                        </div>
                    </div>

                    <!-- Logo Upload -->
                    <div>
                        <label for="logo" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">شعار الصالون</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 sm:p-8 text-center hover:border-[#dd208e] transition cursor-pointer" onclick="document.getElementById('logo').click()">
                            <input 
                                type="file" 
                                id="logo" 
                                name="logo" 
                                accept="image/*"
                                class="hidden"
                                onchange="updateFileName(this)"
                            >
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-2" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20a4 4 0 004 4h24a4 4 0 004-4V20m-8-12l-3.172-3.172a4 4 0 00-5.656 0L28 20M20 32a4 4 0 100-8 4 4 0 000 8z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            <p class="text-xs sm:text-sm text-gray-600"><span id="fileName">اضغط أو انقل الملف هنا</span></p>
                        </div>
                    </div>

                    <!-- Work Days -->
                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-3">أيام العمل</label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            @php
                                $days = ['Saturday' => 'السبت', 'Sunday' => 'الأحد', 'Monday' => 'الاثنين', 'Tuesday' => 'الثلاثاء', 'Wednesday' => 'الأربعاء', 'Thursday' => 'الخميس', 'Friday' => 'الجمعة'];
                                $selectedDays = old('work_days', []);
                            @endphp
                            @foreach($days as $day => $dayAr)
                                <label class="flex items-center">
                                    <input 
                                        type="checkbox" 
                                        name="work_days[]" 
                                        value="{{ $day }}"
                                        {{ in_array($day, $selectedDays) ? 'checked' : '' }}
                                        class="w-4 h-4 text-[#dd208e] rounded focus:ring-[#dd208e]"
                                    >
                                    <span class="ml-2 text-xs sm:text-sm text-gray-700">{{ $dayAr }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Operating Hours -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <label for="opening_time" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">وقت الفتح</label>
                            <input 
                                type="time" 
                                id="opening_time" 
                                name="opening_time" 
                                value="{{ old('opening_time') }}"
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm border-2 border-gray-200 rounded-lg focus:border-[#dd208e] focus:outline-none transition"
                            >
                        </div>
                        <div>
                            <label for="closing_time" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">وقت الإغلاق</label>
                            <input 
                                type="time" 
                                id="closing_time" 
                                name="closing_time" 
                                value="{{ old('closing_time') }}"
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm border-2 border-gray-200 rounded-lg focus:border-[#dd208e] focus:outline-none transition"
                            >
                        </div>
                    </div>

                    <!-- Currency -->
                    <div>
                        <label for="currency" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">العملة</label>
                        <select 
                            id="currency" 
                            name="currency" 
                            class="w-full px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm border-2 border-gray-200 rounded-lg focus:border-[#dd208e] focus:outline-none transition"
                        >
                            <option value="">-- اختر العملة --</option>
                            <option value="SAR" {{ old('currency') == 'SAR' ? 'selected' : '' }}>الريال السعودي (ريال)</option>
                            <option value="AED" {{ old('currency') == 'AED' ? 'selected' : '' }}>الدرهم الإماراتي (د.إ)</option>
                            <option value="KWD" {{ old('currency') == 'KWD' ? 'selected' : '' }}>الدينار الكويتي (د.ك)</option>
                            <option value="QAR" {{ old('currency') == 'QAR' ? 'selected' : '' }}>الريال القطري (ر.ق)</option>
                            <option value="OMR" {{ old('currency') == 'OMR' ? 'selected' : '' }}>الريال العماني (ر.ع.)</option>
                            <option value="BHD" {{ old('currency') == 'BHD' ? 'selected' : '' }}>الدينار البحريني (د.ب)</option>
                            <option value="EGP" {{ old('currency') == 'EGP' ? 'selected' : '' }}>الجنيه المصري (ج.م)</option>
                            <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>الدولار الأمريكي ($)</option>
                            <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>اليورو (€)</option>
                        </select>
                    </div>

                    <!-- Subscription Type -->
                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-3 sm:mb-4">نوع الاشتراك</label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <label class="relative">
                                <input 
                                    type="radio" 
                                    name="subscription_type" 
                                    value="trial" 
                                    checked
                                    class="sr-only"
                                >
                                <div class="p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-[#dd208e] transition peer-checked:border-[#dd208e]">
                                    <div class="text-lg font-bold text-gray-900 mb-1">🎁 تجربة مجانية</div>
                                    <div class="text-xs text-gray-600">14 يوم مجانًا</div>
                                </div>
                            </label>

                           

                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full px-6 py-3 sm:py-4 bg-gradient-to-r from-[#dd208e] to-[#b01670] text-white font-bold text-sm sm:text-base rounded-lg hover:shadow-xl hover:scale-105 transition transform"
                    >
                        إنشاء الصالون والبدء الآن
                    </button>

                    <!-- Info -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                        <p class="text-xs sm:text-sm text-blue-700">
                            ✅ ستكون المسؤول الرئيسي لهذا الصالون افتراضيًا
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            if (input.files && input.files[0]) {
                document.getElementById('fileName').textContent = input.files[0].name;
            }
        }
    </script>
</body>
</html>
