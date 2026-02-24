<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>NLD - Salon</title>
        <link rel="icon" type="image/png" href="{{ asset('images/fav.png') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            [dir="rtl"] body { font-family: 'Cairo', sans-serif; }
            [dir="ltr"] body { font-family: 'Inter', sans-serif; }

            /* Navbar glass */
            .nav-glass {
                background: rgba(255,255,255,0.85);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                transition: all 0.3s ease;
            }
            .nav-glass.scrolled {
                background: rgba(255,255,255,0.95);
                box-shadow: 0 4px 30px rgba(0,0,0,0.08);
            }

            /* Hero gradient animation */
            .hero-gradient {
                background: linear-gradient(135deg, #fde4f1 0%, #f8c8e4 25%, #f0e6ff 50%, #fde4f1 75%, #fff5f9 100%);
                background-size: 400% 400%;
                animation: gradientShift 8s ease infinite;
            }
            @keyframes gradientShift {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            /* Float animations */
            .float-1 { animation: float1 6s ease-in-out infinite; }
            .float-2 { animation: float2 8s ease-in-out infinite; }
            .float-3 { animation: float3 7s ease-in-out infinite; }
            @keyframes float1 { 0%,100% { transform: translateY(0) rotate(0deg); } 50% { transform: translateY(-20px) rotate(5deg); } }
            @keyframes float2 { 0%,100% { transform: translateY(0) rotate(0deg); } 50% { transform: translateY(-15px) rotate(-3deg); } }
            @keyframes float3 { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-25px); } }

            /* Reveal on scroll */
            .reveal { opacity: 0; transform: translateY(30px); transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1); }
            .reveal.visible { opacity: 1; transform: translateY(0); }

            /* Card hover */
            .card-hover { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
            .card-hover:hover { transform: translateY(-8px); box-shadow: 0 20px 60px rgba(221,32,142,0.15); }

            /* Gradient text */
            .gradient-text { background: linear-gradient(135deg, #dd208e, #b01670, #8b1058); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

            /* Button glow */
            .btn-glow { position: relative; overflow: hidden; }
            .btn-glow::after { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 60%); opacity: 0; transition: opacity 0.3s; }
            .btn-glow:hover::after { opacity: 1; }

            /* Pulse badge */
            .pulse-badge { animation: pulseBadge 2s ease-in-out infinite; }
            @keyframes pulseBadge { 0%,100% { box-shadow: 0 0 0 0 rgba(221,32,142,0.4); } 50% { box-shadow: 0 0 0 10px rgba(221,32,142,0); } }

            /* Icon box */
            .icon-box { width: 56px; height: 56px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0; }

            /* Counter animation */
            .counter { display: inline-block; }
        </style>
    </head>
    <body class="bg-white text-gray-900 overflow-x-hidden">

        <!-- Navigation -->
        <nav id="navbar" class="fixed top-0 w-full nav-glass z-50 border-b border-gray-100/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16 lg:h-18">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        
                        <span class="text-xl font-bold gradient-text">{{ __('landing.brand') }}</span>
                    </a>

                    <!-- Desktop Nav -->
                    <div class="hidden lg:flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-6 space-x-reverse' : 'space-x-6' }}">
                        <a href="#about" class="text-sm font-medium text-gray-600 hover:text-[#dd208e] transition">{{ __('landing.nav_about') }}</a>
                        <a href="#services" class="text-sm font-medium text-gray-600 hover:text-[#dd208e] transition">{{ __('landing.nav_services') }}</a>
                        <a href="#features" class="text-sm font-medium text-gray-600 hover:text-[#dd208e] transition">{{ __('landing.nav_features') }}</a>
                        <a href="#pricing" class="text-sm font-medium text-gray-600 hover:text-[#dd208e] transition">{{ __('landing.nav_pricing') }}</a>
                        <a href="{{ route('blogs.public.index') }}" class="text-sm font-medium text-gray-600 hover:text-[#dd208e] transition">{{ __('landing.nav_blog') }}</a>
                        <a href="#contact" class="text-sm font-medium text-gray-600 hover:text-[#dd208e] transition">{{ __('landing.nav_contact') }}</a>
                    </div>

                    <div class="flex items-center gap-3">
                        <!-- Language -->
                        @if(app()->getLocale() === 'ar')
                            <a href="{{ route('language.switch', 'en') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-gray-600 bg-gray-100 rounded-full hover:bg-gray-200 transition">
                                <i class="fas fa-globe"></i> EN
                            </a>
                        @else
                            <a href="{{ route('language.switch', 'ar') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-gray-600 bg-gray-100 rounded-full hover:bg-gray-200 transition">
                                <i class="fas fa-globe"></i> عربي
                            </a>
                        @endif

                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('admin.dashboard') }}" class="px-5 py-2 bg-gradient-to-r from-[#dd208e] to-[#b01670] text-white text-sm font-semibold rounded-xl hover:shadow-lg transition btn-glow">{{ __('landing.dashboard') }}</a>
                            @else
                                <a href="{{ route('login') }}" class="px-5 py-2 text-sm font-semibold text-[#dd208e] border-2 border-[#dd208e] rounded-xl hover:bg-[#dd208e] hover:text-white transition">{{ __('landing.login') }}</a>
                            @endauth
                        @endif

                        <!-- Mobile Menu Toggle -->
                        <button id="mobile-toggle" class="lg:hidden p-2 text-gray-600 hover:text-[#dd208e]">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Mobile Menu -->
                <div id="mobile-menu" class="lg:hidden hidden pb-4 border-t border-gray-100 mt-2">
                    <div class="flex flex-col gap-2 pt-3">
                        <a href="#about" class="px-3 py-2 text-sm text-gray-600 hover:text-[#dd208e] hover:bg-pink-50 rounded-lg transition">{{ __('landing.nav_about') }}</a>
                        <a href="#services" class="px-3 py-2 text-sm text-gray-600 hover:text-[#dd208e] hover:bg-pink-50 rounded-lg transition">{{ __('landing.nav_services') }}</a>
                        <a href="#features" class="px-3 py-2 text-sm text-gray-600 hover:text-[#dd208e] hover:bg-pink-50 rounded-lg transition">{{ __('landing.nav_features') }}</a>
                        <a href="#pricing" class="px-3 py-2 text-sm text-gray-600 hover:text-[#dd208e] hover:bg-pink-50 rounded-lg transition">{{ __('landing.nav_pricing') }}</a>
                        <a href="{{ route('blogs.public.index') }}" class="px-3 py-2 text-sm text-gray-600 hover:text-[#dd208e] hover:bg-pink-50 rounded-lg transition">{{ __('landing.nav_blog') }}</a>
                        <a href="#contact" class="px-3 py-2 text-sm text-gray-600 hover:text-[#dd208e] hover:bg-pink-50 rounded-lg transition">{{ __('landing.nav_contact') }}</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero-gradient pt-28 sm:pt-36 pb-16 sm:pb-24 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
            <!-- Decorative elements -->
            <div class="absolute top-20 {{ app()->getLocale() === 'ar' ? 'left-10' : 'right-10' }} w-72 h-72 bg-pink-300/20 rounded-full blur-3xl float-1"></div>
            <div class="absolute bottom-10 {{ app()->getLocale() === 'ar' ? 'right-10' : 'left-10' }} w-96 h-96 bg-purple-200/20 rounded-full blur-3xl float-2"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-pink-100/30 rounded-full blur-3xl"></div>

            <div class="max-w-6xl mx-auto relative z-10">
                <div class="text-center mb-12">
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/80 backdrop-blur rounded-full shadow-sm border border-pink-100 mb-6 pulse-badge">
                        <i class="fas fa-sparkles text-[#dd208e] text-xs"></i>
                        <span class="text-xs font-semibold text-gray-700">{{ __('landing.pricing_badge') }}</span>
                    </div>

                    <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-black mb-6 leading-tight">
                        <span class="gradient-text">{{ __('landing.hero_title') }}</span>
                    </h1>
                    <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-2xl mx-auto mb-8 leading-relaxed">
                        {{ __('landing.hero_subtitle') }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        @auth
                            <a href="{{ route('admin.dashboard') }}" class="btn-glow px-8 py-3.5 bg-gradient-to-r from-[#dd208e] to-[#b01670] text-white rounded-xl font-bold text-sm hover:shadow-2xl hover:scale-105 transition-all transform inline-flex items-center justify-center gap-2">
                                <i class="fas fa-tachometer-alt"></i> {{ __('landing.go_to_dashboard') }}
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-glow px-8 py-3.5 bg-gradient-to-r from-[#dd208e] to-[#b01670] text-white rounded-xl font-bold text-sm hover:shadow-2xl hover:scale-105 transition-all transform inline-flex items-center justify-center gap-2">
                                <i class="fas fa-rocket"></i> {{ __('landing.start_free_trial') }}
                            </a>
                        @endauth
                        <a href="#about" class="px-8 py-3.5 bg-white/80 backdrop-blur border-2 border-[#dd208e] text-[#dd208e] rounded-xl font-bold text-sm hover:bg-white transition-all inline-flex items-center justify-center gap-2">
                            <i class="fas fa-play-circle"></i> {{ __('landing.learn_more') }}
                        </a>
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-12">
                    <div class="bg-white/80 backdrop-blur rounded-2xl p-6 shadow-lg border border-white/50 text-center card-hover">
                        <div class="text-3xl sm:text-4xl font-black gradient-text mb-1">{{ __('landing.stat_salons_count') }}</div>
                        <p class="text-sm text-gray-600 font-medium">{{ __('landing.stat_salons_label') }}</p>
                    </div>
                    <div class="bg-white/80 backdrop-blur rounded-2xl p-6 shadow-lg border border-white/50 text-center card-hover">
                        <div class="text-3xl sm:text-4xl font-black gradient-text mb-1">{{ __('landing.stat_bookings_count') }}</div>
                        <p class="text-sm text-gray-600 font-medium">{{ __('landing.stat_bookings_label') }}</p>
                    </div>
                    <div class="bg-white/80 backdrop-blur rounded-2xl p-6 shadow-lg border border-white/50 text-center card-hover">
                        <div class="text-3xl sm:text-4xl font-black gradient-text mb-1">{{ __('landing.stat_rating_count') }}</div>
                        <p class="text-sm text-gray-600 font-medium">{{ __('landing.stat_rating_label') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-16 sm:py-24 px-4 sm:px-6 lg:px-8 bg-white">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16 reveal">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-pink-50 text-[#dd208e] rounded-full text-xs font-bold mb-4">
                        <i class="fas fa-info-circle"></i> {{ __('landing.nav_about') }}
                    </span>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4">
                        <span class="gradient-text">{{ __('landing.about_title') }}</span>
                    </h2>
                    <p class="text-base sm:text-lg text-gray-600 max-w-3xl mx-auto">{{ __('landing.about_subtitle') }}</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-16 reveal">
                    <div>
                        <div class="relative">
                            <div class="absolute -inset-4 bg-gradient-to-r from-[#dd208e] to-[#b01670] rounded-3xl blur-2xl opacity-15"></div>
                            <div class="relative bg-white rounded-2xl p-8 sm:p-12 shadow-2xl border border-gray-100">
                                <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6">{{ __('landing.vision_title') }}</h3>
                                <p class="text-gray-700 leading-relaxed mb-4">{{ __('landing.vision_p1') }}</p>
                                <p class="text-gray-700 leading-relaxed">{{ __('landing.vision_p2') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div class="card-hover bg-white rounded-xl p-6 shadow-lg border border-gray-100 hover:border-[#dd208e]">
                            <div class="flex items-start gap-4">
                                <div class="icon-box bg-gradient-to-br from-pink-50 to-pink-100 text-[#dd208e]">
                                    <i class="fas fa-bullseye"></i>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900 mb-1">{{ __('landing.goal_title') }}</h4>
                                    <p class="text-sm text-gray-600">{{ __('landing.goal_desc') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="card-hover bg-white rounded-xl p-6 shadow-lg border border-gray-100 hover:border-[#dd208e]">
                            <div class="flex items-start gap-4">
                                <div class="icon-box bg-gradient-to-br from-purple-50 to-purple-100 text-purple-600">
                                    <i class="fas fa-lightbulb"></i>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900 mb-1">{{ __('landing.innovation_title') }}</h4>
                                    <p class="text-sm text-gray-600">{{ __('landing.innovation_desc') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="card-hover bg-white rounded-xl p-6 shadow-lg border border-gray-100 hover:border-[#dd208e]">
                            <div class="flex items-start gap-4">
                                <div class="icon-box bg-gradient-to-br from-blue-50 to-blue-100 text-blue-600">
                                    <i class="fas fa-handshake"></i>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900 mb-1">{{ __('landing.partnership_title') }}</h4>
                                    <p class="text-sm text-gray-600">{{ __('landing.partnership_desc') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Banner -->
                <div class="bg-gradient-to-r from-[#dd208e] to-[#b01670] rounded-3xl p-8 sm:p-12 text-white reveal">
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="text-center">
                            <div class="text-3xl sm:text-5xl font-black mb-1">{{ __('landing.about_stat_salons') }}</div>
                            <p class="text-sm text-pink-100">{{ __('landing.about_stat_salons_label') }}</p>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl sm:text-5xl font-black mb-1">{{ __('landing.about_stat_bookings') }}</div>
                            <p class="text-sm text-pink-100">{{ __('landing.about_stat_bookings_label') }}</p>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl sm:text-5xl font-black mb-1">{{ __('landing.about_stat_rating') }}</div>
                            <p class="text-sm text-pink-100">{{ __('landing.about_stat_rating_label') }}</p>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl sm:text-5xl font-black mb-1">{{ __('landing.about_stat_support') }}</div>
                            <p class="text-sm text-pink-100">{{ __('landing.about_stat_support_label') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Video Section -->
        <section class="py-16 sm:py-24 px-4 sm:px-6 lg:px-8 bg-gray-50">
            <div class="max-w-5xl mx-auto reveal">
                <div class="text-center mb-12">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-pink-50 text-[#dd208e] rounded-full text-xs font-bold mb-4">
                        <i class="fas fa-video"></i> {{ app()->getLocale() === 'ar' ? 'شاهد الفيديو' : 'Watch Video' }}
                    </span>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4">
                        <span class="gradient-text">{{ __('landing.video_title') }}</span>
                    </h2>
                    <p class="text-base sm:text-lg text-gray-600 max-w-3xl mx-auto">{{ __('landing.video_subtitle') }}</p>
                </div>
                <div class="relative rounded-2xl overflow-hidden shadow-2xl border-4 border-white">
                    <video controls class="w-full" poster="">
                        <source src="{{ asset('videos/example2.mp4') }}" type="video/mp4">
                        {{ __('landing.video_not_supported') }}
                    </video>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="py-16 sm:py-24 px-4 sm:px-6 lg:px-8 bg-white">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16 reveal">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-pink-50 text-[#dd208e] rounded-full text-xs font-bold mb-4">
                        <i class="fas fa-concierge-bell"></i> {{ __('landing.nav_services') }}
                    </span>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4">{{ __('landing.services_title') }}</h2>
                    <p class="text-base sm:text-lg text-gray-600">{{ __('landing.services_subtitle') }}</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 reveal">
                    @php
                        $services = [
                            ['icon' => 'fa-calendar-check', 'color' => 'from-pink-500 to-rose-500', 'bg' => 'from-pink-50 to-rose-50', 'title' => 'service_appointments_title', 'desc' => 'service_appointments_desc'],
                            ['icon' => 'fa-users', 'color' => 'from-purple-500 to-indigo-500', 'bg' => 'from-purple-50 to-indigo-50', 'title' => 'service_clients_title', 'desc' => 'service_clients_desc'],
                            ['icon' => 'fa-user-tie', 'color' => 'from-blue-500 to-cyan-500', 'bg' => 'from-blue-50 to-cyan-50', 'title' => 'service_staff_title', 'desc' => 'service_staff_desc'],
                            ['icon' => 'fa-coins', 'color' => 'from-amber-500 to-orange-500', 'bg' => 'from-amber-50 to-orange-50', 'title' => 'service_payments_title', 'desc' => 'service_payments_desc'],
                            ['icon' => 'fa-chart-line', 'color' => 'from-emerald-500 to-teal-500', 'bg' => 'from-emerald-50 to-teal-50', 'title' => 'service_reports_title', 'desc' => 'service_reports_desc'],
                            ['icon' => 'fa-mobile-screen', 'color' => 'from-[#dd208e] to-[#b01670]', 'bg' => 'from-pink-50 to-fuchsia-50', 'title' => 'service_mobile_title', 'desc' => 'service_mobile_desc'],
                        ];
                    @endphp

                    @foreach($services as $service)
                    <div class="card-hover bg-white rounded-2xl p-7 border border-gray-100 shadow-md">
                        <div class="icon-box bg-gradient-to-br {{ $service['bg'] }} mb-5">
                            <i class="fas {{ $service['icon'] }} text-transparent bg-gradient-to-br {{ $service['color'] }} bg-clip-text"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __('landing.' . $service['title']) }}</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ __('landing.' . $service['desc']) }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-16 sm:py-24 px-4 sm:px-6 lg:px-8 bg-gray-50">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16 reveal">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-pink-50 text-[#dd208e] rounded-full text-xs font-bold mb-4">
                        <i class="fas fa-star"></i> {{ __('landing.nav_features') }}
                    </span>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4">{{ __('landing.features_title') }}</h2>
                    <p class="text-base sm:text-lg text-gray-600">{{ __('landing.features_subtitle') }}</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 reveal">
                    @php
                        $features = [
                            ['icon' => 'fa-bolt', 'title' => 'feature_instant_booking_title', 'desc' => 'feature_instant_booking_desc'],
                            ['icon' => 'fa-box-open', 'title' => 'feature_products_title', 'desc' => 'feature_products_desc'],
                            ['icon' => 'fa-sliders', 'title' => 'feature_service_mgmt_title', 'desc' => 'feature_service_mgmt_desc'],
                            ['icon' => 'fa-chart-bar', 'title' => 'feature_staff_perf_title', 'desc' => 'feature_staff_perf_desc'],
                            ['icon' => 'fa-address-book', 'title' => 'feature_client_mgmt_title', 'desc' => 'feature_client_mgmt_desc'],
                            ['icon' => 'fa-headset', 'title' => 'feature_support_title', 'desc' => 'feature_support_desc'],
                        ];
                    @endphp

                    @foreach($features as $feature)
                    <div class="flex gap-4 bg-white rounded-xl p-6 shadow-sm border border-gray-100 card-hover">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#dd208e] to-[#b01670] flex items-center justify-center flex-shrink-0">
                            <i class="fas {{ $feature['icon'] }} text-white text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">{{ __('landing.' . $feature['title']) }}</h3>
                            <p class="text-sm text-gray-600">{{ __('landing.' . $feature['desc']) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section id="pricing" class="py-16 sm:py-24 px-4 sm:px-6 lg:px-8 bg-white relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-[#dd208e] to-[#b01670]"></div>
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-16 reveal">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-gradient-to-r from-[#dd208e] to-[#b01670] text-white rounded-full text-xs font-bold mb-4">
                        <i class="fas fa-tag"></i> {{ __('landing.pricing_badge') }}
                    </span>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4">
                        <span class="gradient-text">{{ __('landing.pricing_title') }}</span>
                    </h2>
                    <p class="text-base sm:text-lg text-gray-600 max-w-3xl mx-auto">{{ __('landing.pricing_subtitle') }}</p>
                </div>

                <!-- Main Pricing Card -->
                <div class="relative reveal">
                    <div class="absolute -inset-2 bg-gradient-to-r from-[#dd208e] to-[#b01670] rounded-3xl blur-2xl opacity-20"></div>
                    <div class="relative bg-white rounded-3xl p-8 sm:p-12 shadow-2xl border-2 border-[#dd208e]">
                        <!-- Badge -->
                        <div class="absolute -top-5 {{ app()->getLocale() === 'ar' ? 'right-6' : 'left-6' }}">
                            <div class="bg-gradient-to-r from-[#dd208e] to-[#b01670] text-white px-5 py-2 rounded-full font-bold text-sm shadow-lg inline-flex items-center gap-2">
                                <i class="fas fa-crown"></i> {{ __('landing.pricing_best_badge') }}
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-4">
                            <div class="flex flex-col justify-between">
                                <div>
                                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-3">{{ __('landing.pricing_plans') }}</h3>
                                    <p class="text-gray-600 mb-4">{{ __('landing.pricing_complete_solution') }}</p>
                                    <p class="text-sm text-gray-500">{{ __('landing.pricing_suitable_for') }}</p>
                                </div>
                            </div>

                            <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div class="bg-gradient-to-br from-pink-50 to-white rounded-2xl p-6 border-2 border-transparent hover:border-[#dd208e] transition-all card-hover">
                                    <div class="flex items-center gap-2 mb-3">
                                        <i class="fas fa-calendar-day text-[#dd208e]"></i>
                                        <p class="text-gray-600 text-xs font-bold uppercase tracking-wider">{{ __('landing.pricing_monthly_label') }}</p>
                                    </div>
                                    <div class="mb-2">
                                        <span class="text-4xl font-black gradient-text">{{ __('landing.pricing_monthly_price') }}</span>
                                    </div>
                                    <p class="text-gray-500 text-sm mb-2">{{ __('landing.pricing_monthly_period') }}</p>
                                    <p class="text-xs text-gray-400">{{ __('landing.pricing_monthly_yearly') }}</p>
                                </div>

                                <div class="bg-gradient-to-br from-[#fde4f1] to-white rounded-2xl p-6 border-2 border-[#dd208e] relative">
                                    <div class="absolute -top-3 {{ app()->getLocale() === 'ar' ? 'left-3' : 'right-3' }}">
                                        <span class="bg-[#dd208e] text-white px-3 py-1 rounded-full text-xs font-bold">{{ __('landing.pricing_yearly_save') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 mb-3">
                                        <i class="fas fa-calendar text-[#dd208e]"></i>
                                        <p class="text-gray-600 text-xs font-bold uppercase tracking-wider">{{ __('landing.pricing_yearly_label') }}</p>
                                    </div>
                                    <div class="mb-2">
                                        <span class="text-4xl font-black gradient-text">{{ __('landing.pricing_yearly_price') }}</span>
                                    </div>
                                    <p class="text-gray-500 text-sm">{{ __('landing.pricing_yearly_period') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Features -->
                        <div class="mt-10 pt-10 border-t-2 border-gray-100">
                            <h4 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                                <i class="fas fa-check-double text-[#dd208e]"></i>
                                {{ __('landing.pricing_includes') }}
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @php
                                    $pricingFeatures = [
                                        ['title' => 'pricing_feat_appointments', 'desc' => 'pricing_feat_appointments_desc'],
                                        ['title' => 'pricing_feat_clients', 'desc' => 'pricing_feat_clients_desc'],
                                        ['title' => 'pricing_feat_payments', 'desc' => 'pricing_feat_payments_desc'],
                                        ['title' => 'pricing_feat_reports', 'desc' => 'pricing_feat_reports_desc'],
                                        ['title' => 'pricing_feat_responsive', 'desc' => 'pricing_feat_responsive_desc'],
                                        ['title' => 'pricing_feat_staff_perf', 'desc' => 'pricing_feat_staff_perf_desc'],
                                        ['title' => 'pricing_feat_products', 'desc' => 'pricing_feat_products_desc'],
                                        ['title' => 'pricing_feat_support', 'desc' => 'pricing_feat_support_desc'],
                                    ];
                                @endphp
                                @foreach($pricingFeatures as $feature)
                                <div class="flex items-start gap-3">
                                    <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#dd208e] to-[#b01670] flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <i class="fas fa-check text-white text-xs"></i>
                                    </div>
                                    <div>
                                        <h5 class="text-sm font-bold text-gray-900">{{ __('landing.' . $feature['title']) }}</h5>
                                        <p class="text-xs text-gray-600">{{ __('landing.' . $feature['desc']) }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- CTA -->
                        <div class="mt-10 flex flex-col sm:flex-row gap-4">
                            @auth
                                <button class="flex-1 btn-glow px-8 py-4 bg-gradient-to-r from-[#dd208e] to-[#b01670] text-white font-bold rounded-xl hover:shadow-2xl transition-all inline-flex items-center justify-center gap-2">
                                    <i class="fas fa-check-circle"></i> {{ __('landing.pricing_choose_plan') }}
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="flex-1 btn-glow px-8 py-4 bg-gradient-to-r from-[#dd208e] to-[#b01670] text-white font-bold rounded-xl hover:shadow-2xl transition-all text-center inline-flex items-center justify-center gap-2">
                                    <i class="fas fa-rocket"></i> {{ __('landing.pricing_start_trial') }}
                                </a>
                            @endauth
                            <a href="tel:+249110920958" class="flex-1 px-8 py-4 border-2 border-[#dd208e] text-[#dd208e] font-bold rounded-xl hover:bg-pink-50 transition-all flex items-center justify-center gap-2">
                                <i class="fas fa-phone"></i> {{ __('landing.pricing_call_us') }}
                            </a>
                        </div>

                        <div class="mt-6 text-center space-y-1">
                            <p class="text-gray-600 font-medium text-sm">{{ __('landing.pricing_no_hidden') }}</p>
                            <p class="text-gray-400 text-xs">{{ __('landing.pricing_trial_info') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Why Us -->
                <div class="mt-16 reveal">
                    <h3 class="text-2xl font-bold text-gray-900 text-center mb-8">{{ __('landing.pricing_why_us') }}</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100 text-center card-hover">
                            <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-yellow-50 to-orange-50 flex items-center justify-center">
                                <i class="fas fa-bolt text-amber-500 text-xl"></i>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2">{{ __('landing.pricing_fast_title') }}</h4>
                            <p class="text-sm text-gray-600">{{ __('landing.pricing_fast_desc') }}</p>
                        </div>
                        <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100 text-center card-hover">
                            <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 flex items-center justify-center">
                                <i class="fas fa-shield-halved text-blue-500 text-xl"></i>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2">{{ __('landing.pricing_secure_title') }}</h4>
                            <p class="text-sm text-gray-600">{{ __('landing.pricing_secure_desc') }}</p>
                        </div>
                        <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100 text-center card-hover">
                            <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-green-50 to-emerald-50 flex items-center justify-center">
                                <i class="fas fa-chart-line text-emerald-500 text-xl"></i>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2">{{ __('landing.pricing_growth_title') }}</h4>
                            <p class="text-sm text-gray-600">{{ __('landing.pricing_growth_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-16 sm:py-24 px-4 sm:px-6 lg:px-8 bg-gray-50">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16 reveal">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-pink-50 text-[#dd208e] rounded-full text-xs font-bold mb-4">
                        <i class="fas fa-envelope"></i> {{ __('landing.nav_contact') }}
                    </span>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4">{{ __('landing.contact_title') }}</h2>
                    <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto">{{ __('landing.contact_subtitle') }}</p>
                </div>

                <!-- Contact Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-16 reveal">
                    <div class="card-hover bg-white rounded-2xl p-7 shadow-lg border border-gray-100">
                        <div class="icon-box bg-gradient-to-br from-[#dd208e] to-[#b01670] text-white mb-5">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __('landing.contact_email_title') }}</h3>
                        <p class="text-sm text-gray-500 mb-4">{{ __('landing.contact_email_desc') }}</p>
                        <a href="mailto:info@northline-dev.com" class="inline-flex items-center gap-2 text-[#dd208e] font-semibold text-sm hover:underline">
                            info@northline-dev.com <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }} text-xs"></i>
                        </a>
                    </div>

                    <div class="card-hover bg-white rounded-2xl p-7 shadow-lg border border-gray-100">
                        <div class="icon-box bg-gradient-to-br from-green-500 to-emerald-600 text-white mb-5">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __('landing.contact_whatsapp_title') }}</h3>
                        <p class="text-sm text-gray-500 mb-4">{{ __('landing.contact_whatsapp_desc') }}</p>
                        <a href="https://wa.me/96898084952" target="_blank" class="inline-flex items-center gap-2 text-green-600 font-semibold text-sm hover:underline">
                            0096898084952 <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }} text-xs"></i>
                        </a>
                    </div>

                    <div class="card-hover bg-white rounded-2xl p-7 shadow-lg border border-gray-100">
                        <div class="icon-box bg-gradient-to-br from-blue-500 to-indigo-600 text-white mb-5">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __('landing.contact_address_title') }}</h3>
                        <p class="text-sm text-gray-500 mb-4">{{ __('landing.contact_address_desc') }}</p>
                        <span class="text-sm text-blue-600 font-semibold">{{ __('landing.contact_address_value') }}</span>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden reveal">
                    <div class="grid grid-cols-1 lg:grid-cols-2">
                        <div class="p-8 sm:p-12">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ __('landing.contact_form_title') }}</h3>
                            <p class="text-sm text-gray-500 mb-8">{{ __('landing.contact_form_subtitle') }}</p>

                            @if(session('success'))
                                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
                                    <i class="fas fa-check-circle text-green-500"></i>
                                    <p class="text-green-700 font-semibold text-sm">{{ session('success') }}</p>
                                </div>
                            @endif

                            <form class="space-y-5" action="{{ route('contact.store') }}" method="POST">
                                @csrf
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('landing.contact_name') }}</label>
                                    <input value="{{ old('name') }}" required type="text" name="name" placeholder="{{ __('landing.contact_name_placeholder') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#dd208e] focus:outline-none transition text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('landing.contact_email') }}</label>
                                    <input value="{{ old('email') }}" required type="email" name="email" placeholder="{{ __('landing.contact_email_placeholder') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#dd208e] focus:outline-none transition text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('landing.contact_phone') }}</label>
                                    <input value="{{ old('phone') }}" required type="tel" name="phone" placeholder="{{ __('landing.contact_phone_placeholder') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#dd208e] focus:outline-none transition text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('landing.contact_subject') }}</label>
                                    <input value="{{ old('title') }}" required type="text" name="title" placeholder="{{ __('landing.contact_subject_placeholder') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#dd208e] focus:outline-none transition text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('landing.contact_message') }}</label>
                                    <textarea required name="message" placeholder="{{ __('landing.contact_message_placeholder') }}" rows="4" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#dd208e] focus:outline-none transition resize-none text-sm">{{ old('message') }}</textarea>
                                </div>
                                <button type="submit" class="btn-glow w-full px-6 py-3.5 bg-gradient-to-r from-[#dd208e] to-[#b01670] text-white font-bold rounded-xl hover:shadow-xl transition-all flex items-center justify-center gap-2">
                                    <i class="fas fa-paper-plane"></i> {{ __('landing.contact_send') }}
                                </button>
                            </form>
                        </div>

                        <!-- Info Side -->
                        <div class="bg-gradient-to-br from-[#dd208e] to-[#1e1b2e] p-8 sm:p-12 text-white flex flex-col justify-center">
                            <h3 class="text-2xl font-bold mb-8">{{ __('landing.contact_info_title') }}</h3>
                            <div class="space-y-8">
                                <div class="flex gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-clock text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold mb-1">{{ __('landing.contact_hours_title') }}</h4>
                                        <p class="text-pink-100 text-sm">{{ __('landing.contact_hours_weekdays') }}</p>
                                        <p class="text-pink-100 text-sm">{{ __('landing.contact_hours_friday') }}</p>
                                        <p class="text-pink-100 text-sm">{{ __('landing.contact_hours_support') }}</p>
                                    </div>
                                </div>

                                <div class="flex gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-share-nodes text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold mb-2">{{ __('landing.contact_follow_title') }}</h4>
                                        <div class="flex gap-3">
                                            <a href="https://www.instagram.com/north_line_development/" class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-phone text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold mb-1">{{ __('landing.contact_phone_title') }}</h4>
                                        <p class="text-pink-100 text-sm">00968-9808-4952/p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-16 sm:py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-[#dd208e] via-[#b01670] to-[#1e1b2e] relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-10 left-10 w-60 h-60 bg-white rounded-full blur-3xl"></div>
                <div class="absolute bottom-10 right-10 w-80 h-80 bg-pink-300 rounded-full blur-3xl"></div>
            </div>
            <div class="max-w-4xl mx-auto text-center relative z-10">
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-white mb-4">{{ __('landing.cta_title') }}</h2>
                <p class="text-base sm:text-lg text-pink-100 mb-8">{{ __('landing.cta_subtitle') }}</p>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-[#dd208e] font-bold rounded-xl hover:shadow-2xl hover:scale-105 transition-all transform">
                        <i class="fas fa-tachometer-alt"></i> {{ __('landing.go_to_dashboard') }}
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-[#dd208e] font-bold rounded-xl hover:shadow-2xl hover:scale-105 transition-all transform">
                        <i class="fas fa-rocket"></i> {{ __('landing.start_free_trial') }}
                    </a>
                @endauth
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-white py-14 px-4 sm:px-6 lg:px-8 border-t border-gray-100">
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 mb-10">
                    <div class="space-y-4">
                        <div class="flex items-center gap-2">

                            <span class="text-lg font-bold gradient-text">{{ __('landing.brand') }}</span>
                        </div>
                        <p class="text-sm text-gray-500">{{ __('landing.footer_desc') }}</p>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-4">{{ __('landing.footer_product') }}</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#features" class="text-gray-500 hover:text-[#dd208e] transition">{{ __('landing.nav_features') }}</a></li>
                            <li><a href="#pricing" class="text-gray-500 hover:text-[#dd208e] transition">{{ __('landing.nav_pricing') }}</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-4">{{ __('landing.footer_company') }}</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#about" class="text-gray-500 hover:text-[#dd208e] transition">{{ __('landing.nav_about') }}</a></li>
                            <li><a href="{{ route('blogs.public.index') }}" class="text-gray-500 hover:text-[#dd208e] transition">{{ __('landing.nav_blog') }}</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-4">{{ __('landing.footer_legal') }}</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ route('policy') }}" class="text-gray-500 hover:text-[#dd208e] transition">{{ __('landing.footer_terms') }}</a></li>
                            <li><a href="#contact" class="text-gray-500 hover:text-[#dd208e] transition">{{ __('landing.nav_contact') }}</a></li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-xs text-gray-400">{{ __('landing.footer_copyright') }}</p>
                    <a href="https://www.instagram.com/mohamed_izeldeen/" target="_blank" class="inline-flex items-center gap-2 text-[#dd208e] hover:text-[#b01670] text-sm font-medium">
                        <i class="fab fa-instagram"></i>
                        {{ __('landing.footer_developed_by') }}
                    </a>
                </div>
            </div>
        </footer>

        <script>
            // Navbar scroll effect
            window.addEventListener('scroll', () => {
                document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 20);
            });

            // Mobile menu
            document.getElementById('mobile-toggle').addEventListener('click', () => {
                const menu = document.getElementById('mobile-menu');
                menu.classList.toggle('hidden');
                const icon = document.querySelector('#mobile-toggle i');
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-xmark');
            });

            // Close mobile menu on link click
            document.querySelectorAll('#mobile-menu a').forEach(link => {
                link.addEventListener('click', () => {
                    document.getElementById('mobile-menu').classList.add('hidden');
                    const icon = document.querySelector('#mobile-toggle i');
                    icon.classList.add('fa-bars');
                    icon.classList.remove('fa-xmark');
                });
            });

            // Smooth scroll
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });

            // Reveal on scroll
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));
        </script>
    </body>
</html>
