<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Htc - Find Your Perfect Tutor')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "primary": "#13a4ec",
              "secondary": "#FFA500",
              "background-light": "#f6f7f8",
              "background-dark": "#101c22",
            },
            fontFamily: { "display": ["Manrope", "sans-serif"] },
            borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
          },
        },
      }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-gray-900 dark:text-gray-100">
    
    <nav class="bg-white dark:bg-background-dark border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-2 text-primary">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 4H17.3334V17.3334H30.6666V30.6666H44V44H4V4Z" fill="currentColor"></path>
                    </svg>
                    <span class="text-xl font-bold">Htc</span>
                </a>

                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('tutors.search') }}" class="text-gray-700 dark:text-gray-300 hover:text-primary font-medium transition-colors">Find Tutors</a>
                    <a href="{{ route('about') }}" class="text-gray-700 dark:text-gray-300 hover:text-primary font-medium transition-colors">About Us</a>
                    <a href="{{ route('contact') }}" class="text-gray-700 dark:text-gray-300 hover:text-primary font-medium transition-colors">Contact</a>
                </div>

                <div class="hidden md:flex items-center gap-4">
                    @auth
                        <a href="{{ auth()->user()->isStudent() ? route('student.dashboard') : (auth()->user()->isTutor() ? route('tutor.dashboard') : route('admin.dashboard')) }}" class="px-5 py-2 bg-primary text-white rounded-lg font-bold hover:bg-primary/90 transition-colors">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2 text-gray-700 dark:text-gray-300 font-medium hover:text-primary transition-colors">Log in</a>
                        <a href="{{ route('register.student') }}" class="px-5 py-2 bg-primary text-white rounded-lg font-bold hover:bg-primary/90 transition-colors">Sign Up</a>
                    @endauth
                    
                    <div class="w-10 h-10 rounded-full bg-secondary flex items-center justify-center">
                        @if(auth()->check() && auth()->user()->profile_picture)
                            <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" class="w-10 h-10 rounded-full object-cover" alt="Profile" />
                        @else
                            <span class="material-symbols-outlined text-white">person</span>
                        @endif
                    </div>
                </div>

                <button id="mobile-menu-btn" class="md:hidden text-gray-700 dark:text-gray-300 hover:text-primary">
                    <span class="material-symbols-outlined text-3xl">menu</span>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-background-dark">
            <div class="px-4 py-4 space-y-3">
                <a href="{{ route('tutors.search') }}" class="block text-gray-700 dark:text-gray-300 hover:text-primary font-medium transition">
                    Find Tutors
                </a>
                <a href="{{ route('about') }}" class="block text-gray-700 dark:text-gray-300 hover:text-primary font-medium transition">
                    About Us
                </a>
                <a href="{{ route('contact') }}" class="block text-gray-700 dark:text-gray-300 hover:text-primary font-medium transition">
                    Contact
                </a>
                
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4 space-y-3">
                    @auth
                        @if(auth()->user()->isStudent())
                            <a href="{{ route('student.dashboard') }}" class="block text-gray-700 dark:text-gray-300 hover:text-primary font-medium transition">
                                Dashboard
                            </a>
                        @elseif(auth()->user()->isTutor())
                            <a href="{{ route('tutor.dashboard') }}" class="block text-gray-700 dark:text-gray-300 hover:text-primary font-medium transition">
                                Dashboard
                            </a>
                        @elseif(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="block text-gray-700 dark:text-gray-300 hover:text-primary font-medium transition">
                                Admin
                            </a>
                        @endif
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left text-gray-700 dark:text-gray-300 hover:text-primary font-medium transition">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block text-gray-700 dark:text-gray-300 hover:text-primary font-medium transition">
                            Login
                        </a>
                        <a href="{{ route('register.student') }}" class="block px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 font-medium text-center transition">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 text-primary">
                            <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 4H17.3334V17.3334H30.6666V30.6666H44V44H4V4Z" fill="currentColor"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold">Htc</span>
                    </div>
                    <p class="text-gray-400 text-sm">
                        Connecting students with qualified tutors for personalized learning experiences.
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('tutors.search') }}" class="hover:text-white transition">Find Tutors</a></li>
                        <li><a href="{{ route('register.student') }}" class="hover:text-white transition">Become a Student</a></li>
                        <li><a href="{{ route('register.tutor') }}" class="hover:text-white transition">Become a Tutor</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Company</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('about') }}" class="hover:text-white transition">About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white transition">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Legal</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('privacy') }}" class="hover:text-white transition">Privacy Policy</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-white transition">Terms & Conditions</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} Htc. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>

    @stack('scripts')
</body>
</html>