<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تسجيل جديد - ضحي</title>
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
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#fde4f1] to-white px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="w-full max-w-md">
            <!-- Card -->
            <div class="bg-white rounded-lg sm:rounded-2xl shadow-lg sm:shadow-2xl p-6 sm:p-8 md:p-12 border border-[#f0b3d8]">
                <!-- Header -->
                <div class="text-center mb-8 sm:mb-12">
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                        <span class="bg-gradient-to-r from-[#dd208e] to-[#b01670] bg-clip-text text-transparent">ضحي</span>
                    </h1>
                    <p class="text-xs sm:text-sm text-gray-600">أنشئ حسابك وابدأ رحلتك مع ضحي</p>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-red-50 border border-red-200 rounded-lg">
                        @foreach ($errors->all() as $error)
                            <p class="text-xs sm:text-sm text-red-700">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('register.store') }}" class="space-y-4 sm:space-y-6">
                    @csrf

                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-xs sm:text-sm font-bold text-gray-700 mb-1 sm:mb-2">الاسم الكامل</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}"
                            placeholder="أدخل اسمك الكامل"
                            class="w-full px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm border-2 border-gray-200 rounded-lg focus:border-[#dd208e] focus:outline-none transition"
                            required
                        >
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-xs sm:text-sm font-bold text-gray-700 mb-1 sm:mb-2">البريد الإلكتروني</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            placeholder="أدخل بريدك الإلكتروني"
                            class="w-full px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm border-2 border-gray-200 rounded-lg focus:border-[#dd208e] focus:outline-none transition"
                            required
                        >
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-xs sm:text-sm font-bold text-gray-700 mb-1 sm:mb-2">كلمة المرور</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password"
                            placeholder="أدخل كلمة مرور قوية"
                            class="w-full px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm border-2 border-gray-200 rounded-lg focus:border-[#dd208e] focus:outline-none transition"
                            required
                        >
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="password_confirmation" class="block text-xs sm:text-sm font-bold text-gray-700 mb-1 sm:mb-2">تأكيد كلمة المرور</label>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation"
                            placeholder="أعد كتابة كلمة المرور"
                            class="w-full px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm border-2 border-gray-200 rounded-lg focus:border-[#dd208e] focus:outline-none transition"
                            required
                        >
                    </div>

                    <!-- Terms -->
                    <div class="flex items-start gap-2">
                        <input type="checkbox" id="terms" name="terms" class="w-4 h-4 mt-0.5" required>
                        <label for="terms" class="text-xs sm:text-sm text-gray-600">
                            أوافق على <a href="#" class="text-[#dd208e] hover:underline">الشروط والأحكام</a>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full px-4 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-[#dd208e] to-[#b01670] text-white font-bold text-xs sm:text-sm sm:text-base rounded-lg hover:shadow-xl hover:scale-105 transition transform"
                    >
                        إنشاء حساب
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-6 sm:my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t-2 border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs sm:text-sm">
                        <span class="px-2 bg-white text-gray-600">هل لديك حساب؟</span>
                    </div>
                </div>

                <!-- Login Link -->
                <a 
                    href="{{ route('login') }}" 
                    class="block w-full text-center px-4 sm:px-6 py-2.5 sm:py-3 border-2 border-[#dd208e] text-[#dd208e] font-bold text-xs sm:text-sm sm:text-base rounded-lg hover:bg-red-50 transition"
                >
                    دخول إلى الحساب
                </a>

                <!-- Back to Home -->
                <div class="mt-6 sm:mt-8 text-center">
                    <a href="{{ route('welcome') }}" class="text-xs sm:text-sm text-gray-600 hover:text-[#dd208e] transition">
                        العودة إلى الصفحة الرئيسية
                    </a>
                </div>
            </div>

            <!-- Trust Indicators -->
            <div class="mt-8 sm:mt-12 text-center">
                <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 justify-center text-xs sm:text-sm text-gray-600">
                    <div class="flex items-center gap-2 justify-center">
                        <span>✅</span>
                        <span>14 يوم تجربة مجانية</span>
                    </div>
                    <div class="flex items-center gap-2 justify-center">
                        <span>🔒</span>
                        <span>آمن وموثوق</span>
                    </div>
                    <div class="flex items-center gap-2 justify-center">
                        <span>📱</span>
                        <span>بدون بطاقة ائتمان</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
