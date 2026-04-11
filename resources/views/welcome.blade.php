<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-PBXGMHCC');</script>
    <!-- End Google Tag Manager -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ __('landing.hero_subtitle') }}">
    <title>{{ __('landing.brand') }} | {{ __('landing.hero_title') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: #dd208e;
            --primary-dark: #b01670;
            --primary-light: #ff4db8;
            --gradient-1: linear-gradient(135deg, #dd208e 0%, #b01670 100%);
            --gradient-2: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-3: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { 
            font-family: {{ app()->getLocale() === 'ar' ? "'Cairo'" : "'Inter'" }}, sans-serif; 
            overflow-x: hidden;
            background: #0a0a0f;
        }

        /* ===== ADVANCED ANIMATIONS ===== */
        @keyframes float { 
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
        }
        @keyframes float-reverse { 
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(20px) rotate(-2deg); }
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(221,32,142,0.3); }
            50% { box-shadow: 0 0 40px rgba(221,32,142,0.6), 0 0 60px rgba(221,32,142,0.3); }
        }
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        @keyframes morph {
            0%, 100% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
            50% { border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%; }
        }
        @keyframes rotate-slow { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        @keyframes typing {
            from { width: 0; }
            to { width: 100%; }
        }
        @keyframes blink { 50% { border-color: transparent; } }
        @keyframes particle-float {
            0%, 100% { transform: translateY(0) translateX(0) scale(1); opacity: 0.6; }
            25% { transform: translateY(-30px) translateX(10px) scale(1.1); opacity: 0.8; }
            50% { transform: translateY(-10px) translateX(-10px) scale(0.9); opacity: 0.5; }
            75% { transform: translateY(-40px) translateX(5px) scale(1.05); opacity: 0.7; }
        }
        @keyframes slide-up {
            from { opacity: 0; transform: translateY(60px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slide-in-left {
            from { opacity: 0; transform: translateX(-80px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes slide-in-right {
            from { opacity: 0; transform: translateX(80px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes scale-in {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes rotate-in {
            from { opacity: 0; transform: rotateY(90deg); }
            to { opacity: 1; transform: rotateY(0); }
        }

        /* ===== REVEAL ON SCROLL ===== */
        .reveal {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-left {
            opacity: 0;
            transform: translateX(-80px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .reveal-left.active {
            opacity: 1;
            transform: translateX(0);
        }
        .reveal-right {
            opacity: 0;
            transform: translateX(80px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .reveal-right.active {
            opacity: 1;
            transform: translateX(0);
        }
        .reveal-scale {
            opacity: 0;
            transform: scale(0.7);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .reveal-scale.active {
            opacity: 1;
            transform: scale(1);
        }
        .stagger-1 { transition-delay: 0.1s; }
        .stagger-2 { transition-delay: 0.2s; }
        .stagger-3 { transition-delay: 0.3s; }
        .stagger-4 { transition-delay: 0.4s; }
        .stagger-5 { transition-delay: 0.5s; }
        .stagger-6 { transition-delay: 0.6s; }

        /* ===== 3D PERSPECTIVE ===== */
        .perspective-container {
            perspective: 1000px;
            transform-style: preserve-3d;
        }
        .tilt-card {
            transform-style: preserve-3d;
            transition: transform 0.6s cubic-bezier(0.23, 1, 0.32, 1);
        }
        .tilt-card:hover {
            transform: rotateX(5deg) rotateY(-5deg) scale(1.02);
        }
        [dir="rtl"] .tilt-card:hover {
            transform: rotateX(5deg) rotateY(5deg) scale(1.02);
        }

        /* ===== GLASSMORPHISM ===== */
        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .glass-dark {
            background: rgba(10, 10, 15, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* ===== FLOATING PARTICLES ===== */
        .particles {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
        }
        .particle {
            position: absolute;
            width: 6px;
            height: 6px;
            background: var(--primary);
            border-radius: 50%;
            animation: particle-float 8s infinite ease-in-out;
        }

        /* ===== MORPHING BLOB ===== */
        .blob {
            position: absolute;
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, rgba(221,32,142,0.3), rgba(102,126,234,0.3));
            filter: blur(80px);
            animation: morph 15s infinite ease-in-out, float 10s infinite ease-in-out;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 1rem 2rem;
            transition: all 0.4s ease;
        }
        .navbar.scrolled {
            background: rgba(10, 10, 15, 0.95);
            backdrop-filter: blur(20px);
            padding: 0.75rem 2rem;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
        }
        .nav-link {
            color: rgba(255,255,255,0.7);
            font-weight: 500;
            transition: all 0.3s;
            position: relative;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s;
        }
        .nav-link:hover { color: #fff; }
        .nav-link:hover::after { width: 100%; }

        /* ===== HERO SECTION ===== */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #0a0a0f 0%, #1a1a2e 50%, #0a0a0f 100%);
        }
        .hero-grid {
            position: absolute;
            inset: 0;
            background-image: 
                linear-gradient(rgba(221,32,142,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(221,32,142,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            animation: gradient-shift 20s ease infinite;
        }
        .hero-title {
            font-size: clamp(2.5rem, 6vw, 4.5rem);
            font-weight: 900;
            line-height: 1.1;
            background: linear-gradient(135deg, #fff 0%, #dd208e 50%, #667eea 100%);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient-shift 5s ease infinite;
        }
        .typing-text {
            display: inline-block;
            overflow: hidden;
            white-space: nowrap;
            border-right: 3px solid var(--primary);
            animation: typing 3s steps(40) 1s forwards, blink 0.7s infinite step-end;
        }

        /* ===== 3D MOCKUP CARDS ===== */
        .mockup-3d {
            position: relative;
            transform-style: preserve-3d;
            transform: perspective(1000px) rotateX(5deg) rotateY(-10deg);
            transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
        }
        [dir="rtl"] .mockup-3d {
            transform: perspective(1000px) rotateX(5deg) rotateY(10deg);
        }
        .mockup-3d:hover {
            transform: perspective(1000px) rotateX(0deg) rotateY(0deg) scale(1.05);
        }
        .mockup-shadow {
            position: absolute;
            bottom: -20px;
            left: 10%;
            right: 10%;
            height: 40px;
            background: radial-gradient(ellipse, rgba(221,32,142,0.4) 0%, transparent 70%);
            filter: blur(20px);
            transform: translateZ(-50px);
        }
        .mockup-card {
            background: linear-gradient(145deg, #1e1e2e, #2a2a3e);
            border-radius: 1.5rem;
            padding: 1.5rem;
            box-shadow: 
                0 25px 50px rgba(0,0,0,0.5),
                0 0 0 1px rgba(255,255,255,0.1),
                inset 0 1px 0 rgba(255,255,255,0.1);
            overflow: hidden;
        }
        .mockup-header {
            display: flex;
            gap: 6px;
            margin-bottom: 1rem;
        }
        .mockup-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        /* ===== APP COMPONENT STYLES ===== */
        .app-calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
        }
        .app-calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            border-radius: 6px;
            background: rgba(255,255,255,0.05);
            color: rgba(255,255,255,0.6);
            transition: all 0.3s;
        }
        .app-calendar-day.booked {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            font-weight: 600;
        }
        .app-calendar-day.today {
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .app-invoice {
            background: rgba(255,255,255,0.03);
            border-radius: 12px;
            padding: 1rem;
        }
        .app-invoice-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            font-size: 0.75rem;
            color: rgba(255,255,255,0.7);
        }
        .app-invoice-total {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            font-size: 0.9rem;
            font-weight: 700;
            color: #fff;
        }

        .app-chart {
            height: 120px;
            display: flex;
            align-items: flex-end;
            justify-content: space-around;
            gap: 8px;
            padding: 1rem 0;
        }
        .app-chart-bar {
            flex: 1;
            border-radius: 4px 4px 0 0;
            background: linear-gradient(to top, var(--primary), var(--primary-light));
            transition: height 0.5s ease;
            position: relative;
        }
        .app-chart-bar::after {
            content: attr(data-value);
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 0.6rem;
            color: rgba(255,255,255,0.5);
        }

        .app-salary-row {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem;
            background: rgba(255,255,255,0.03);
            border-radius: 8px;
            margin-bottom: 0.5rem;
        }
        .app-salary-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), #667eea);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.65rem;
            font-weight: 700;
        }

        .app-expense-card {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            background: rgba(255,255,255,0.03);
            border-radius: 10px;
            margin-bottom: 0.5rem;
        }
        .app-expense-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }

        .app-coupon {
            background: linear-gradient(135deg, #1e1e2e 0%, #2a2a3e 100%);
            border: 2px dashed var(--primary);
            border-radius: 12px;
            padding: 1rem;
            position: relative;
            overflow: hidden;
        }
        .app-coupon::before {
            content: '';
            position: absolute;
            top: 50%;
            left: -10px;
            width: 20px;
            height: 20px;
            background: #0a0a0f;
            border-radius: 50%;
            transform: translateY(-50%);
        }
        .app-coupon::after {
            content: '';
            position: absolute;
            top: 50%;
            right: -10px;
            width: 20px;
            height: 20px;
            background: #0a0a0f;
            border-radius: 50%;
            transform: translateY(-50%);
        }

        /* ===== SECTION STYLES ===== */
        .section {
            padding: 6rem 0;
            position: relative;
            overflow: hidden;
        }
        .section-dark { background: #0a0a0f; }
        .section-gradient { 
            background: linear-gradient(180deg, #0a0a0f 0%, #1a1a2e 50%, #0a0a0f 100%);
        }
        .section-title {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800;
            color: #fff;
            margin-bottom: 1rem;
        }
        .section-subtitle {
            font-size: 1.1rem;
            color: rgba(255,255,255,0.6);
            max-width: 600px;
            margin: 0 auto;
        }
        .gradient-text {
            background: linear-gradient(135deg, var(--primary), #667eea);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ===== SERVICE CARDS ===== */
        .service-card {
            background: linear-gradient(145deg, rgba(30,30,46,0.8), rgba(20,20,30,0.8));
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 1.5rem;
            padding: 2rem;
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
            overflow: hidden;
        }
        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .service-card:hover {
            transform: translateY(-10px);
            border-color: rgba(221,32,142,0.3);
            box-shadow: 0 20px 40px rgba(221,32,142,0.15);
        }
        .service-card:hover::before { opacity: 1; }

        /* ===== FEATURE CARDS ===== */
        .feature-card {
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 1.25rem;
            padding: 1.5rem;
            transition: all 0.4s ease;
            position: relative;
        }
        .feature-card:hover {
            background: rgba(221,32,142,0.05);
            border-color: rgba(221,32,142,0.2);
            transform: translateY(-5px);
        }
        .feature-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: #fff;
            margin-bottom: 1rem;
            transition: all 0.4s;
        }
        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(-5deg);
            box-shadow: 0 10px 30px rgba(221,32,142,0.3);
        }

        /* ===== PRICING ===== */
        .pricing-card {
            background: linear-gradient(145deg, #1a1a2e, #0f0f1a);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 2rem;
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
            transition: all 0.5s;
        }
        .pricing-card.featured {
            border-color: var(--primary);
            box-shadow: 0 0 60px rgba(221,32,142,0.2);
        }
        .pricing-card.featured::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), #667eea);
        }
        .pricing-badge {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            background: linear-gradient(135deg, var(--primary), #667eea);
            color: #fff;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.4rem 0.8rem;
            border-radius: 9999px;
        }
        [dir="rtl"] .pricing-badge {
            right: auto;
            left: 1.5rem;
        }
        .pricing-price {
            font-size: 3.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, #fff, rgba(255,255,255,0.7));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ===== CTA ===== */
        .cta-section {
            background: linear-gradient(135deg, #1a1a2e 0%, #0a0a0f 100%);
            position: relative;
            overflow: hidden;
        }
        .cta-glow {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(221,32,142,0.15) 0%, transparent 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /* ===== BUTTONS ===== */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            font-weight: 600;
            border-radius: 9999px;
            text-decoration: none;
            transition: all 0.4s;
            box-shadow: 0 4px 20px rgba(221,32,142,0.3);
            position: relative;
            overflow: hidden;
        }
        .btn-primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            opacity: 0;
            transition: opacity 0.3s;
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 40px rgba(221,32,142,0.4);
        }
        .btn-primary:hover::before { opacity: 1; }
        .btn-primary span { position: relative; z-index: 1; }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            background: transparent;
            color: #fff;
            font-weight: 600;
            border: 2px solid rgba(255,255,255,0.2);
            border-radius: 9999px;
            text-decoration: none;
            transition: all 0.4s;
        }
        .btn-outline:hover {
            border-color: var(--primary);
            background: rgba(221,32,142,0.1);
            transform: translateY(-3px);
        }

        /* ===== FOOTER ===== */
        .footer {
            background: #050508;
            border-top: 1px solid rgba(255,255,255,0.05);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .mockup-3d {
                transform: perspective(1000px) rotateX(3deg) rotateY(-5deg);
            }
        }
        @media (max-width: 768px) {
            .mockup-3d {
                transform: none;
            }
            .hero-title { font-size: 2.5rem; }
            .section { padding: 4rem 0; }
            .navbar { padding: 0.75rem 1rem; }
        }
    </style>
</head>
<body class="antialiased">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PBXGMHCC"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <!-- ===== NAVBAR ===== -->
    <nav class="navbar" id="navbar">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-20 h-10 rounded-xl bg-gradient-to-br from-[#dd208e] to-[#ffffff] flex items-center justify-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-[500px] h-auto">
                </div>
               
            </a>
            
            <div class="hidden md:flex items-center gap-8">
                <a href="#about" class="nav-link text-sm">{{ __('landing.nav_about') }}</a>
                <a href="#services" class="nav-link text-sm">{{ __('landing.nav_services') }}</a>
                <a href="#features" class="nav-link text-sm">{{ __('landing.nav_features') }}</a>
                <a href="#pricing" class="nav-link text-sm">{{ __('landing.nav_pricing') }}</a>
                <a href="#contact" class="nav-link text-sm">{{ __('landing.nav_contact') }}</a>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('language.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}" 
                   class="w-9 h-9 rounded-full glass flex items-center justify-center text-white text-xs font-bold hover:scale-110 transition">
                    {{ app()->getLocale() === 'ar' ? 'EN' : 'ع' }}
                </a>
                @auth
                    <a href="{{ auth()->user()->role === 'super_admin' ? route('superAdmin.dashboard') : (auth()->user()->role === 'sales' ? route('sales.dashboard') : (auth()->user()->role === 'employee' ? route('employee.dashboard') : (auth()->user()->role === 'cashier' ? route('cashier.dashboard') : route('admin.dashboard')))) }}" class="btn-primary !py-2 !px-4 text-sm">
                        <span>{{ __('landing.dashboard') }}</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-outline !py-2 !px-4 text-sm">
                        {{ __('landing.login') }}
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- ===== HERO SECTION ===== -->
    <section class="hero" id="hero">
        <div class="hero-grid"></div>
        
        <!-- Floating Blobs -->
        <div class="blob" style="top: -200px; left: -200px;"></div>
        <div class="blob" style="bottom: -200px; right: -200px; animation-delay: -5s;"></div>
        
        <!-- Particles -->
        <div class="particles">
            @for($i = 0; $i < 20; $i++)
            <div class="particle" style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 50) / 10 }}s; opacity: {{ rand(3, 8) / 10 }};"></div>
            @endfor
        </div>

        <div class="max-w-7xl mx-auto px-6 py-32">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <!-- Left Content -->
                <div class="text-center lg:text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                    <div class="reveal">
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass text-sm text-white/80 mb-6">
                            <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                            {{ __('landing.pricing_trial_info') }}
                        </span>
                    </div>
                    
                    <h1 class="hero-title reveal stagger-1">
                        {{ __('landing.hero_title') }}
                    </h1>
                    
                    <p class="text-lg text-white/60 mt-6 max-w-xl reveal stagger-2">
                        {{ __('landing.hero_subtitle') }}
                    </p>

                    <div class="flex flex-wrap gap-4 mt-10 justify-center lg:justify-{{ app()->getLocale() === 'ar' ? 'end' : 'start' }} reveal stagger-3">
                        @auth
                            <a href="{{ route('admin.dashboard') }}" class="btn-primary">
                                <span>{{ __('landing.go_to_dashboard') }}</span>
                                <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}"></i>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-primary">
                                <span>{{ __('landing.start_free_trial') }}</span>
                                <i class="fas fa-rocket"></i>
                            </a>
                        @endauth
                        <a href="#services" class="btn-outline">
                            <span>{{ __('landing.learn_more') }}</span>
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 mt-14 reveal stagger-4">
                        <div class="text-center">
                            <div class="text-3xl font-black gradient-text">{{ __('landing.stat_salons_count') }}</div>
                            <div class="text-xs text-white/50 mt-1">{{ __('landing.stat_salons_label') }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-black gradient-text">{{ __('landing.stat_bookings_count') }}</div>
                            <div class="text-xs text-white/50 mt-1">{{ __('landing.stat_bookings_label') }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-black gradient-text">{{ __('landing.stat_rating_count') }}</div>
                            <div class="text-xs text-white/50 mt-1">{{ __('landing.stat_rating_label') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Right: 3D Dashboard Mockup -->
                <div class="perspective-container reveal-scale stagger-2">
                    <div class="mockup-3d">
                        <div class="mockup-shadow"></div>
                        <div class="mockup-card" style="animation: float 6s ease-in-out infinite;">
                            <div class="mockup-header">
                                <div class="mockup-dot" style="background: #ff5f57;"></div>
                                <div class="mockup-dot" style="background: #ffbd2e;"></div>
                                <div class="mockup-dot" style="background: #28ca42;"></div>
                            </div>
                            
                            <!-- Dashboard Preview -->
                            <div class="space-y-4">
                                <!-- Stats Row -->
                                <div class="grid grid-cols-3 gap-3">
                                    <div class="bg-gradient-to-br from-pink-500/20 to-pink-600/10 rounded-xl p-3 border border-pink-500/20">
                                        <div class="text-xs text-white/50">{{ app()->getLocale() === 'ar' ? 'الحجوزات' : 'Bookings' }}</div>
                                        <div class="text-xl font-bold text-white">24</div>
                                        <div class="text-xs text-green-400 mt-1"><i class="fas fa-arrow-up"></i> 12%</div>
                                    </div>
                                    <div class="bg-gradient-to-br from-purple-500/20 to-purple-600/10 rounded-xl p-3 border border-purple-500/20">
                                        <div class="text-xs text-white/50">{{ app()->getLocale() === 'ar' ? 'الإيرادات' : 'Revenue' }}</div>
                                        <div class="text-xl font-bold text-white">2.4K</div>
                                        <div class="text-xs text-green-400 mt-1"><i class="fas fa-arrow-up"></i> 8%</div>
                                    </div>
                                    <div class="bg-gradient-to-br from-blue-500/20 to-blue-600/10 rounded-xl p-3 border border-blue-500/20">
                                        <div class="text-xs text-white/50">{{ app()->getLocale() === 'ar' ? 'العملاء' : 'Clients' }}</div>
                                        <div class="text-xl font-bold text-white">156</div>
                                        <div class="text-xs text-green-400 mt-1"><i class="fas fa-arrow-up"></i> 5%</div>
                                    </div>
                                </div>

                                <!-- Chart -->
                                <div class="bg-white/5 rounded-xl p-4">
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="text-xs text-white/70 font-medium">{{ app()->getLocale() === 'ar' ? 'إيرادات الأسبوع' : 'Weekly Revenue' }}</span>
                                        <span class="text-xs text-green-400">+18.5%</span>
                                    </div>
                                    <div class="app-chart">
                                        <div class="app-chart-bar" style="height: 40%;" data-value="Mon"></div>
                                        <div class="app-chart-bar" style="height: 65%;" data-value="Tue"></div>
                                        <div class="app-chart-bar" style="height: 45%;" data-value="Wed"></div>
                                        <div class="app-chart-bar" style="height: 80%;" data-value="Thu"></div>
                                        <div class="app-chart-bar" style="height: 55%;" data-value="Fri"></div>
                                        <div class="app-chart-bar" style="height: 90%;" data-value="Sat"></div>
                                        <div class="app-chart-bar" style="height: 70%;" data-value="Sun"></div>
                                    </div>
                                </div>

                                <!-- Recent Bookings -->
                                <div class="space-y-2">
                                    @foreach(['Fatima', 'Sara', 'Noor'] as $i => $name)
                                    <div class="flex items-center justify-between bg-white/5 rounded-lg p-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-pink-500 to-purple-500 flex items-center justify-center text-white text-xs font-bold">
                                                {{ substr($name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-sm text-white font-medium">{{ $name }}</div>
                                                <div class="text-xs text-white/40">{{ ['Hair Cut', 'Manicure', 'Facial'][$i] }}</div>
                                            </div>
                                        </div>
                                        <span class="text-xs px-2 py-1 rounded-full {{ $i === 0 ? 'bg-green-500/20 text-green-400' : ($i === 1 ? 'bg-yellow-500/20 text-yellow-400' : 'bg-blue-500/20 text-blue-400') }}">
                                            {{ ['Completed', 'In Progress', 'Upcoming'][$i] }}
                                        </span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== ABOUT SECTION ===== -->
    <section class="section section-gradient" id="about">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <!-- Left: 3D App Showcase -->
                <div class="perspective-container reveal-left order-2 lg:order-1">
                    <div class="mockup-3d" style="animation: float-reverse 7s ease-in-out infinite;">
                        <div class="mockup-shadow"></div>
                        <div class="mockup-card">
                            <div class="mockup-header">
                                <div class="mockup-dot" style="background: #ff5f57;"></div>
                                <div class="mockup-dot" style="background: #ffbd2e;"></div>
                                <div class="mockup-dot" style="background: #28ca42;"></div>
                            </div>
                            
                            <!-- Calendar View -->
                            <div class="mb-4">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-sm text-white font-semibold">{{ app()->getLocale() === 'ar' ? 'مارس 2026' : 'March 2026' }}</span>
                                    <div class="flex gap-2">
                                        <button class="w-6 h-6 rounded bg-white/10 text-white/50 text-xs"><i class="fas fa-chevron-left"></i></button>
                                        <button class="w-6 h-6 rounded bg-white/10 text-white/50 text-xs"><i class="fas fa-chevron-right"></i></button>
                                    </div>
                                </div>
                                <div class="app-calendar">
                                    @foreach(['S','M','T','W','T','F','S'] as $d)
                                    <div class="text-center text-xs text-white/40 mb-2">{{ $d }}</div>
                                    @endforeach
                                    @for($i = 1; $i <= 31; $i++)
                                    <div class="app-calendar-day {{ in_array($i, [5,8,12,15,19,22,26]) ? 'booked' : '' }} {{ $i === 12 ? 'today' : '' }}">{{ $i }}</div>
                                    @endfor
                                </div>
                            </div>

                            <!-- Upcoming -->
                            <div class="bg-white/5 rounded-xl p-3 mt-4">
                                <div class="text-xs text-white/50 mb-2">{{ app()->getLocale() === 'ar' ? 'الحجوزات القادمة' : 'Upcoming Bookings' }}</div>
                                <div class="flex items-center gap-3 bg-gradient-to-r from-pink-500/20 to-transparent rounded-lg p-2">
                                    <div class="w-10 h-10 rounded-lg bg-pink-500/30 flex items-center justify-center text-pink-400">
                                        <i class="fas fa-cut"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-sm text-white font-medium">{{ app()->getLocale() === 'ar' ? 'فاطمة المنصور' : 'Fatima Al-Mansour' }}</div>
                                        <div class="text-xs text-white/40">10:30 AM - Hair Styling</div>
                                    </div>
                                    <span class="text-xs text-pink-400 font-bold">50 OMR</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Content -->
                <div class="order-1 lg:order-2">
                    <h2 class="section-title reveal">{{ __('landing.about_title') }}</h2>
                    <p class="text-white/60 mt-4 reveal stagger-1">{{ __('landing.about_subtitle') }}</p>
                    
                    <div class="space-y-6 mt-10">
                        <div class="flex gap-4 reveal stagger-2">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-pink-500/20 to-pink-600/10 border border-pink-500/20 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-eye text-pink-400"></i>
                            </div>
                            <div>
                                <h3 class="text-white font-semibold">{{ __('landing.vision_title') }}</h3>
                                <p class="text-white/50 text-sm mt-1">{{ __('landing.vision_p1') }}</p>
                            </div>
                        </div>
                        
                        <div class="flex gap-4 reveal stagger-3">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500/20 to-purple-600/10 border border-purple-500/20 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-bullseye text-purple-400"></i>
                            </div>
                            <div>
                                <h3 class="text-white font-semibold">{{ __('landing.goal_title') }}</h3>
                                <p class="text-white/50 text-sm mt-1">{{ __('landing.goal_desc') }}</p>
                            </div>
                        </div>
                        
                        <div class="flex gap-4 reveal stagger-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500/20 to-blue-600/10 border border-blue-500/20 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-lightbulb text-blue-400"></i>
                            </div>
                            <div>
                                <h3 class="text-white font-semibold">{{ __('landing.innovation_title') }}</h3>
                                <p class="text-white/50 text-sm mt-1">{{ __('landing.innovation_desc') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== SERVICES SECTION ===== -->
    <section class="section section-dark" id="services">
        <div class="particles">
            @for($i = 0; $i < 15; $i++)
            <div class="particle" style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 80) / 10 }}s;"></div>
            @endfor
        </div>

        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 rounded-full glass text-sm text-pink-400 mb-4 reveal">
                    <i class="fas fa-cubes me-2"></i>{{ __('landing.nav_services') }}
                </span>
                <h2 class="section-title reveal stagger-1">{{ __('landing.services_title') }}</h2>
                <p class="section-subtitle reveal stagger-2">{{ __('landing.services_subtitle') }}</p>
            </div>

            <div class="grid lg:grid-cols-2 gap-8">
                <!-- Service 1: Booking & Calendar -->
                <div class="service-card reveal stagger-1">
                    <div class="flex flex-col lg:flex-row gap-6">
                        <div class="flex-1">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-pink-500 to-pink-600 flex items-center justify-center text-white text-2xl mb-4 shadow-lg shadow-pink-500/30">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">{{ __('landing.service_appointments_title') }}</h3>
                            <p class="text-white/50 text-sm">{{ __('landing.service_appointments_desc') }}</p>
                        </div>
                        <div class="lg:w-48 perspective-container">
                            <div class="bg-white/5 rounded-xl p-3 transform hover:scale-105 transition-all">
                                <div class="app-calendar" style="font-size: 0.6rem;">
                                    @foreach(['S','M','T','W','T','F','S'] as $d)
                                    <div class="text-center text-white/30">{{ $d }}</div>
                                    @endforeach
                                    @for($i = 1; $i <= 14; $i++)
                                    <div class="app-calendar-day {{ in_array($i, [3,7,11]) ? 'booked' : '' }}" style="font-size: 0.55rem;">{{ $i }}</div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service 2: POS & Invoicing -->
                <div class="service-card reveal stagger-2">
                    <div class="flex flex-col lg:flex-row gap-6">
                        <div class="flex-1">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center text-white text-2xl mb-4 shadow-lg shadow-purple-500/30">
                                <i class="fas fa-cash-register"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">{{ __('landing.service_clients_title') }}</h3>
                            <p class="text-white/50 text-sm">{{ __('landing.service_clients_desc') }}</p>
                        </div>
                        <div class="lg:w-48">
                            <div class="app-invoice transform hover:scale-105 transition-all">
                                <div class="app-invoice-row"><span>Hair Cut</span><span>25.00</span></div>
                                <div class="app-invoice-row"><span>Manicure</span><span>30.00</span></div>
                                <div class="app-invoice-row"><span>VAT (5%)</span><span>2.75</span></div>
                                <div class="app-invoice-total border-t border-white/10">
                                    <span>Total</span><span class="text-pink-400">57.75 OMR</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service 3: Staff & Salaries -->
                <div class="service-card reveal stagger-3">
                    <div class="flex flex-col lg:flex-row gap-6">
                        <div class="flex-1">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-2xl mb-4 shadow-lg shadow-blue-500/30">
                                <i class="fas fa-money-check-alt"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">{{ __('landing.service_staff_title') }}</h3>
                            <p class="text-white/50 text-sm">{{ __('landing.service_staff_desc') }}</p>
                        </div>
                        <div class="lg:w-48">
                            <div class="space-y-2 transform hover:scale-105 transition-all">
                                <div class="app-salary-row">
                                    <div class="app-salary-avatar">F</div>
                                    <div class="flex-1">
                                        <div class="text-xs text-white">Fatima</div>
                                        <div class="text-xs text-white/40">10% comm.</div>
                                    </div>
                                    <span class="text-xs text-green-400 font-bold">450</span>
                                </div>
                                <div class="app-salary-row">
                                    <div class="app-salary-avatar">S</div>
                                    <div class="flex-1">
                                        <div class="text-xs text-white">Sara</div>
                                        <div class="text-xs text-white/40">15% comm.</div>
                                    </div>
                                    <span class="text-xs text-green-400 font-bold">520</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service 4: Expense Tracking -->
                <div class="service-card reveal stagger-4">
                    <div class="flex flex-col lg:flex-row gap-6">
                        <div class="flex-1">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white text-2xl mb-4 shadow-lg shadow-amber-500/30">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">{{ __('landing.service_payments_title') }}</h3>
                            <p class="text-white/50 text-sm">{{ __('landing.service_payments_desc') }}</p>
                        </div>
                        <div class="lg:w-48">
                            <div class="space-y-2 transform hover:scale-105 transition-all">
                                <div class="app-expense-card">
                                    <div class="app-expense-icon bg-red-500/20 text-red-400"><i class="fas fa-home"></i></div>
                                    <div class="flex-1">
                                        <div class="text-xs text-white">{{ app()->getLocale() === 'ar' ? 'إيجار' : 'Rent' }}</div>
                                    </div>
                                    <span class="text-xs text-red-400">-500</span>
                                </div>
                                <div class="app-expense-card">
                                    <div class="app-expense-icon bg-yellow-500/20 text-yellow-400"><i class="fas fa-bolt"></i></div>
                                    <div class="flex-1">
                                        <div class="text-xs text-white">{{ app()->getLocale() === 'ar' ? 'كهرباء' : 'Utilities' }}</div>
                                    </div>
                                    <span class="text-xs text-yellow-400">-85</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service 5: Financial Reports -->
                <div class="service-card reveal stagger-5">
                    <div class="flex flex-col lg:flex-row gap-6">
                        <div class="flex-1">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white text-2xl mb-4 shadow-lg shadow-emerald-500/30">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">{{ __('landing.service_reports_title') }}</h3>
                            <p class="text-white/50 text-sm">{{ __('landing.service_reports_desc') }}</p>
                        </div>
                        <div class="lg:w-48">
                            <div class="bg-white/5 rounded-xl p-3 transform hover:scale-105 transition-all">
                                <div class="text-xs text-white/50 mb-2">{{ app()->getLocale() === 'ar' ? 'صافي الربح' : 'Net Profit' }}</div>
                                <div class="app-chart" style="height: 60px;">
                                    <div class="app-chart-bar" style="height: 50%; background: linear-gradient(to top, #10b981, #34d399);"></div>
                                    <div class="app-chart-bar" style="height: 70%; background: linear-gradient(to top, #10b981, #34d399);"></div>
                                    <div class="app-chart-bar" style="height: 45%; background: linear-gradient(to top, #10b981, #34d399);"></div>
                                    <div class="app-chart-bar" style="height: 85%; background: linear-gradient(to top, #10b981, #34d399);"></div>
                                    <div class="app-chart-bar" style="height: 65%; background: linear-gradient(to top, #10b981, #34d399);"></div>
                                </div>
                                <div class="flex justify-between text-xs mt-2">
                                    <span class="text-green-400 font-bold">+18%</span>
                                    <span class="text-white/40">This Month</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service 6: Packages & Coupons -->
                <div class="service-card reveal stagger-6">
                    <div class="flex flex-col lg:flex-row gap-6">
                        <div class="flex-1">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-pink-500 to-rose-600 flex items-center justify-center text-white text-2xl mb-4 shadow-lg shadow-pink-500/30">
                                <i class="fas fa-tags"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">{{ __('landing.service_mobile_title') }}</h3>
                            <p class="text-white/50 text-sm">{{ __('landing.service_mobile_desc') }}</p>
                        </div>
                        <div class="lg:w-48">
                            <div class="app-coupon transform hover:scale-105 transition-all">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-lg font-black gradient-text">20% OFF</span>
                                    <i class="fas fa-ticket-alt text-pink-400"></i>
                                </div>
                                <div class="text-xs text-white/50">Code: <span class="text-pink-400 font-mono font-bold">VIP20</span></div>
                                <div class="text-xs text-white/30 mt-1">Min. purchase: 50 OMR</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FEATURES SECTION ===== -->
    <section class="section section-gradient" id="features">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 rounded-full glass text-sm text-purple-400 mb-4 reveal">
                    <i class="fas fa-star me-2"></i>{{ __('landing.nav_features') }}
                </span>
                <h2 class="section-title reveal stagger-1">{{ __('landing.features_title') }}</h2>
                <p class="section-subtitle reveal stagger-2">{{ __('landing.features_subtitle') }}</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $features = [
                        ['icon' => 'fa-globe', 'color' => 'from-pink-500 to-rose-500', 'title' => 'feature_instant_booking_title', 'desc' => 'feature_instant_booking_desc'],
                        ['icon' => 'fa-user-shield', 'color' => 'from-purple-500 to-indigo-500', 'title' => 'feature_products_title', 'desc' => 'feature_products_desc'],
                        ['icon' => 'fa-chart-line', 'color' => 'from-blue-500 to-cyan-500', 'title' => 'feature_service_mgmt_title', 'desc' => 'feature_service_mgmt_desc'],
                        ['icon' => 'fa-file-invoice-dollar', 'color' => 'from-amber-500 to-orange-500', 'title' => 'feature_staff_perf_title', 'desc' => 'feature_staff_perf_desc'],
                        ['icon' => 'fa-exchange-alt', 'color' => 'from-emerald-500 to-teal-500', 'title' => 'feature_client_mgmt_title', 'desc' => 'feature_client_mgmt_desc'],
                        ['icon' => 'fa-headset', 'color' => 'from-pink-500 to-purple-500', 'title' => 'feature_support_title', 'desc' => 'feature_support_desc'],
                    ];
                @endphp

                @foreach($features as $i => $feature)
                <div class="feature-card tilt-card reveal stagger-{{ $i + 1 }}">
                    <div class="feature-icon bg-gradient-to-br {{ $feature['color'] }}">
                        <i class="fas {{ $feature['icon'] }}"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">{{ __('landing.' . $feature['title']) }}</h3>
                    <p class="text-white/50 text-sm">{{ __('landing.' . $feature['desc']) }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ===== PRICING SECTION ===== -->
    <section class="section section-dark" id="pricing">
        <div class="blob" style="top: 50%; left: -100px; transform: translateY(-50%); width: 400px; height: 400px;"></div>
        <div class="blob" style="top: 50%; right: -100px; transform: translateY(-50%); width: 400px; height: 400px; animation-delay: -7s;"></div>

        <div class="max-w-5xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 rounded-full glass text-sm text-amber-400 mb-4 reveal">
                    {{ __('landing.pricing_badge') }}
                </span>
                <h2 class="section-title reveal stagger-1">{{ __('landing.pricing_title') }}</h2>
                <p class="section-subtitle reveal stagger-2">{{ __('landing.pricing_subtitle') }}</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Monthly -->
                <div class="pricing-card reveal-left stagger-1">
                    <div class="text-white/60 text-sm mb-2">{{ __('landing.pricing_monthly_label') }}</div>
                    <div class="flex items-baseline gap-2 mb-6">
                        <span class="pricing-price">15</span>
                        <span class="text-white/50">OMR{{ __('landing.pricing_monthly_period') }}</span>
                    </div>
                    <div class="text-white/40 text-sm mb-6">{{ __('landing.pricing_monthly_yearly') }}</div>
                    
                    <ul class="space-y-3 mb-8">
                        @foreach(['pricing_feat_appointments', 'pricing_feat_clients', 'pricing_feat_payments', 'pricing_feat_reports'] as $feat)
                        <li class="flex items-center gap-3 text-sm text-white/70">
                            <i class="fas fa-check text-green-400"></i>
                            <span>{{ __('landing.' . $feat) }}</span>
                        </li>
                        @endforeach
                    </ul>
                    
                    <a href="{{ route('login') }}" class="btn-outline w-full justify-center">
                        <span>{{ __('landing.pricing_choose_plan') }}</span>
                    </a>
                </div>

                <!-- Yearly (Featured) -->
                <div class="pricing-card featured reveal-right stagger-2">
                    <div class="pricing-badge">{{ __('landing.pricing_yearly_save') }}</div>
                    <div class="text-white/60 text-sm mb-2">{{ __('landing.pricing_yearly_label') }}</div>
                    <div class="flex items-baseline gap-2 mb-6">
                        <span class="pricing-price">120</span>
                        <span class="text-white/50">OMR{{ __('landing.pricing_yearly_period') }}</span>
                    </div>
                    <div class="text-pink-400/80 text-sm font-semibold mb-6">{{ __('landing.pricing_best_badge') }}</div>
                    
                    <ul class="space-y-3 mb-8">
                        @foreach(['pricing_feat_appointments', 'pricing_feat_clients', 'pricing_feat_payments', 'pricing_feat_reports', 'pricing_feat_responsive', 'pricing_feat_staff_perf', 'pricing_feat_products', 'pricing_feat_support'] as $feat)
                        <li class="flex items-center gap-3 text-sm text-white/70">
                            <i class="fas fa-check text-green-400"></i>
                            <span>{{ __('landing.' . $feat) }}</span>
                        </li>
                        @endforeach
                    </ul>
                    
                    <a href="{{ route('login') }}" class="btn-primary w-full justify-center">
                        <span>{{ __('landing.pricing_start_trial') }}</span>
                        <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}"></i>
                    </a>
                </div>
            </div>

            <p class="text-center text-white/40 text-sm mt-8 reveal">{{ __('landing.pricing_no_hidden') }}</p>
        </div>
    </section>

    <!-- ===== CONTACT SECTION ===== -->
    <section class="section section-gradient" id="contact">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 rounded-full glass text-sm text-blue-400 mb-4 reveal">
                    <i class="fas fa-envelope me-2"></i>{{ __('landing.nav_contact') }}
                </span>
                <h2 class="section-title reveal stagger-1">{{ __('landing.contact_title') }}</h2>
                <p class="section-subtitle reveal stagger-2">{{ __('landing.contact_subtitle') }}</p>
            </div>

            <div class="grid lg:grid-cols-2 gap-12">
                <!-- Contact Info -->
                <div class="reveal-left">
                    <div class="space-y-6">
                        <div class="flex gap-4 p-4 rounded-2xl glass">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-pink-500 to-pink-600 flex items-center justify-center text-white flex-shrink-0">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h3 class="text-white font-semibold">{{ __('landing.contact_email_title') }}</h3>
                                <p class="text-white/50 text-sm">{{ __('landing.contact_email_desc') }}</p>
                                <a href="mailto:info@northline-dev.com" class="text-pink-400 text-sm mt-1 block">info@northline-dev.com</a>
                            </div>
                        </div>

                        <div class="flex gap-4 p-4 rounded-2xl glass">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center text-white flex-shrink-0">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div>
                                <h3 class="text-white font-semibold">{{ __('landing.contact_whatsapp_title') }}</h3>
                                <p class="text-white/50 text-sm">{{ __('landing.contact_whatsapp_desc') }}</p>
                                <a href="https://wa.me/96898084952" class="text-green-400 text-sm mt-1 block">+968 9808 4952</a>
                            </div>
                        </div>

                        <div class="flex gap-4 p-4 rounded-2xl glass">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white flex-shrink-0">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h3 class="text-white font-semibold">{{ __('landing.contact_address_title') }}</h3>
                                <p class="text-white/50 text-sm">{{ __('landing.contact_address_desc') }}</p>
                                <p class="text-blue-400 text-sm mt-1">{{ __('landing.contact_address_value') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="reveal-right">
                    <form action="{{ route('contact.store') }}" method="POST" class="glass rounded-2xl p-8">
                        @csrf
                        <div class="grid md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-white/60 text-sm mb-2">{{ __('landing.contact_name') }}</label>
                                <input type="text" name="name" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:border-pink-500 focus:outline-none transition" placeholder="{{ __('landing.contact_name_placeholder') }}">
                            </div>
                            <div>
                                <label class="block text-white/60 text-sm mb-2">{{ __('landing.contact_email') }}</label>
                                <input type="email" name="email" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:border-pink-500 focus:outline-none transition" placeholder="{{ __('landing.contact_email_placeholder') }}">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-white/60 text-sm mb-2">{{ __('landing.contact_phone') }}</label>
                            <input type="tel" name="phone" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:border-pink-500 focus:outline-none transition" placeholder="{{ __('landing.contact_phone_placeholder') }}">
                        </div>
                        <div class="mb-4">
                            <label class="block text-white/60 text-sm mb-2">{{ __('landing.contact_subject') }}</label>
                            <input type="text" name="subject" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:border-pink-500 focus:outline-none transition" placeholder="{{ __('landing.contact_subject_placeholder') }}">
                        </div>
                        <div class="mb-6">
                            <label class="block text-white/60 text-sm mb-2">{{ __('landing.contact_message') }}</label>
                            <textarea name="message" rows="4" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:border-pink-500 focus:outline-none transition resize-none" placeholder="{{ __('landing.contact_message_placeholder') }}"></textarea>
                        </div>
                        <button type="submit" class="btn-primary w-full justify-center">
                            <span>{{ __('landing.contact_send') }}</span>
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA SECTION ===== -->
    <section class="cta-section py-24">
        <div class="cta-glow"></div>
        <div class="max-w-4xl mx-auto px-6 text-center relative">
            <h2 class="section-title reveal">{{ __('landing.cta_title') }}</h2>
            <p class="text-white/60 text-lg mt-4 reveal stagger-1">{{ __('landing.cta_subtitle') }}</p>
            <div class="flex flex-wrap gap-4 justify-center mt-10 reveal stagger-2">
                <a href="{{ route('login') }}" class="btn-primary">
                    <span>{{ __('landing.pricing_start_trial') }}</span>
                    <i class="fas fa-rocket"></i>
                </a>
                <a href="#contact" class="btn-outline">
                    <span>{{ __('landing.pricing_call_us') }}</span>
                    <i class="fas fa-phone"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="footer py-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-20 h-10 rounded-xl bg-gradient-to-br from-[#dd208e] to-[#ffffff] flex items-center justify-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-[500px] h-auto">
                </div>
               
                       
                    </div>
                    <p class="text-white/50 text-sm">{{ __('landing.footer_desc') }}</p>
                </div>
                
                <div>
                    <h4 class="text-white font-semibold mb-4">{{ __('landing.footer_product') }}</h4>
                    <ul class="space-y-2 text-sm text-white/50">
                        <li><a href="#features" class="hover:text-pink-400 transition">{{ __('landing.nav_features') }}</a></li>
                        <li><a href="#pricing" class="hover:text-pink-400 transition">{{ __('landing.nav_pricing') }}</a></li>
                        <li><a href="#services" class="hover:text-pink-400 transition">{{ __('landing.nav_services') }}</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white font-semibold mb-4">{{ __('landing.footer_company') }}</h4>
                    <ul class="space-y-2 text-sm text-white/50">
                        <li><a href="#about" class="hover:text-pink-400 transition">{{ __('landing.nav_about') }}</a></li>
                        <li><a href="#contact" class="hover:text-pink-400 transition">{{ __('landing.nav_contact') }}</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white font-semibold mb-4">{{ __('landing.footer_legal') }}</h4>
                    <ul class="space-y-2 text-sm text-white/50">
                        <li><a href="{{ route('policy') }}" class="hover:text-pink-400 transition">{{ __('landing.footer_terms') }}</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-white/40 text-sm">{{ __('landing.footer_copyright') }}</p>
                <p class="text-white/40 text-sm">{{ __('landing.footer_developed_by') }}</p>
            </div>
        </div>
    </footer>

    <!-- ===== SCROLL REVEAL SCRIPT ===== -->
    <script>
        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Reveal on scroll
        const reveals = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');
        const revealOnScroll = () => {
            reveals.forEach(el => {
                const windowHeight = window.innerHeight;
                const revealTop = el.getBoundingClientRect().top;
                const revealPoint = 150;

                if (revealTop < windowHeight - revealPoint) {
                    el.classList.add('active');
                }
            });
        };
        window.addEventListener('scroll', revealOnScroll);
        revealOnScroll(); // Initial check

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Tilt effect on 3D cards
        document.querySelectorAll('.tilt-card').forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                const rotateX = (y - centerY) / 20;
                const rotateY = (centerX - x) / 20;
                card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = '';
            });
        });
    </script>
</body>
</html>
