<!DOCTYPE html>
<html lang="ar" dir="rtl" id="htmlElement">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>احجز موعدك - {{ $company ?? 'صالوننا' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }
        .ltr {
            direction: ltr;
        }
        .lang-btn.active {
            background: linear-gradient(135deg, #2563eb, #4f46e5) !important;
            color: white !important;
        }
        .hidden-en {
            display: none;
        }
        html.en .hidden-ar {
            display: none !important;
        }
        html.en .hidden-en {
            display: block !important;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- Header -->
        <div class="text-center mb-12">
            <img src="{{ asset('storage/' . $salon->logo) }}" alt="{{ $salon->name_ar }}" class="mx-auto h-24 w-24 object-contain mb-4">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                <span class="hidden-ar">احجز موعدك معنا</span>
                <span class="hidden-en">Book Your Appointment</span>
            </h1>
           
            <div class="mt-4 flex justify-center gap-4">
                <button class="lang-btn active bg-white py-2 px-4 rounded-lg shadow-md font-semibold transition" onclick="switchLanguage('ar')">
                    عربي
                </button>
                <button class="lang-btn bg-white py-2 px-4 rounded-lg shadow-md font-semibold transition" onclick="switchLanguage('en')">
                    English
                </button>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-8 bg-green-50 border-2 border-green-200 rounded-xl p-6 max-w-2xl mx-auto">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">✓</span>
                    <div>
                        <p class="text-green-800 font-bold text-lg success-title" data-ar="تم بنجاح! سنقوم بالاتصال بك قريبًا." data-en="Success! we will contact you shortly.">تم بنجاح!</p>
                        
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <form method="POST" action="{{ route('booking.public.store', $company) }}" class="space-y-6">
                        @csrf

                        <!-- Customer Information -->
                        <div class="border-b-2 border-blue-200 pb-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                                <span class="hidden-ar">معلومات العميل</span>
                                <span class="hidden-en">Customer Information</span>
                            </h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <span class="hidden-ar">الاسم الكامل</span>
                                        <span class="hidden-en">Full Name</span>
                                    </label>
                                    <input type="text" id="name" name="name" required
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                        placeholder="أدخل اسمك" data-en-placeholder="Enter your name">
                                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <span class="hidden-ar">رقم الهاتف</span>
                                        <span class="hidden-en">Phone Number</span>
                                    </label>
                                    <input type="tel" id="phone" name="phone" required
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition ltr"
                                        placeholder="+966 50 0000000" data-ar-placeholder="+966 50 0000000">
                                    @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Email -->
                                <div class="md:col-span-2">
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <span class="hidden-ar">البريد الإلكتروني</span>
                                        <span class="hidden-en">Email Address</span>
                                    </label>
                                    <input type="email" id="email" name="email" required
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition ltr"
                                        placeholder="your@email.com" data-ar-placeholder="بريدك@بريد.com">
                                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Service & Staff Selection -->
                        <div class="border-b-2 border-blue-200 pb-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                                <span class="hidden-ar">اختر الخدمة والعاملة</span>
                                <span class="hidden-en">Select Service & Staff</span>
                            </h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Staff -->
                                <div>
                                    <label for="staff" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <span class="hidden-ar">الموظف</span>
                                        <span class="hidden-en">Staff</span>
                                    </label>
                                    <select id="staff" name="staff_id" required
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                        <option value="" data-ar="أي عاملة متاحة" data-en="Any Available Staff">أي عاملة متاحة</option>
                                        @foreach($staff as $member)
                                            <option value="{{ $member->id }}" data-ar="{{ $member->name_ar }}" data-en="{{ $member->name_en ?? $member->name_ar }}">
                                                {{ $member->name_ar }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('staff_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Service -->
                                <div>
                                    <label for="service" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <span class="hidden-ar">الخدمة المطلوبة</span>
                                        <span class="hidden-en">Required Service</span>
                                    </label>
                                    <select id="service" name="service_id" required
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                        <option value="" data-ar="اختر خدمة" data-en="Choose Service">اختر خدمة</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}" data-ar="{{ $service->name_ar }} - {{ $service->price }} {{ $salon->currency  }}" data-en="{{ $service->name_en ?? $service->name_ar }} - {{ $service->price }} {{ $salon->currency }}" data-staff-ids="@json($service->staff->pluck('id')->toArray())">
                                                {{ $service->name_ar }} - {{ $service->price }} {{ $salon->currency ?? '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="service-warning" class="mt-2 text-amber-600 text-sm hidden">
                                        <span class="hidden-ar">💡 الرجاء اختيار موظفة أولاً لعرض الخدمات المتاحة</span>
                                        <span class="hidden-en">💡 Please select a staff member first to see available services</span>
                                    </div>
                                    @error('service_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Date & Time -->
                        <div class="pb-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                                <span class="hidden-ar">اختر الموعد</span>
                                <span class="hidden-en">Select Date & Time</span>
                            </h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Date -->
                                <div>
                                    <label for="date" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <span class="hidden-ar">التاريخ</span>
                                        <span class="hidden-en">Date</span>
                                    </label>
                                    <input type="date" id="date" name="appointment_date" required
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition ltr"
                                        min="{{ date('Y-m-d') }}">
                                    @error('appointment_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Time -->
                                <div>
                                    <label for="time" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <span class="hidden-ar">الوقت</span>
                                        <span class="hidden-en">Time</span>
                                    </label>
                                    <select id="time" name="appointment_time" required
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                        <option value="" data-ar="اختر وقتاً" data-en="Select Time">اختر وقتاً</option>
                                    </select>
                                    @error('appointment_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    <div id="availability-warning" class="mt-2 text-red-600 text-sm hidden">
                                        <span class="hidden-ar">⚠️ هذا الوقت غير متاح</span>
                                        <span class="hidden-en">⚠️ This time is not available</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-4">
                            <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold py-4 rounded-lg hover:from-blue-700 hover:to-indigo-700 transition shadow-lg">
                                <span class="hidden-ar">✓ احجز الموعد الآن</span>
                                <span class="hidden-en">✓ Book Appointment Now</span>
                            </button>
                            <a href="/" class="flex-1 bg-gray-200 text-gray-800 font-bold py-4 rounded-lg hover:bg-gray-300 transition text-center">
                                <span class="hidden-ar">← العودة</span>
                                <span class="hidden-en">← Back</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column - Info -->
            <div>
                <!-- Salon Info Card -->
                <div class="bg-white rounded-2xl shadow-xl p-8 mb-6 sticky top-4">
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">
                            <span class="hidden-ar">{{ $salon->name_ar }}</span>
                            <span class="hidden-en">{{ $salon->name_en ?? $salon->name_ar }}</span>
                        </h3>
                        
                    </div>

                    <!-- Contact Info -->
                    <div class="space-y-4 mb-6">
                        <div class="flex items-center justify-center gap-2">
                            <span class="text-gray-700">📞</span>
                            <span class="text-gray-700 ltr">{{ $salon->phone }}</span>
                        </div>
                        <div class="flex items-center justify-center gap-2">
                            <span class="text-gray-700">📧</span>
                            <span class="text-gray-700 ltr">{{ $salon->email }}</span>
                        </div>
                        <div class="flex items-center justify-center gap-2">
                            <span class="text-gray-700">📍</span>
                            <span class="text-gray-700">
                                <span class="hidden-ar">{{ $salon->address_ar }}</span>
                                <span class="hidden-en">{{ $salon->address_en ?? $salon->address_ar }}</span>
                            </span>
                        </div>
                    </div>

                   
                 

                    <hr class="my-6">
                     <!-- Working Hours -->
                    <div class="mb-6">
                        <h4 class="font-bold text-gray-900 mb-4">
                            <span class="hidden-ar">ساعات العمل</span>
                            <span class="hidden-en">Working Hours</span>
                        </h4>
                        @php
                            $workDays = is_string($salon->work_days) ? json_decode($salon->work_days, true) : $salon->work_days;
                        @endphp
                        <ul class="text-gray-700 space-y-2">
                            @foreach($workDays as $day)
                                <li class="flex items-center justify-between">
                                    <span class="hidden-ar">{{ $day }}</span>
                                    <span class="hidden-en">
                                        @switch($day)
                                            @case('Saturday') Saturday @break
                                            @case('Sunday') Sunday @break
                                            @case('Monday') Monday @break
                                            @case('Tuesday') Tuesday @break
                                            @case('Wednesday') Wednesday @break
                                            @case('Thursday') Thursday @break
                                            @case('Friday') Friday @break
                                        @endswitch
                                    </span>
                                    <span>{{ date('H:i', strtotime($salon->closing_time)) }} - {{ date('H:i', strtotime($salon->opening_time)) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <hr class="my-6">

                    <!-- Features -->
                <div class="bg-indigo-50 rounded-2xl p-6">
                    <h4 class="font-bold text-gray-900 mb-4">
                        <span class="hidden-ar">لماذا نختارنا؟</span>
                        <span class="hidden-en">Why Choose Us?</span>
                    </h4>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start gap-3">
                            <span class="text-indigo-600 mt-1">⭐</span>
                            <span class="text-gray-700">
                                <span class="hidden-ar">خدمة عملاء ممتازة</span>
                                <span class="hidden-en">Excellent Customer Service</span>
                            </span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-indigo-600 mt-1">⭐</span>
                            <span class="text-gray-700">
                                <span class="hidden-ar">منتجات عالية الجودة</span>
                                <span class="hidden-en">High Quality Products</span>
                            </span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-indigo-600 mt-1">⭐</span>
                            <span class="text-gray-700">
                                <span class="hidden-ar">عاملات محترفات وذوات خبرة</span>
                                <span class="hidden-en">Professional & Experienced Staff</span>
                            </span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-indigo-600 mt-1">⭐</span>
                            <span class="text-gray-700">
                                <span class="hidden-ar">أسعار منافسة</span>
                                <span class="hidden-en">Competitive Prices</span>
                            </span>
                        </li>
                    </ul>
                </div>
                </div>

               
            </div>
        </div>

        <!-- Products Section - Minimal Design -->
        @if($products->count() > 0)
            <div class="mt-20 py-16 bg-white">
                <div class="px-6">
                    <!-- Header -->
                    <div class="text-center mb-12">
                        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-3">
                            <span class="hidden-ar">منتجاتنا</span>
                            <span class="hidden-en">Our Products</span>
                        </h2>
                        <p class="text-lg text-gray-500">
                            <span class="hidden-ar">اختر أفضل المنتجات لك</span>
                            <span class="hidden-en">Choose the best products for you</span>
                        </p>
                    </div>

                    <!-- Products Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                        @foreach($products as $product)
                            <div class="group relative bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                                <!-- Image Container with Overlay -->
                                <div class="relative h-56 sm:h-64 md:h-72 overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name_ar }}" 
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-50">
                                            <span class="text-gray-300 text-5xl sm:text-6xl">📦</span>
                                        </div>
                                    @endif
                                    
                                    <!-- Dark Overlay on Hover -->
                                    <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                                    
                                    <!-- Price Badge - Bottom Left -->
                                    <div class="absolute bottom-4 left-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-3 sm:px-4 py-2 rounded-xl font-bold text-sm sm:text-base shadow-lg">
                                        <span class="hidden-ar">{{ $product->price }} {{ $salon->currency }}</span>
                                        <span class="hidden-en">{{ $product->price }} {{ $salon->currency }}</span>
                                    </div>

                                    <!-- Stock Badge - Top Right -->
                                    <div class="absolute top-4 right-4">
                                        @if($product->stock_quantity > 0)
                                            <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-3 py-1.5 rounded-full text-xs sm:text-sm font-bold shadow-md flex items-center gap-1">
                                                <span class="text-lg">✓</span>
                                                <span class="hidden-ar">متوفر</span>
                                                <span class="hidden-en">Available</span>
                                            </div>
                                        @else
                                            <div class="bg-gradient-to-r from-red-500 to-rose-600 text-white px-3 py-1.5 rounded-full text-xs sm:text-sm font-bold shadow-md flex items-center gap-1">
                                                <span class="text-lg">✕</span>
                                                <span class="hidden-ar">نفد</span>
                                                <span class="hidden-en">Out</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Content Section -->
                                <div class="p-4 sm:p-6">
                                    <!-- Title -->
                                    <h3 class="text-base sm:text-lg md:text-xl font-bold text-gray-900 mb-2 product-name line-clamp-2 group-hover:text-blue-600 transition-colors duration-300" data-ar="{{ $product->name_ar }}" data-en="{{ $product->name_en ?? $product->name_ar }}">
                                        {{ $product->name_ar }}
                                    </h3>

                                    <!-- Description -->
                                    @if(!empty($product->description_ar))
                                        <p class="text-gray-600 text-xs sm:text-sm leading-relaxed mb-4 line-clamp-2 product-description" data-ar="{{ $product->description_ar }}" data-en="{{ $product->description_en ?? $product->description_ar }}">
                                            {{ $product->description_ar }}
                                        </p>
                                    @else
                                        <div class="h-6 sm:h-8 mb-4"></div>
                                    @endif

                                    <!-- Divider -->
                                    <div class="w-12 h-1 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full mb-4"></div>

                                    <!-- Stock Info Footer -->
                                    <div class="flex items-center justify-between pt-2 sm:pt-4">
                                        <span class="text-gray-600 text-xs sm:text-sm font-medium">
                                            <span class="hidden-ar">الكمية المتاحة:</span>
                                            <span class="hidden-en">Stock:</span>
                                        </span>
                                        @if ($product->stock_quantity > 0)
                                            <span class="inline-flex items-center justify-center px-3 py-1 bg-green-100 text-green-700 rounded-full font-bold text-sm">
                                                {{ $product->stock_quantity }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center justify-center px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs sm:text-sm font-bold">
                                                <span class="hidden-ar">غير متوفر</span>
                                                <span class="hidden-en">Not Available</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Subtle Bottom Border -->
                                <div class="h-1 bg-gradient-to-r from-blue-400 via-indigo-400 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-16 py-8">
        <div class="container mx-auto px-4 text-center">
            <p class="text-gray-400 footer-text" data-ar="{{ $salon->name_ar }} © 2026 - جميع الحقوق محفوظة" data-en="{{ $salon->name_en ?? $salon->name_ar }} © 2026 - All Rights Reserved">
                {{ $salon->name_ar }} © 2026 - جميع الحقوق محفوظة
            </p>
             <a href="https://www.instagram.com/mohamed_izeldeen/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 text-gray-400 hover:text-[#b01670] mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M7 2C4.23858 2 2 4.23858 2 7v10c0 2.7614 2.23858 5 5 5h10c2.7614 0 5-2.2386 5-5V7c0-2.76142-2.2386-5-5-5H7zm10 2c1.657 0 3 1.343 3 3v10c0 1.657-1.343 3-3 3H7c-1.657 0-3-1.343-3-3V7c0-1.657 1.343-3 3-3h10zM12 7.75a4.25 4.25 0 100 8.5 4.25 4.25 0 000-8.5zm0 2a2.25 2.25 0 110 4.5 2.25 2.25 0 010-4.5zM17.5 6.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                        </svg>
                        <span>تم التطوير بواسطة محمد عزالدين</span>
                    </a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Update success message based on language
        function updateSuccessMessage(lang) {
            const successTitle = document.querySelector('.success-title');
            if (successTitle) {
                successTitle.textContent = lang === 'ar' ? successTitle.getAttribute('data-ar') : successTitle.getAttribute('data-en');
            }
        }

        // Update product names and descriptions based on language
        function updateProductText(lang) {
            const productNames = document.querySelectorAll('.product-name');
            const productDescriptions = document.querySelectorAll('.product-description');
            
            productNames.forEach(elem => {
                elem.textContent = lang === 'ar' ? elem.getAttribute('data-ar') : elem.getAttribute('data-en');
            });
            
            productDescriptions.forEach(elem => {
                elem.textContent = lang === 'ar' ? elem.getAttribute('data-ar') : elem.getAttribute('data-en');
            });
        }

        // Update footer based on language
        function updateFooter(lang) {
            const footerText = document.querySelector('.footer-text');
            if (footerText) {
                footerText.textContent = lang === 'ar' ? footerText.getAttribute('data-ar') : footerText.getAttribute('data-en');
            }
        }

        // Update select options based on language
        function updateSelectOptions(lang) {
            const serviceSelect = document.getElementById('service');
            const staffSelect = document.getElementById('staff');
            const timeSelect = document.getElementById('time');
            
            if (serviceSelect) {
                const serviceOptions = serviceSelect.querySelectorAll('option');
                serviceOptions.forEach(option => {
                    if (lang === 'ar') {
                        option.textContent = option.getAttribute('data-ar') || option.textContent;
                    } else {
                        option.textContent = option.getAttribute('data-en') || option.textContent;
                    }
                });
            }
            
            if (staffSelect) {
                const staffOptions = staffSelect.querySelectorAll('option');
                staffOptions.forEach(option => {
                    if (lang === 'ar') {
                        option.textContent = option.getAttribute('data-ar') || option.textContent;
                    } else {
                        option.textContent = option.getAttribute('data-en') || option.textContent;
                    }
                });
            }

            if (timeSelect) {
                const timeOptions = timeSelect.querySelectorAll('option');
                timeOptions.forEach(option => {
                    if (lang === 'ar') {
                        option.textContent = option.getAttribute('data-ar') || option.textContent;
                    } else {
                        option.textContent = option.getAttribute('data-en') || option.textContent;
                    }
                });
            }
        }

        // Update placeholders based on language
        function updatePlaceholders(lang) {
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            
            if (lang === 'ar') {
                nameInput.placeholder = 'أدخل اسمك';
                emailInput.placeholder = 'بريدك@بريد.com';
            } else {
                nameInput.placeholder = nameInput.getAttribute('data-en-placeholder') || 'Enter your name';
                emailInput.placeholder = emailInput.getAttribute('data-ar-placeholder') || 'your@email.com';
            }
        }

        // Language switching function
        function switchLanguage(lang) {
            const htmlElement = document.documentElement;
            const arBtn = document.querySelectorAll('.lang-btn')[0];
            const enBtn = document.querySelectorAll('.lang-btn')[1];
            
            if (lang === 'ar') {
                htmlElement.classList.remove('en');
                htmlElement.lang = 'ar';
                htmlElement.dir = 'rtl';
                arBtn.classList.add('active');
                enBtn.classList.remove('active');
                localStorage.setItem('language', 'ar');
            } else if (lang === 'en') {
                htmlElement.classList.add('en');
                htmlElement.lang = 'en';
                htmlElement.dir = 'ltr';
                enBtn.classList.add('active');
                arBtn.classList.remove('active');
                localStorage.setItem('language', 'en');
            }
            updatePlaceholders(lang);
            updateSelectOptions(lang);
            updateProductText(lang);
            updateFooter(lang);
            updateSuccessMessage(lang);
        }

        // Initialize language on page load
        document.addEventListener('DOMContentLoaded', function() {
            const savedLanguage = localStorage.getItem('language') || 'ar';
            switchLanguage(savedLanguage);

            // Initialize service filtering
            const staffSelect = document.getElementById('staff');
            const serviceSelect = document.getElementById('service');
            const serviceWarning = document.getElementById('service-warning');

            function filterServices() {
                const selectedStaffId = staffSelect.value;
                
                if (!selectedStaffId) {
                    // Show warning for RTL
                    serviceWarning.classList.remove('hidden');
                    
                    // Show all service options
                    Array.from(serviceSelect.options).forEach(option => {
                        if (option.value !== '') {
                            option.hidden = false;
                        }
                    });
                    return;
                }

                // Hide warning
                serviceWarning.classList.add('hidden');

                // Filter services based on staff selection
                Array.from(serviceSelect.options).forEach(option => {
                    if (option.value === '') {
                        option.hidden = false;
                        return;
                    }

                    const staffIds = JSON.parse(option.getAttribute('data-staff-ids') || '[]');
                    option.hidden = !staffIds.includes(parseInt(selectedStaffId));
                });

                // Reset service selection if it's now hidden
                if (serviceSelect.value && serviceSelect.options[serviceSelect.selectedIndex].hidden) {
                    serviceSelect.value = '';
                }
            }

            if (staffSelect && serviceSelect) {
                staffSelect.addEventListener('change', filterServices);
                filterServices(); // Initial call
            }

            // Date and Time restrictions based on salon working hours
            const workDays = @json(is_string($salon->work_days) ? json_decode($salon->work_days, true) : $salon->work_days);
            const openingTime = '{{ $salon->opening_time }}';
            const closingTime = '{{ $salon->closing_time }}';
            const dateInput = document.getElementById('date');
            const timeSelect = document.getElementById('time');

            // Day name mapping
            const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

            // Function to check if date is a working day
            function isWorkingDay(date) {
                const dayName = dayNames[date.getDay()];
                return workDays.includes(dayName);
            }

            // Function to disable non-working days
            function disableDates(date) {
                return !isWorkingDay(date);
            }

            // Initialize Flatpickr date picker with working days only
            flatpickr(dateInput, {
                minDate: new Date(),
                disable: [disableDates],
                dateFormat: 'Y-m-d',
                onChange: function(selectedDates) {
                    if (selectedDates.length > 0) {
                        generateTimeSlots();
                    }
                }
            });

            // Function to generate time slots
            function generateTimeSlots() {
                // Parse opening and closing times
                const openParts = openingTime.split(':');
                const closeParts = closingTime.split(':');
                
                const openHour = parseInt(openParts[0]);
                const openMin = parseInt(openParts[1]);
                const closeHour = parseInt(closeParts[0]);
                const closeMin = parseInt(closeParts[1]);
                
                timeSelect.innerHTML = '<option value="" data-ar="اختر وقتاً" data-en="Select Time">اختر وقتاً</option>';
                
                // Generate 30-minute intervals
                let currentHour = openHour;
                let currentMin = openMin;
                
                while (currentHour < closeHour || (currentHour === closeHour && currentMin < closeMin)) {
                    const timeStr = String(currentHour).padStart(2, '0') + ':' + String(currentMin).padStart(2, '0');
                    const option = document.createElement('option');
                    option.value = timeStr;
                    option.textContent = timeStr;
                    option.dataset.available = 'checking'; // Mark as checking
                    timeSelect.appendChild(option);
                    
                    // Add 30 minutes
                    currentMin += 30;
                    if (currentMin >= 60) {
                        currentMin = 0;
                        currentHour += 1;
                    }
                }
                
                // Check staff availability after generating slots
                checkAllTimesAvailability();
            }

            // Function to check if time slot is available for the staff
            function checkAllTimesAvailability() {
                const selectedDate = dateInput.value;
                const selectedStaffId = document.getElementById('staff').value;
                const selectedServiceId = document.getElementById('service').value;

                if (!selectedDate || !selectedStaffId || !selectedServiceId) {
                    return;
                }

                const timeOptions = timeSelect.querySelectorAll('option[value!=""]');
                timeOptions.forEach(option => {
                    const time = option.value;
                    
                    // Call API to check availability
                    fetch(`/api/staff/${selectedStaffId}/availability?date=${selectedDate}&time=${time}&service_id=${selectedServiceId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.available) {
                                option.disabled = false;
                                option.dataset.available = 'true';
                                option.textContent = time;
                            } else {
                                option.disabled = true;
                                option.dataset.available = 'false';
                                option.textContent = time + ' (غير متاح / Unavailable)';
                            }
                        })
                        .catch(error => {
                            console.error('Error checking availability:', error);
                        });
                });
            }

            // Set date input to only allow working days
            dateInput.addEventListener('change', function() {
                if (this.value) {
                    generateTimeSlots();
                }
            });

            // Check availability when staff changes
            document.getElementById('staff').addEventListener('change', function() {
                if (dateInput.value) {
                    checkAllTimesAvailability();
                }
            });

            // Check availability when service changes
            document.getElementById('service').addEventListener('change', function() {
                if (dateInput.value) {
                    checkAllTimesAvailability();
                }
            });

            // Generate initial time slots
            generateTimeSlots();
        });
    </script>
</body>
</html>
