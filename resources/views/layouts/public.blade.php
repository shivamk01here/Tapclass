<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'htc - Find Your Perfect Tutor')</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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
                        'steps-bg': '#b6e1e3',
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
                    spacing: { '0.5': '2px', '1': '4px', },
                    fontSize: {
                        'xxs': '0.825rem',
                        'hero-lg': '4.2rem',  // For main homepage
                        'hero-md': '2.5rem',  // <-- MADE SMALLER (was 3rem)
                        'h2': '2rem',         // <-- MADE SMALLER (was 2.25rem)
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

    <div x-data="{ mobileMenuOpen: false }" class="sticky top-6 z-50">
        <div class="max-w-6xl mx-auto px-4"> 
            <nav class="flex items-center justify-between bg-white border-2 border-black rounded-xl py-2.5 px-6 shadow-header-chunky">
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center font-bold text-xl text-black group">
                    <i class="bi bi-mortarboard-fill text-accent-yellow text-2xl mr-2 transition-transform duration-300 group-hover:rotate-15"></i>
                    htc<span class="text-primary"></span>
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
                        @else
                        <a href="{{ route('login') }}" class="font-semibold uppercase text-xxs py-1.5 px-3 hover:text-primary">
                            Log in
                        </a>
                        <a href="{{ route('register') }}" 
                           class="bg-accent-yellow border-2 border-black rounded-lg text-black font-bold uppercase text-xxs py-2 px-5 shadow-button-chunky ...">
                            Sign Up
                        </a>
                    @endauth
                </div>
            </nav>

            <div x-show="mobileMenuOpen" x-transition @click.away="mobileMenuOpen = false" class="lg:hidden bg-white border-2 border-black rounded-xl shadow-header-chunky p-6 mt-3 space-y-4">
                </div>
        </div>
    </div>

    <main class="max-w-6xl mx-auto px-4">
        @yield('content')
    </main>

   
    <footer class="bg-footer-bg text-gray-300 pt-16">
        <div class="max-w-6xl mx-auto px-4"> 
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-8">
                <div class="md:col-span-3 lg:col-span-2">
                    <a href="{{ route('home') }}" class="flex items-center font-bold text-xl text-white group">
                        <i class="bi bi-mortarboard-fill text-accent-yellow text-2xl mr-2"></i>
                        htc
                    </a>
                    <p class="my-4 max-w-xs text-sm leading-relaxed">
                        Connecting students with qualified tutors for personalized learning experiences.
                    </p>
                    </div>
                </div> 
            <div class="mt-12 pt-6 border-t border-gray-200/20">
                <div class="flex flex-col sm:flex-row justify-between items-center">
                    <p class="text-sm text-gray-400">&copy; {{ date('Y') }} htc. All rights reserved.</p>
                    </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>