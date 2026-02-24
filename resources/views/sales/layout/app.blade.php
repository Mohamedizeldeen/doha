<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Doha - Sales</title>
    <link rel="icon" type="image/png" href="{{ asset('images/fav.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        :root { --primary: #dd208e; --primary-dark: #b01670; --sidebar-w: 270px; --header-h: 64px; }
        * { font-family: {{ app()->getLocale() === 'ar' ? "'Cairo'" : "'Inter'" }}, sans-serif; box-sizing: border-box; }
        body { background: #f0f2f5; margin: 0; min-height: 100vh; }
        .sidebar { position: fixed; top: 0; {{ app()->getLocale() === 'ar' ? 'right: 0;' : 'left: 0;' }} width: var(--sidebar-w); height: 100vh; background: linear-gradient(135deg, #1a2332 0%, #243447 50%, #1a2332 100%); z-index: 50; display: flex; flex-direction: column; transition: transform 0.3s cubic-bezier(0.4,0,0.2,1); overflow-y: auto; }
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(221,32,142,0.3); border-radius: 4px; }
        .sidebar-brand { padding: 1.25rem 1.5rem; display: flex; align-items: center; gap: 0.75rem; border-bottom: 1px solid rgba(255,255,255,0.06); }
        .sidebar-brand img { height: 36px; }
        .sidebar-brand span { color: #fff; font-size: 1.25rem; font-weight: 700; }
        .sidebar-brand .badge-role { background: #10b981; color: #fff; padding: 0.15rem 0.5rem; border-radius: 999px; font-size: 0.6rem; font-weight: 700; }
        .sidebar-nav { padding: 1rem 0.75rem; flex: 1; }
        .nav-section-label { font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(255,255,255,0.35); padding: 1rem 0.75rem 0.5rem; font-weight: 600; }
        .nav-item { display: flex; align-items: center; gap: 0.75rem; padding: 0.7rem 0.85rem; margin: 0.15rem 0; border-radius: 0.75rem; color: rgba(255,255,255,0.65); text-decoration: none; font-size: 0.875rem; font-weight: 500; transition: all 0.2s; }
        .nav-item:hover { background: rgba(221,32,142,0.12); color: #fff; }
        .nav-item.active { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: #fff; box-shadow: 0 4px 15px rgba(221,32,142,0.3); }
        .nav-item i { width: 20px; text-align: center; font-size: 1rem; flex-shrink: 0; }
        .sidebar-footer { padding: 1rem; border-top: 1px solid rgba(255,255,255,0.06); }
        .sidebar-user { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; border-radius: 0.75rem; background: rgba(255,255,255,0.05); }
        .sidebar-user-avatar { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #10b981, #059669); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 0.85rem; flex-shrink: 0; }
        .sidebar-user-name { color: #fff; font-size: 0.8rem; font-weight: 600; }
        .sidebar-user-role { color: rgba(255,255,255,0.4); font-size: 0.7rem; }
        .main-content { {{ app()->getLocale() === 'ar' ? 'margin-right' : 'margin-left' }}: var(--sidebar-w); min-height: 100vh; transition: margin 0.3s ease; }
        .topbar { position: sticky; top: 0; z-index: 40; height: var(--header-h); background: rgba(255,255,255,0.85); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(0,0,0,0.06); display: flex; align-items: center; justify-content: space-between; padding: 0 1.5rem; }
        .topbar-title { font-size: 1.15rem; font-weight: 700; color: #1a1a2e; }
        .topbar-btn { display: inline-flex; align-items: center; justify-content: center; width: 38px; height: 38px; border-radius: 0.625rem; border: 1px solid rgba(0,0,0,0.08); background: #fff; color: #64748b; cursor: pointer; transition: all 0.2s; font-size: 0.9rem; text-decoration: none; }
        .topbar-btn:hover { border-color: var(--primary); color: var(--primary); }
        .hamburger-btn { display: none !important; }
        .lang-switch { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.4rem 0.85rem; border-radius: 0.625rem; border: 1px solid rgba(0,0,0,0.08); background: #fff; color: #64748b; text-decoration: none; font-size: 0.8rem; font-weight: 600; transition: all 0.2s; }
        .lang-switch:hover { border-color: var(--primary); color: var(--primary); }
        .content-area { padding: 1.5rem; }
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); backdrop-filter: blur(4px); z-index: 45; }
        @media (max-width: 1024px) {
            .sidebar { transform: translateX({{ app()->getLocale() === 'ar' ? '100%' : '-100%' }}); }
            .sidebar.open { transform: translateX(0); }
            .main-content { {{ app()->getLocale() === 'ar' ? 'margin-right' : 'margin-left' }}: 0 !important; }
            .hamburger-btn { display: inline-flex !important; }
            .sidebar-overlay.active { display: block; }
        }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fadeIn 0.4s ease-out; }
    </style>
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('images/fav.png') }}" alt="Doha">
            <span>Doha</span>
            <span class="badge-role">SALES</span>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-section-label">{{ __('admin.overview') }}</div>
            <a href="{{ route('sales.dashboard') }}" class="nav-item {{ request()->routeIs('sales.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i><span>{{ __('admin.dashboard') }}</span>
            </a>
            <a href="{{ route('sales.salons.index') }}" class="nav-item {{ request()->routeIs('sales.salons.*') ? 'active' : '' }}">
                <i class="fas fa-store"></i><span>{{ __('admin.my_salons') }}</span>
            </a>
            <a href="{{ route('sales.salons.create') }}" class="nav-item {{ request()->routeIs('sales.salons.create') ? 'active' : '' }}">
                <i class="fas fa-plus-circle"></i><span>{{ __('admin.create_salon') }}</span>
            </a>
        </nav>
        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 1)) }}</div>
                <div>
                    <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                    <div class="sidebar-user-role">{{ __('admin.sales_person') }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="margin-top: 0.5rem;">
                @csrf
                <button type="submit" class="nav-item" style="width: 100%; border: none; cursor: pointer; background: none;">
                    <i class="fas fa-sign-out-alt"></i><span>{{ __('admin.logout') }}</span>
                </button>
            </form>
        </div>
    </aside>
    <div class="sidebar-overlay" id="sidebar-overlay"></div>
    <div class="main-content">
        <header class="topbar">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <button class="topbar-btn hamburger-btn" id="sidebar-toggle"><i class="fas fa-bars"></i></button>
                <h1 class="topbar-title">@yield('page-title', __('admin.dashboard'))</h1>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                @if(app()->getLocale() === 'ar')
                    <a href="{{ route('language.switch', 'en') }}" class="lang-switch"><i class="fas fa-globe"></i> EN</a>
                @else
                    <a href="{{ route('language.switch', 'ar') }}" class="lang-switch"><i class="fas fa-globe"></i> عربي</a>
                @endif
            </div>
        </header>
        <main class="content-area animate-fade-in">
            @if(session('success'))
                <div style="background: #ecfdf5; border: 1px solid #6ee7b7; color: #065f46; padding: 0.85rem 1.25rem; border-radius: 0.75rem; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div style="background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; padding: 0.85rem 1.25rem; border-radius: 0.75rem; margin-bottom: 1.25rem; font-size: 0.875rem;">
                    <i class="fas fa-exclamation-circle"></i>
                    @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                </div>
            @endif
            @yield('content')
        </main>
    </div>
    @stack('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggle = document.getElementById('sidebar-toggle');
        function closeSidebar() { sidebar.classList.remove('open'); overlay.classList.remove('active'); }
        if (toggle) toggle.addEventListener('click', function (e) { e.stopPropagation(); sidebar.classList.toggle('open'); overlay.classList.toggle('active'); });
        if (overlay) overlay.addEventListener('click', closeSidebar);
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeSidebar(); });
        sidebar.querySelectorAll('.nav-item').forEach(function(link) { if (link.tagName === 'A') link.addEventListener('click', function () { if (window.innerWidth <= 1024) closeSidebar(); }); });
    });
    </script>
</body>
</html>
