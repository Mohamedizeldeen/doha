<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NLD - Salon | {{ __('auth.login_title') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/fav.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: '{{ app()->getLocale() === 'ar' ? 'Cairo' : 'Inter' }}', sans-serif; }

        .auth-gradient {
            background: linear-gradient(135deg, #dd208e 0%, #9b1164 30%, #1e1b2e 100%);
        }
        .glass-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        .input-field {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
        }
        .input-field:focus {
            border-color: #dd208e;
            box-shadow: 0 0 0 4px rgba(221,32,142,0.1);
            outline: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, #dd208e, #b01670);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(221,32,142,0.4);
        }
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
        .pulse-dot {
            animation: pulse-dot 2s ease-in-out infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 0.4; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.2); }
        }
    </style>
</head>
<body class="min-h-screen">
    <div class="min-h-screen flex flex-col lg:flex-row">

        <!-- Left Decorative Panel -->
        <div class="hidden lg:flex lg:w-1/2 auth-gradient relative overflow-hidden items-center justify-center p-12">
            <!-- Decorative circles -->
            <div class="absolute top-10 left-10 w-72 h-72 bg-white/5 rounded-full blur-xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-pink-400/10 rounded-full blur-2xl"></div>
            <div class="absolute top-1/2 left-1/4 w-4 h-4 bg-pink-300/60 rounded-full pulse-dot"></div>
            <div class="absolute top-1/3 right-1/3 w-3 h-3 bg-white/40 rounded-full pulse-dot" style="animation-delay:1s"></div>
            <div class="absolute bottom-1/3 left-1/3 w-2 h-2 bg-pink-200/50 rounded-full pulse-dot" style="animation-delay:0.5s"></div>

            <div class="relative z-10 text-center text-white max-w-md float-animation">
                <!-- Logo/Icon -->
                <div class="mb-8">
                    <div class="w-24 h-24 mx-auto bg-white/10 backdrop-blur rounded-3xl flex items-center justify-center border border-white/20">
                        <i class="fas fa-scissors text-4xl text-white"></i>
                    </div>
                </div>
                <h1 class="text-4xl font-bold mb-4">{{ __('landing.brand') }}</h1>
                <p class="text-lg text-pink-100 mb-8">{{ __('auth.register_subtitle') }}</p>
                
                <!-- Features -->
                <div class="space-y-4 text-left">
                    <div class="flex items-center gap-3 bg-white/10 backdrop-blur rounded-xl p-4 border border-white/10">
                        <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-calendar-check text-white"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-sm">{{ __('auth.free_trial') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-white/10 backdrop-blur rounded-xl p-4 border border-white/10">
                        <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-shield-halved text-white"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-sm">{{ __('auth.secure_trusted') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-white/10 backdrop-blur rounded-xl p-4 border border-white/10">
                        <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-mobile-screen text-white"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-sm">{{ __('auth.no_credit_card') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Form Panel -->
        <div class="flex-1 flex items-center justify-center p-6 sm:p-8 lg:p-12 bg-gray-50 relative">
            <!-- Mobile top accent -->
            <div class="lg:hidden absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-[#dd208e] to-[#b01670]"></div>
            
            <div class="w-full max-w-md">
                <!-- Language Toggle -->
                <div class="flex justify-end mb-6">
                    <a href="{{ route('language.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white shadow-sm border border-gray-200 text-sm text-gray-600 hover:bg-gray-50 transition">
                        <i class="fas fa-globe"></i>
                        {{ app()->getLocale() === 'ar' ? 'English' : 'العربية' }}
                    </a>
                </div>

                <!-- Header -->
                <div class="text-center mb-8">
                    <!-- Mobile logo -->
                    <div class="lg:hidden mb-4">
                        <div class="w-16 h-16 mx-auto bg-gradient-to-br from-[#dd208e] to-[#b01670] rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-scissors text-2xl text-white"></i>
                        </div>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">{{ __('auth.login_title') }}</h2>
                    <p class="text-gray-500 text-sm">{{ __('auth.register_subtitle') }}</p>
                </div>

                <!-- Login Card -->
                <div class="glass-card rounded-2xl shadow-xl p-6 sm:p-8 border border-gray-100">
                    <!-- Status Message (e.g., password reset success) -->
                    @if (session('status'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-check-circle text-green-500"></i>
                                <span class="text-sm text-green-700">{{ session('status') }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fas fa-exclamation-circle text-red-500"></i>
                                <span class="text-sm font-semibold text-red-700">{{ app()->getLocale() === 'ar' ? 'خطأ' : 'Error' }}</span>
                            </div>
                            @foreach ($errors->all() as $error)
                                <p class="text-sm text-red-600">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                        @csrf
                        
                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-envelope text-[#dd208e] {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}"></i>
                                {{ __('auth.email') }}
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                                   placeholder="{{ __('auth.email_placeholder') }}"
                                   class="input-field w-full px-4 py-3 rounded-xl text-sm text-gray-900 bg-white">
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-lock text-[#dd208e] {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}"></i>
                                {{ __('auth.password') }}
                            </label>
                            <div class="relative">
                                <input type="password" id="password" name="password" required 
                                       placeholder="{{ __('auth.password_placeholder') }}"
                                       class="input-field w-full px-4 py-3 rounded-xl text-sm text-gray-900 bg-white">
                                <button type="button" onclick="togglePassword()" 
                                        class="absolute top-1/2 -translate-y-1/2 {{ app()->getLocale() === 'ar' ? 'left-3' : 'right-3' }} text-gray-400 hover:text-[#dd208e] transition">
                                    <i id="password-icon" class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Forgot Password -->
                        <div class="flex justify-end">
                            <a href="{{ route('password.request') }}" class="text-sm text-[#dd208e] hover:text-[#b01670] font-medium transition">
                                {{ __('auth.forgot_password') }}
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-primary w-full py-3.5 rounded-xl text-white font-bold text-sm flex items-center justify-center gap-2">
                            <i class="fas fa-sign-in-alt"></i>
                            {{ __('auth.login_button') }}
                        </button>
                    </form>

                    <!-- Back to Home -->
                    <div class="mt-6">
                        <a href="{{ route('home') }}" 
                           class="flex items-center justify-center gap-2 w-full px-4 py-3 border-2 border-gray-300 text-gray-600 rounded-xl font-semibold text-sm hover:bg-gray-100 transition-all">
                            <i class="fas fa-home"></i>
                            {{ __('auth.home_page') }}
                        </a>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-6 text-center">
                    <p class="text-xs text-gray-400">&copy; {{ date('Y') }} NLD Salon. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('password-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>
