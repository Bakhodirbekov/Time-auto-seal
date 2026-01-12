<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel – InsofAuto</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @stack('styles')
</head>
<body class="min-h-screen bg-background">
    <!-- Success/Error Messages -->
    @if(session('success'))
    <div id="successToast" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-3 animate-slide-in">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    <script>
        setTimeout(() => {
            const toast = document.getElementById('successToast');
            if (toast) {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.5s';
                setTimeout(() => toast.remove(), 500);
            }
        }, 3000);
    </script>
    @endif

    @if(session('error'))
    <div id="errorToast" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-3 animate-slide-in">
        <i class="fas fa-exclamation-circle"></i>
        <span>{{ session('error') }}</span>
    </div>
    <script>
        setTimeout(() => {
            const toast = document.getElementById('errorToast');
            if (toast) {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.5s';
                setTimeout(() => toast.remove(), 500);
            }
        }, 3000);
    </script>
    @endif
    <div class="flex h-screen">
        <!-- Sidebar Navigation -->
        <aside class="sidebar bg-primary text-white w-64 flex flex-col flex-shrink-0">
            <div class="p-6 border-b border-secondary">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg bg-accent flex items-center justify-center">
                        <i class="fas fa-cogs text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">InsofAuto</h1>
                        <p class="text-sm text-gray-400">Admin Panel</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt w-6"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.cars') }}" class="nav-item {{ request()->routeIs('admin.cars') ? 'active' : '' }}">
                    <i class="fas fa-car w-6"></i>
                    <span>Avtomobillar</span>
                </a>
                <a href="{{ route('admin.hot-deals') }}" class="nav-item {{ request()->routeIs('admin.hot-deals') ? 'active' : '' }}">
                    <i class="fas fa-bolt w-6"></i>
                    <span>Tez sotish</span>
                </a>
                <a href="{{ route('admin.categories') }}" class="nav-item {{ request()->routeIs('admin.categories') ? 'active' : '' }}">
                    <i class="fas fa-folder w-6"></i>
                    <span>Kategoriyalar</span>
                </a>
                <a href="{{ route('admin.users') }}" class="nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <i class="fas fa-users w-6"></i>
                    <span>Foydalanuvchilar</span>
                </a>
                <a href="{{ route('admin.timers') }}" class="nav-item {{ request()->routeIs('admin.timers') ? 'active' : '' }}">
                    <i class="fas fa-clock w-6"></i>
                    <span>Taymer nazorati</span>
                </a>
                <a href="{{ route('admin.complaints') }}" class="nav-item {{ request()->routeIs('admin.complaints') ? 'active' : '' }}">
                    <i class="fas fa-flag w-6"></i>
                    <span>Shikoyatlar</span>
                </a>
                <a href="{{ route('admin.notifications') }}" class="nav-item {{ request()->routeIs('admin.notifications') ? 'active' : '' }}">
                    <i class="fas fa-bell w-6"></i>
                    <span>Bildirishnomalar</span>
                </a>
                <a href="{{ route('admin.settings') }}" class="nav-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <i class="fas fa-cog w-6"></i>
                    <span>Sozlamalar</span>
                </a>
                <a href="{{ route('admin.admins') }}" class="nav-item {{ request()->routeIs('admin.admins') ? 'active' : '' }}">
                    <i class="fas fa-user-shield w-6"></i>
                    <span>Adminlar</span>
                </a>
                
                <div class="pt-4 mt-4 border-t border-secondary"></div>
                
                <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
                    @csrf
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-item text-red-400 hover:bg-red-900/20">
                    <i class="fas fa-sign-out-alt w-6"></i>
                    <span>Logout</span>
                </a>
            </nav>

            <div class="p-4 border-t border-secondary">
                <div class="flex items-center space-x-3">
                    <img src="https://picsum.photos/40?random=100" alt="Admin avatar" class="w-8 h-8 rounded-full">
                    <div class="flex-1">
                        <p class="text-sm font-medium">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-gray-400">{{ auth()->user()->email ?? 'admin@insofauto.uz' }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <button onclick="toggleSidebar()" class="mr-4 lg:hidden p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">@yield('page_title', 'Dashboard')</h2>
                            <p class="text-gray-600">Insof bilan boshqaruv</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" placeholder="Qidirish..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <button class="relative p-2 text-gray-600 hover:text-primary">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
