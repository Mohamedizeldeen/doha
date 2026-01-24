<!-- Sidebar Navigation -->
<nav id="sidebar" class="w-60 bg-gradient-to-b from-[#dd208e] to-[#961660] min-h-screen fixed right-0 top-0 z-40 shadow-lg transition-transform duration-300">
    <!-- Close Button for Mobile -->
    <div style="display: none; padding: 1rem;" class="mobile-close">
        <button id="sidebar-close" style="background: none; border: none; color: white; font-size: 1.5rem; cursor: pointer; width: 44px; height: 44px; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Main Navigation Menu -->
    <ul class="list-none p-5 m-0 space-y-3" style="padding-top: 0;">
        <!-- Dashboard -->
        <li>
            <a href="{{ route('admin.dashbord') }}" class="nav-link flex items-center gap-3 py-3 px-4 rounded-lg text-white hover:bg-white/10 transition-all text-right">
                <span class="text-lg">📊</span>
                <span class="font-medium text-sm">لوحة التحكم</span>
                
            </a>
        </li>

        <!-- Users Management -->
        <li>
            <a href="{{ route('staff.index', $salon ?? auth()->user()->salons->first()) }}" class="nav-link flex items-center gap-3 py-3 px-4 rounded-lg text-white hover:bg-white/10 transition-all text-right">
                <span class="text-lg">👥</span>
                <span class="font-medium text-sm">إدارة الموظفين</span>
                
            </a>
        </li>

        <!-- Services -->
        <li>
            <a href="{{ route('service.index', $salon ?? auth()->user()->salons->first()) }}" class="nav-link flex items-center gap-3 py-3 px-4 rounded-lg text-white hover:bg-white/10 transition-all text-right">
                <span class="text-lg">🛠️</span>
                <span class="font-medium text-sm">الخدمات</span>
                
            </a>
        </li>

        <!-- Bookings -->
        <li>
            <a href="{{ route('booking.index', $salon ?? auth()->user()->salons->first()) }}" class="nav-link flex items-center gap-3 py-3 px-4 rounded-lg text-white hover:bg-white/10 transition-all text-right">
                <span class="text-lg">📅</span>
                <span class="font-medium text-sm">الحجوزات</span>
                
            </a>
        </li>

        <!-- Customers -->
        <li>
            <a href="{{ route('client.index', $salon ?? auth()->user()->salons->first()) }}" class="nav-link flex items-center gap-3 py-3 px-4 rounded-lg text-white hover:bg-white/10 transition-all text-right">
                <span class="text-lg">🤝</span>
                <span class="font-medium text-sm">العملاء</span>
                
            </a>
        </li>

        <!-- Products -->
        <li>
            <a href="{{ route('product.index', $salon ?? auth()->user()->salons->first()) }}" class="nav-link flex items-center gap-3 py-3 px-4 rounded-lg text-white hover:bg-white/10 transition-all text-right">
                <span class="text-lg">📦</span>
                <span class="font-medium text-sm">المنتجات</span>
                
            </a>
        </li>

        <!-- Settings -->
        <li>
            <a href="{{ route('salon.show', $salon ?? auth()->user()->salons->first()) }}" class="nav-link flex items-center gap-3 py-3 px-4 rounded-lg text-white hover:bg-white/10 transition-all text-right">
                <span class="text-lg">⚙️</span>
                <span class="font-medium text-sm">الاعدادات</span>
                
            </a>
        </li>
    </ul>

    <!-- Divider -->
    <hr class="border-white/20 my-6 mx-4">

    <!-- Bottom Menu -->
    <ul class="list-none p-5 m-0 space-y-3">
        <!-- Logout -->
        <li>
            <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                @csrf
                <button type="submit" class="nav-link w-full flex items-center gap-3 py-3 px-4 rounded-lg text-white hover:bg-white/10 transition-all" style="text-align: right; justify-content: flex-end;">
                    <span class="text-lg">🚪</span>
                    <span class="font-medium text-sm">تسجيل الخروج</span>
                    
                </button>
            </form>
        </li>
    </ul>

    <style>
        /* Responsive sidebar */
        @media (max-width: 768px) {
            #sidebar .mobile-close {
                display: block !important;
            }

            #sidebar {
                width: 260px !important;
                height: 100vh;
                overflow-y: auto;
            }

            #sidebar ul li a {
                font-size: clamp(0.75rem, 2vw, 0.875rem);
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            #sidebar {
                width: 200px !important;
            }

            #sidebar ul li span.text-lg {
                font-size: 1rem;
            }

            #sidebar ul li .font-medium {
                font-size: 0.75rem;
            }
        }

        @media (min-width: 1025px) {
            #sidebar .mobile-close {
                display: none !important;
            }
        }

        /* Smooth scrollbar for sidebar */
        #sidebar::-webkit-scrollbar {
            width: 6px;
        }

        #sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        #sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        #sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
    </style>

    <script>
        // Close sidebar button
        const sidebarClose = document.getElementById('sidebar-close');
        const sidebarElement = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        if (sidebarClose) {
            sidebarClose.addEventListener('click', function() {
                sidebarElement.classList.remove('active');
                if (overlay) overlay.style.display = 'none';
            });
        }
    </script>
</nav>
</nav>

<style>
    body {
        font-family: 'Cairo', sans-serif;
    }

    .nav-link {
        cursor: pointer;
    }

    .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.15);
    }

    .nav-link.active {
        background-color: rgba(255, 255, 255, 0.2);
        border-right: 4px solid white;
    }
</style>