<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'Htc')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>tailwind.config={theme:{extend:{colors:{"primary":"#13a4ec","secondary":"#FFA500"},fontFamily:{"display":["Manrope","sans-serif"]}}}}</script>
    @stack('styles')
</head>
<body class="bg-[#f6f7f8] font-display">

<div class="hidden md:block">
    @include('components.sidebar', [
        'dashboardRoute' => route('tutor.dashboard'),
        'settingsRoute' => route('tutor.profile'),
        'menuItems' => [
            ['icon' => 'home', 'label' => 'Dashboard', 'route' => route('tutor.dashboard'), 'active' => request()->routeIs('tutor.dashboard')],
            ['icon' => 'calendar_month', 'label' => 'My Bookings', 'route' => route('tutor.bookings'), 'active' => request()->routeIs('tutor.bookings')],
            ['icon' => 'payments', 'label' => 'Earnings', 'route' => route('tutor.earnings'), 'active' => request()->routeIs('tutor.earnings')],
            ['icon' => 'schedule', 'label' => 'Availability', 'route' => route('tutor.availability'), 'active' => request()->routeIs('tutor.availability')],
            ['icon' => 'star', 'label' => 'Reviews', 'route' => route('tutor.reviews'), 'active' => request()->routeIs('tutor.reviews')],
            ['icon' => 'notifications', 'label' => 'Notifications', 'route' => route('tutor.notifications'), 'active' => request()->routeIs('tutor.notifications')]
        ]
    ])
</div>

<div class="md:ml-16 pb-20 md:pb-0">
    <header class="bg-white border-b border-gray-200 px-4 md:px-6 py-4 sticky top-0 z-40">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4 flex-1">
                <div class="flex items-center gap-2">
                    
                    <span class="text-xl font-black">Htc</span>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('tutor.bookings') }}" class="hidden md:block text-gray-700 hover:text-primary font-medium">
                    My Bookings
                </a>
                
                <a href="{{ route('tutor.earnings') }}" class="hidden md:flex items-center gap-2 text-gray-700 hover:text-primary">
                    <span class="material-symbols-outlined">payments</span>
                    <span class="font-semibold">Earnings</span>
                </a>

                <div class="relative group">
                    @if(auth()->user()->profile_picture)
                        <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" class="w-10 h-10 rounded-full object-cover cursor-pointer border-2 border-gray-200" alt="Profile"/>
                    @else
                        <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center cursor-pointer border-2 border-primary">
                            <span class="text-primary font-bold text-lg">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                    @endif
                    
                    <div class="absolute right-0 top-full mt-2 w-48 bg-white rounded-lg shadow-xl border opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                        <div class="p-3 border-b">
                            <p class="font-semibold text-sm">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('tutor.profile') }}" class="block px-3 py-2 text-sm hover:bg-gray-50 flex items-center gap-2">
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

    <main>
        @yield('content')
    </main>
</div>

@php
    // Define menu items for mobile nav (5 items max for good UX)
    // Shorter labels are better for mobile
    $mobileMenuItems = [
        ['icon' => 'home', 'label' => 'Home', 'route' => route('tutor.dashboard'), 'active' => request()->routeIs('tutor.dashboard')],
        ['icon' => 'calendar_month', 'label' => 'Bookings', 'route' => route('tutor.bookings'), 'active' => request()->routeIs('tutor.bookings')],
        ['icon' => 'schedule', 'label' => 'Hours', 'route' => route('tutor.availability'), 'active' => request()->routeIs('tutor.availability')],
        ['icon' => 'payments', 'label' => 'Earnings', 'route' => route('tutor.earnings'), 'active' => request()->routeIs('tutor.earnings')],
        ['icon' => 'notifications', 'label' => 'Alerts', 'route' => route('tutor.notifications'), 'active' => request()->routeIs('tutor.notifications')]
    ];
@endphp
<nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50 shadow-inner">
    <div class="flex justify-around items-center h-16 px-2">
        @foreach($mobileMenuItems as $item)
            <a href="{{ $item['route'] }}" class="flex flex-col items-center justify-center text-xs font-medium w-full {{ $item['active'] ? 'text-primary' : 'text-gray-600' }} hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-2xl">{{ $item['icon'] }}</span>
                <span class="mt-1">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>
</nav>


@stack('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>