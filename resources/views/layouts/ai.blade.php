<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'AI Exam Prep - HTC')</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        'black': '#000000', // Pure black
                        'primary': '#006cab',
                        'accent-yellow': '#FFBD59',
                    },
                    fontFamily: {
                        'sans': ['Poppins', 'sans-serif'],
                        'heading': ['Anton', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans text-white bg-black min-h-screen flex flex-col">

    <!-- Header -->
    <nav class="bg-black border-b border-white/10 py-4" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 flex items-center justify-between">
            <!-- Left: Logo -->
            <div class="flex items-center gap-1">
                <a href="{{ route('home') }}" class="flex items-center no-underline hover:opacity-80 transition-opacity">
                    <img src="{{ asset('images/white_logo.png') }}" alt="HTC X" class="h-10">
                </a>
            </div>

            <!-- Center: Pricing/Credits (Desktop Only) -->
            <div class="hidden md:flex items-center absolute left-1/2 -translate-x-1/2">
                <a href="{{ route('ai-test.pricing') }}" class="text-sm font-bold text-gray-300 hover:text-accent-yellow transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">workspace_premium</span>
                    PRICING / CREDITS
                </a>
            </div>

            <!-- Right: Desktop Menu -->
            <div class="hidden md:flex items-center gap-4">
                @auth
                    <!-- Credits Display -->
                    <div class="flex flex-col items-end mr-2">
                        <span class="text-xs text-gray-400">Credits</span>
                        <span class="text-sm font-bold text-accent-yellow">{{ auth()->user()->ai_test_credits ?? 0 }}</span>
                    </div>

                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 focus:outline-none hover:bg-white/10 px-3 py-2 rounded-lg transition-colors">
                            <i class="bi bi-grid-fill text-white text-lg"></i>
                            <i class="bi bi-chevron-down text-xs text-gray-400"></i>
                        </button>

                        <!-- Dropdown -->
                        <div x-show="open" 
                             style="display: none;"
                             x-transition
                             class="absolute right-0 mt-2 w-48 bg-black border border-white/20 rounded-xl shadow-2xl py-1 z-50">
                            
                            <div class="px-4 py-3 border-b border-white/10">
                                <p class="text-sm font-bold text-white truncate">{{ auth()->user()->name }}</p>
                            </div>

                            <a href="{{ auth()->user()->isStudent() ? route('student.dashboard') : (auth()->user()->isTutor() ? route('tutor.dashboard') : (auth()->user()->isParent() ? route('parent.dashboard') : route('admin.dashboard'))) }}" 
                               class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/10 hover:text-white transition-colors">
                                Dashboard
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-white/10 transition-colors">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-white hover:text-accent-yellow transition-colors">LOGIN</a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex md:hidden items-center gap-4">
                @auth
                <div class="flex flex-col items-end mr-1">
                     <span class="text-[10px] text-gray-400">Credits</span>
                     <span class="text-xs font-bold text-accent-yellow">{{ auth()->user()->ai_test_credits ?? 0 }}</span>
                </div>
                @endauth
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-white focus:outline-none p-2">
                    <span class="material-symbols-outlined text-3xl" x-text="mobileMenuOpen ? 'close' : 'menu'"></span>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Drawer (Slide from Left) -->
        <div class="relative z-50 md:hidden" role="dialog" aria-modal="true" x-show="mobileMenuOpen" style="display: none;">
            
            <!-- Backdrop -->
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-black/80 backdrop-blur-sm" 
                 @click="mobileMenuOpen = false"></div>

            <!-- Drawer -->
            <div x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="fixed inset-y-0 left-0 flex w-full max-w-xs flex-col bg-black border-r border-white/10 shadow-2xl">
                
                <!-- Drawer Header -->
                <div class="flex items-center justify-between px-6 py-6 border-b border-white/10">
                    <a href="{{ route('home') }}" class="flex items-center gap-1">
                        <img src="{{ asset('images/white_logo.png') }}" alt="HTC X" class="h-8">
                    </a>
                    <button @click="mobileMenuOpen = false" type="button" class="-m-2.5 rounded-md p-2.5 text-gray-400 hover:text-white transition-colors">
                        <span class="sr-only">Close menu</span>
                        <span class="material-symbols-outlined text-2xl">close</span>
                    </button>
                </div>

                <!-- Drawer Content -->
                <div class="flex flex-col flex-1 overflow-y-auto bg-black px-6 py-6">
                    @auth
                        <!-- User Info Card -->
                        <div class="mb-8 p-4 rounded-xl bg-white/5 border border-white/10">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 rounded-full bg-accent-yellow text-black flex items-center justify-center font-bold text-lg">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <div class="overflow-hidden">
                                    <p class="text-sm text-gray-400">Welcome,</p>
                                    <p class="text-base font-bold text-white truncate">{{ auth()->user()->name }}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between bg-black/50 p-3 rounded-lg border border-white/10">
                                <span class="text-sm text-gray-300">Credits</span>
                                <span class="text-lg font-bold text-accent-yellow">{{ auth()->user()->ai_test_credits ?? 0 }}</span>
                            </div>
                        </div>

                        <!-- Navigation -->
                        <nav class="space-y-2 flex-1">
                             <a href="{{ route('ai-test.pricing') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-300 hover:bg-white/10 hover:text-white rounded-lg transition-colors">
                                <span class="material-symbols-outlined text-accent-yellow">workspace_premium</span>
                                Buy Credits / Plans
                            </a>

                            <a href="{{ auth()->user()->isStudent() ? route('student.dashboard') : (auth()->user()->isTutor() ? route('tutor.dashboard') : (auth()->user()->isParent() ? route('parent.dashboard') : route('admin.dashboard'))) }}" 
                               class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-300 hover:bg-white/10 hover:text-white rounded-lg transition-colors">
                                <span class="material-symbols-outlined">grid_view</span>
                                Dashboard
                            </a>
                            
                             <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-300 hover:bg-white/10 hover:text-white rounded-lg transition-colors">
                                <span class="material-symbols-outlined">home</span>
                                Home
                            </a>
                        </nav>
                    @else
                        <div class="mb-8 text-center">
                            <p class="text-gray-400 mb-4">Sign in to access AI features</p>
                            <a href="{{ route('login') }}" class="flex w-full items-center justify-center gap-2 rounded-lg bg-accent-yellow px-4 py-3 text-sm font-bold text-black hover:bg-white transition-colors">
                                Login Now
                            </a>
                        </div>
                    @endauth
                </div>
                
                <!-- Drawer Footer -->
                @auth
                <div class="border-t border-white/10 px-6 py-6 bg-black">
                     <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex w-full items-center justify-center gap-3 rounded-lg border border-red-500/20 px-4 py-3 text-sm font-bold text-red-400 hover:bg-red-500/10 transition-colors">
                            <span class="material-symbols-outlined">logout</span>
                            Sign Out
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 z-0 opacity-20 pointer-events-none" 
             style="background-image: url('https://www.transparenttextures.com/patterns/grid-me.png');">
        </div>
        
        <!-- Content -->
        <div class="relative z-10 w-full">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-black border-t border-white/10 py-6 text-center">
        <p class="text-xs text-gray-500">
            AI-Powered Exam Preparation &copy; {{ date('Y') }} HTC. All rights reserved.
        </p>
    </footer>

</body>
</html>
