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
                        'hero-lg': '4.2rem',  // <-- For main homepage hero
                        'hero-md': '3rem',    // <-- For inner page heroes
                        'h2': '2.25rem',      // <-- For section titles
                        'h3': '1.5rem',       // <-- For card titles
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

    <div x-data="{ mobileMenuOpen: false }" class="sticky top-6 z-50">
        <div class="max-w-5xl mx-auto px-4">
            <nav class="flex items-center justify-between bg-white border-2 border-black rounded-xl py-2.5 px-6 shadow-header-chunky">
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center font-bold text-xl text-black group">
                    <i class="bi bi-mortarboard-fill text-accent-yellow text-2xl mr-2 transition-transform duration-300 group-hover:rotate-15"></i>
                    <span class="text-primary">HTC</span>
                </a>
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-lg hover:bg-gray-100">
                    <i class="bi bi-list text-3xl"></i>
                </button>
                <ul class="hidden lg:flex items-center mx-auto space-x-1">
                    <li><a href="{{ route('tutors.search') }}" class="block font-semibold uppercase text-xxs py-1.5 px-3 hover:text-primary transition-colors">Find Tutors</a></li>
                    <li><a href="{{ route('about') }}" class="block font-semibold uppercase text-xxs py-1.5 px-3 hover:text-primary transition-colors">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="block font-semibold uppercase text-xxs py-1.5 px-3 hover:text-primary transition-colors">Contact</a></li>
                </ul>
                <div class="hidden lg:flex items-center gap-3">
                    @auth
                        <a href="{{ auth()->user()->isStudent() ? route('student.dashboard') : (auth()->user()->isTutor() ? route('tutor.dashboard') : (auth()->user()->isParent() ? route('parent.dashboard') : route('admin.dashboard'))) }}" 
                           class="bg-accent-yellow border-2 border-black rounded-lg text-black font-bold uppercase text-xxs py-2 px-5 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="font-semibold uppercase text-xxs py-1.5 px-3 hover:text-primary">Logout</button>
                        </form>
                        <div class="w-10 h-10 rounded-full border-2 border-black bg-gray-200">
                            @if(auth()->check() && auth()->user()->profile_picture)
@php $pp = auth()->user()->profile_picture; $ppUrl = \Illuminate\Support\Str::startsWith($pp, ['/storage','http']) ? asset(ltrim($pp,'/')) : asset('storage/'.$pp); @endphp
                                <img src="{{ $ppUrl }}" class="w-full h-full rounded-full object-cover" alt="Profile" />
                            @else
                                <span class="flex items-center justify-center h-full text-black/60">
                                    <i class="bi bi-person-fill text-xl"></i>
                                </span>
                            @endif
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold uppercase text-xxs py-1.5 px-3 hover:text-primary">
                            Log in
                        </a>
                        <a href="{{ route('register') }}" 
                           class="bg-accent-yellow border-2 border-black rounded-lg text-black font-bold uppercase text-xxs py-2 px-5 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                            Sign Up
                        </a>
                    @endauth
                </div>
            </nav>

            <div x-show="mobileMenuOpen" x-transition @click.away="mobileMenuOpen = false" class="lg:hidden bg-white border-2 border-black rounded-xl shadow-header-chunky p-6 mt-3 space-y-4">
                <a href="{{ route('tutors.search') }}" class="block font-semibold uppercase text-sm py-2 px-3 hover:bg-gray-100 rounded-lg">Find Tutors</a>
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
    </div>

    <main class="max-w-6xl mx-auto px-4">
        @yield('content')
    </main>


    @include('components.footer')

    @stack('scripts')
</body>
</html>