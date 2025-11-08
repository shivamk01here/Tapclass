<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Tutor Registration - Htc</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
      tailwind.config = {
        darkMode: 'class',
        theme: {
          extend: {
            colors: {
              primary: '#13a4ec',
              secondary: '#FFA500',
              'background-light': '#f6f7f8',
              'background-dark': '#101c22'
            },
            fontFamily: { display: ['Manrope', 'sans-serif'] },
            boxShadow: {
              brand: '0 10px 25px -5px rgba(19,164,236,0.25), 0 8px 10px -6px rgba(19,164,236,0.3)'
            }
          }
        }
      };
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display">

<div class="min-h-screen w-full grid grid-cols-1 lg:grid-cols-2">

    <div class="w-full p-8 sm:p-12 lg:py-10 lg:px-16 flex flex-col justify-center bg-white dark:bg-background-dark" data-aos="fade-in" data-aos-delay="100">
        
        <div class="text-center lg:text-left mb-6">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-primary mb-4">
                <h2 class="text-2xl font-bold">HTC</h2>
            </a>
            <h1 class="text-3xl font-black text-gray-900 dark:text-white">Become a Tutor</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Create your account to continue</p>
        </div>

        @if($errors->any())
        <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg">
            <ul class="text-sm text-red-600 dark:text-red-300 space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(!session('google_auth'))
        <div class="mb-6">
            <a href="{{ route('auth.google', ['role' => 'tutor']) }}" class="w-full flex items-center justify-center gap-3 px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                <span class="text-gray-700 dark:text-gray-300 font-bold">Register with Google</span>
            </a>

            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white dark:bg-background-dark text-gray-500">Or register with email</span>
                </div>
            </div>
        </div>
        @else
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg flex items-center justify-between">
            <p class="text-sm text-green-700 dark:text-green-300">Connected with Google! We'll use your Google name and email.</p>
            </div>
        @endif

        <form method="POST" action="{{ route('register.tutor') }}" id="register-form">
            @csrf
            @if(session('google_auth'))
            <input type="hidden" name="google_auth" value="1">
            @endif

            @php $googleData = session('google_user_data'); @endphp

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name *</label>
                    <input type="text" name="name" value="{{ old('name', $googleData['name'] ?? '') }}" {{ session('google_auth') ? 'readonly' : 'required' }} class="w-full rounded-lg border border-gray-300 dark:border-gray-600 {{ session('google_auth') ? 'bg-gray-100 dark:bg-gray-700' : 'bg-white dark:bg-gray-800' }} px-4 py-2.5 text-gray-900 dark:text-white focus:border-primary focus:ring-primary" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email *</label>
                    <input type="email" name="email" value="{{ old('email', $googleData['email'] ?? '') }}" {{ session('google_auth') ? 'readonly' : 'required' }} class="w-full rounded-lg border border-gray-300 dark:border-gray-600 {{ session('google_auth') ? 'bg-gray-100 dark:bg-gray-700' : 'bg-white dark:bg-gray-800' }} px-4 py-2.5 text-gray-900 dark:text-white focus:border-primary focus:ring-primary" />
                </div>
                @unless(session('google_auth'))
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password *</label>
                        <input type="password" name="password" required class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2.5 text-gray-900 dark:text-white focus:border-primary focus:ring-primary" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm Password *</label>
                        <input type="password" name="password_confirmation" required class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2.5 text-gray-900 dark:text-white focus:border-primary focus:ring-primary" />
                    </div>
                </div>
                @endunless
            </div>

            <div class="flex justify-end items-center mt-8">
                <button type="submit" class="w-full md:w-auto px-6 py-2.5 bg-primary text-white font-semibold rounded-lg hover:shadow-brand hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                    <span>@if(session('google_auth')) Continue @else Create account @endif</span>
                    <span class="material-symbols-outlined text-xl">arrow_forward</span>
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Already have an account? <a href="{{ route('login') }}" class="text-primary font-medium hover:underline">Login</a>
            </p>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Want to learn? <a href="{{ route('register.student') }}" class="text-secondary font-medium hover:underline">Register as Student</a>
            </p>
        </div>
    </div>

    <div class="hidden lg:flex flex-col justify-center p-12 relative min-h-screen bg-secondary/5 dark:bg-secondary/10" 
         data-aos="fade-in">
        
        <div class="relative z-10">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mb-6 text-secondary">
                <h2 class="text-2xl font-bold">Htc</h2>
            </a>
            
            <h2 class="text-4xl font-black mb-4 leading-tight text-gray-900 dark:text-white">
                Share your <br>knowledge.
            </h2>
            <p class="text-lg mb-8 text-gray-600 dark:text-gray-300">
                Join our community of expert tutors and make a real impact on students' lives.
            </p>
            <ul class="space-y-4">
                <li class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-secondary">check_circle</span>
                    <span class="text-gray-700 dark:text-gray-200">Teach on your own schedule</span>
                </li>
                <li class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-secondary">check_circle</span>
                    <span class="text-gray-700 dark:text-gray-200">Access a wide student base</span>
                </li>
                <li class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-secondary">check_circle</span>
                    <span class="text-gray-700 dark:text-gray-200">Simple, secure payments</span>
                </li>
            </ul>

            <div class="mt-12 w-full max-w-md mx-auto">
                
            </div>
            
        </div>
        <div class="absolute -bottom-16 -left-16 size-48 bg-secondary/10 dark:bg-secondary/20 rounded-full blur-3xl opacity-50 z-0"></div>
    </div>

</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    if (window.AOS) AOS.init({ duration: 600, easing: 'ease-out', once: true });
  });
</script>
</body>
</html>