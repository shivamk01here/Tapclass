<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'Admin Dashboard') - Htc</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: { "primary": "#13a4ec", "secondary": "#FFA500" },
            fontFamily: { "display": ["Manrope", "sans-serif"] }
          }
        }
      }
    </script>
    @stack('styles')
</head>
<body class="bg-gray-50 font-display">
<div class="flex min-h-screen">
    <!-- 
      Sidebar:
      - `fixed` on all screens
      - `z-30` to appear above content
      - `transform -translate-x-full` to hide it off-screen by default on mobile
      - `lg:translate-x-0` to bring it back on large screens
      - `transition-transform` for smooth sliding animation
    -->
    <aside id="sidebar" class="w-64 bg-white border-r border-gray-200 fixed h-full z-30 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
        <div class="p-6">
            <!-- Logo -->
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-primary mb-8">
                <span class="material-symbols-outlined text-3xl">admin_panel_settings</span>
                <h2 class="text-xl font-bold">Htc Admin</h2>
            </a>
            
            <!-- Navigation -->
            <nav class="space-y-1">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-primary/10 text-primary' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('admin.tutors') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.tutors*') ? 'bg-primary/10 text-primary' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined">school</span>
                    <span>Tutors</span>
                    @php
                        $pendingCount = \App\Models\TutorProfile::where('verification_status', 'pending')->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
                    @endif
                </a>
                
                <a href="{{ route('admin.students') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.students') ? 'bg-primary/10 text-primary' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined">group</span>
                    <span>Students</span>
                </a>

                <a href="{{ route('admin.parents') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.parents*') ? 'bg-primary/10 text-primary' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined">family_restroom</span>
                    <span>Parents</span>
                </a>
                
                <a href="{{ route('admin.bookings') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.bookings') ? 'bg-primary/10 text-primary' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined">event</span>
                    <span>Bookings</span>
                </a>
                
                <a href="{{ route('admin.payouts') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.payouts') ? 'bg-primary/10 text-primary' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined">payments</span>
                    <span>Payouts</span>
                </a>

                <a href="{{ route('admin.consultations') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.consultations*') ? 'bg-primary/10 text-primary' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined">support_agent</span>
                    <span>Consultations</span>
                </a>
                
                <a href="{{ route('admin.settings') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.settings') ? 'bg-primary/10 text-primary' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined">settings</span>
                    <span>Settings</span>
                </a>
            </nav>
        </div>
        
        <!-- User Info & Logout (remains at bottom) -->
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200 bg-white">
            <div class="flex items-center gap-3 px-2 py-2 mb-2">
                <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary">admin_panel_settings</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">Administrator</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-red-600 hover:bg-red-50 rounded-lg font-medium transition-colors">
                    <span class="material-symbols-outlined text-xl">logout</span>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Sidebar Overlay: Shows on mobile when sidebar is open -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-20 hidden lg:hidden"></div>
    
    <!-- 
      Main Content:
      - `lg:ml-64` applies the margin only on large screens
      - `w-full` ensures it takes full width on mobile
    -->
    <main class="flex-1 lg:ml-64 w-full">
        <!-- Top Bar -->
        <header class="bg-white border-b border-gray-200 px-4 sm:px-8 py-4 sticky top-0 z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <!-- Hamburger Toggle Button (Mobile Only) -->
                    <button id="sidebar-toggle-btn" class="lg:hidden text-gray-700 hover:text-primary p-1">
                        <span class="material-symbols-outlined text-3xl">menu</span>
                    </button>
                    
                    <!-- Page Title -->
                    <h1 class="text-2xl font-black text-gray-900">@yield('page-title', 'Dashboard')</h1>
                </div>
                
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-600 hidden sm:block">{{ now()->format('D, M d, Y') }}</span>
                </div>
            </div>
        </header>
        
        <!-- Page Content -->
        <div class="p-4 sm:p-8">
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
                    <span class="material-symbols-outlined">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center gap-2">
                    <span class="material-symbols-outlined">error</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
            
            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @yield('content')
        </div>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebar-toggle-btn');
        const overlay = document.getElementById('sidebar-overlay');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', toggleSidebar);
        }
        
        if (overlay) {
            overlay.addEventListener('click', toggleSidebar);
        }
    });
</script>

@stack('scripts')
</body>
</html>
