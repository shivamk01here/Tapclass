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
    <nav class="bg-black border-b border-white/10 py-4">
        <div class="max-w-7xl mx-auto px-4 flex items-center justify-between">
            <!-- Left: Logo + X -->
            <!-- Left: htcX Text -->
            <div class="flex items-center gap-1">
                <a href="{{ route('home') }}" class="flex items-center no-underline hover:opacity-80 transition-opacity">
                    <span class="text-white font-heading text-3xl tracking-tighter">htc</span>
                    <span class="text-accent-yellow font-heading text-3xl">X</span>
                </a>
            </div>

            <!-- Right: Dashboard/Logout -->
            <div class="flex items-center gap-4">
                @auth
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
