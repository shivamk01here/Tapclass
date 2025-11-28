<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'HTC - Find Your Perfect Tutor')</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        'black': '#10181B',
                        'primary': '#006cab',
                        'accent-yellow': '#FFBD59',
                        'text-subtle': '#667085',
                        'page-bg': '#fffcf0',
                        'footer-bg': '#334457',
                        'subscribe-bg': '#D1E3E6',
                        'steps-bg': '#b6e1e3', // Added your steps background
                    },
                    fontFamily: {
                        'sans': ['Poppins', 'sans-serif'],
                        'heading': ['Anton', 'sans-serif']
                    },
                    boxShadow: {
                        'header-chunky': '0 8px 0 0 #10181B',
                        'button-chunky': '0 4px 0 0 #10181B',
                        'button-chunky-hover': '0 2px 0 0 #10181B',
                        'button-chunky-active': '0 0 0 0 #10181B',
                    },
                    spacing: {
                        '0.5': '2px',
                        '1': '4px',
                    },
                    fontSize: {
                        'xxs': '0.825rem',
                        'hero-lg': '4.2rem',  
                        'hero-md': '3rem',   
                        'h2': '2.25rem',     
                        'h3': '1.5rem',     
                    }
                }
            }
        }
    </script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>

    @stack('styles')
</head>
<body class="font-sans text-black bg-page-bg">

    <div x-data="{ mobileMenuOpen: false, scrolled: false }" 
         @scroll.window="scrolled = (window.pageYOffset > 20)"
         class="sticky top-0 z-50 w-full transition-all duration-300"
         :class="{ 'bg-white/90 backdrop-blur-md shadow-md': scrolled, 'bg-white': !scrolled }">
        
        <nav class="py-3 transition-all duration-300" :class="{ 'py-2': scrolled, 'py-4': !scrolled }">
            <div class="max-w-7xl mx-auto px-4 flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center font-bold text-xl text-black group">
                    <img src="{{ asset('images/logo/htc.png') }}" alt="HTC Logo" class="h-10 w-auto transition-transform duration-300" :class="{ 'scale-90': scrolled }">
                </a>
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-lg hover:bg-gray-100">
                    <i class="bi bi-list text-3xl"></i>
                </button>
                <ul class="hidden lg:flex items-center mx-auto space-x-8">
                    <li><a href="{{ route('tutors.search') }}" class="block font-semibold uppercase text-xs py-1.5 hover:text-primary transition-colors tracking-wide">Find Tutors</a></li>
                    <li>
                        <a href="{{ route('ai-test.landing') }}" class="block font-semibold uppercase text-xs py-1.5 hover:text-primary transition-colors flex items-center gap-1 tracking-wide">
                            AI Exam Prep
                            <span class="bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full font-bold">NEW</span>
                        </a>
                    </li>
                    <li><a href="{{ route('about') }}" class="block font-semibold uppercase text-xs py-1.5 hover:text-primary transition-colors tracking-wide">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="block font-semibold uppercase text-xs py-1.5 hover:text-primary transition-colors tracking-wide">Contact</a></li>
                </ul>
                <div class="hidden lg:flex items-center gap-4">
                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 focus:outline-none">
                                <div class="w-10 h-10 rounded-full border border-gray-200 overflow-hidden ring-2 ring-transparent hover:ring-primary/20 transition-all">
                                    @if(auth()->check() && auth()->user()->profile_picture)
                                        @php $pp = auth()->user()->profile_picture; $ppUrl = \Illuminate\Support\Str::startsWith($pp, ['/storage','http']) ? asset(ltrim($pp,'/')) : asset('storage/'.$pp); @endphp
                                        <img src="{{ $ppUrl }}" class="w-full h-full object-cover" alt="Profile" />
                                    @else
                                        <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                                            <i class="bi bi-person-fill text-xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <i class="bi bi-chevron-down text-xs text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">
                                
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                </div>

                                <a href="{{ auth()->user()->isStudent() ? route('student.dashboard') : (auth()->user()->isTutor() ? route('tutor.dashboard') : (auth()->user()->isParent() ? route('parent.dashboard') : route('admin.dashboard'))) }}" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors">
                                    <i class="bi bi-grid-fill mr-2 text-gray-400"></i> Dashboard
                                </a>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                        <i class="bi bi-box-arrow-right mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold uppercase text-xs hover:text-primary transition-colors">
                            Log in
                        </a>
                        <a href="{{ route('register') }}" 
                           class="bg-black text-white rounded-full font-bold uppercase text-xs py-2.5 px-6 hover:bg-gray-800 hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                            Sign Up
                        </a>
                    @endauth
                </div>
            </div>
        </nav>

        <div x-show="mobileMenuOpen" x-transition @click.away="mobileMenuOpen = false" class="lg:hidden bg-white border-b-2 border-black shadow-lg p-4 space-y-4 absolute w-full top-full left-0">
            <a href="{{ route('tutors.search') }}" class="block font-semibold uppercase text-sm py-2 px-3 hover:bg-gray-100 rounded-lg">Find Tutors</a>
            <a href="{{ route('ai-test.landing') }}" class="block font-semibold uppercase text-sm py-2 px-3 hover:bg-gray-100 rounded-lg flex items-center gap-2">
                AI Exam Prep
                <span class="bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-sm">NEW</span>
            </a>
            <a href="{{ route('about') }}" class="block font-semibold uppercase text-sm py-2 px-3 hover:bg-gray-100 rounded-lg">About Us</a>
            <a href="{{ route('contact') }}" class="block font-semibold uppercase text-sm py-2 px-3 hover:bg-gray-100 rounded-lg">Contact</a>
            <hr class="border-t border-black/20 my-4">
            @auth
                <a href="{{ auth()->user()->isStudent() ? route('student.dashboard') : (auth()->user()->isTutor() ? route('tutor.dashboard') : (auth()->user()->isParent() ? route('parent.dashboard') : route('admin.dashboard'))) }}" class="block font-semibold uppercase text-sm py-2 px-3 hover:bg-gray-100 rounded-lg">
                    Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left font-semibold uppercase text-sm py-2 px-3 hover:bg-gray-100 rounded-lg">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block font-semibold uppercase text-sm py-2 px-3 hover:bg-gray-100 rounded-lg">
                    Log in
                </a>
                <a href="{{ route('register') }}" class="block text-center bg-accent-yellow border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 px-5 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                    Sign Up
                </a>
            @endauth
        </div>
    </div>

    @hasSection('full-width-content')
        @yield('full-width-content')
    @else
        <main class="max-w-6xl mx-auto px-4">
            @yield('content')
        </main>
    @endif


    @include('components.footer')

    @stack('scripts')
</body>
</html>