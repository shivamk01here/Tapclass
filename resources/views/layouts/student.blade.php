<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'TapClass')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>tailwind.config={theme:{extend:{colors:{"primary":"#13a4ec","secondary":"#FFA500"},fontFamily:{"display":["Manrope","sans-serif"]}}}}</script>
    @stack('styles')
</head>
<body class="bg-[#f6f7f8] font-display">

<!-- Sidebar -->
@include('components.sidebar', [
    'dashboardRoute' => route('student.dashboard'),
    'settingsRoute' => route('student.settings'),
    'menuItems' => [
        ['icon' => 'home', 'label' => 'Dashboard', 'route' => route('student.dashboard'), 'active' => request()->routeIs('student.dashboard')],
        ['icon' => 'calendar_month', 'label' => 'My Bookings', 'route' => route('student.bookings'), 'active' => request()->routeIs('student.bookings')],
        ['icon' => 'account_balance_wallet', 'label' => 'Wallet', 'route' => route('student.wallet'), 'active' => request()->routeIs('student.wallet')],
        ['icon' => 'favorite', 'label' => 'Wishlist', 'route' => route('student.wishlist'), 'active' => request()->routeIs('student.wishlist')],
        ['icon' => 'notifications', 'label' => 'Notifications', 'route' => route('student.notifications'), 'active' => request()->routeIs('student.notifications')]
    ]
])

<!-- Main Content Area -->
<div class="lg:ml-16">
    <!-- Top Navbar -->
    <header class="bg-white border-b border-gray-200 px-4 lg:px-6 py-3 lg:py-4 sticky top-0 z-40">
        <div class="flex items-center justify-between gap-2">
            <!-- Hamburger Menu (Mobile) -->
            <button onclick="toggleMobileSidebar()" class="lg:hidden p-2 hover:bg-gray-100 rounded-lg">
                <span class="material-symbols-outlined">menu</span>
            </button>

            <!-- Logo and Search -->
            <div class="flex items-center gap-2 lg:gap-6 flex-1">
                <div class="hidden lg:flex items-center gap-2">
                    <span class="text-xl font-black">TapClass</span>
                </div>
                
                <!-- Search Bar (Hidden on mobile) -->
                <form action="{{ route('tutors.search') }}" method="GET" class="hidden md:block flex-1 max-w-md">
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                        <input 
                            type="text" 
                            name="q" 
                            placeholder="Search for subjects, tutors..." 
                            value="{{ request('q') }}"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary bg-gray-50"
                        />
                    </div>
                </form>
            </div>

            <!-- Right Side - My Bookings, Wallet, Profile -->
            <div class="flex items-center gap-2 lg:gap-6">
                <!-- Bookings (Hidden on small mobile) -->
                <a href="{{ route('student.bookings') }}" class="hidden sm:block text-gray-700 hover:text-primary font-medium text-sm lg:text-base">
                    My Bookings
                </a>
                
                <!-- Wallet -->
                <a href="{{ route('student.wallet') }}" class="flex items-center gap-1 lg:gap-2 text-gray-700 hover:text-primary">
                    <span class="material-symbols-outlined text-xl">account_balance_wallet</span>
                    <span class="font-semibold text-sm lg:text-base">₹{{ number_format(auth()->user()->wallet->balance ?? 0, 0) }}</span>
                </a>

                <!-- Profile Dropdown -->
                <div class="relative group">
                    @if(auth()->user()->profile_picture)
                        <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" class="w-8 h-8 lg:w-10 lg:h-10 rounded-full object-cover cursor-pointer border-2 border-gray-200" alt="Profile"/>
                    @else
                        <div class="w-8 h-8 lg:w-10 lg:h-10 rounded-full bg-primary/20 flex items-center justify-center cursor-pointer border-2 border-primary">
                            <span class="text-primary font-bold text-sm lg:text-lg">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                    @endif
                    
                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 top-full mt-2 w-48 bg-white rounded-lg shadow-xl border opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all">
                        <div class="p-3 border-b">
                            <p class="font-semibold text-sm">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('student.settings') }}" class="block px-3 py-2 text-sm hover:bg-gray-50 flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">settings</span>
                            Settings
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-3 py-2 text-sm hover:bg-gray-50 text-red-600 flex items-center gap-2">
                                <span class="material-symbols-outlined text-lg">logout</span>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>
</div>

@stack('scripts')

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
