<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login - TapClass</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <script>
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "primary": "#4F7EFF",
              "secondary": "#FFA500",
              "teal": "#5FB3A0",
            },
            fontFamily: { "sans": ["Inter", "sans-serif"] },
          },
        },
      }
    </script>
</head>
<body class="bg-white font-sans">
<div class="min-h-screen flex flex-col lg:flex-row">
    
    <!-- Left Panel - Form -->
    <div class="flex-1 flex items-center justify-center p-6 sm:p-12 lg:p-16">
        <div class="w-full max-w-md">
            <!-- Logo -->
            <div class="flex items-center gap-2 mb-12">
                <div class="w-10 h-10">
                    <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 4H17.3334V17.3334H30.6666V30.6666H44V44H4V4Z" fill="#4F7EFF"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">TapClass</h2>
            </div>

            <!-- Form Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Login</h1>
                <p class="text-gray-600">Welcome back! Please enter your details.</p>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                <ul class="text-sm text-red-600 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
            @endif

            @if(session('info'))
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                <p class="text-sm text-blue-600">{{ session('info') }}</p>
            </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="email">
                        Email Address
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required
                        class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 placeholder-gray-500 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                        placeholder="Enter your email"
                    />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="password">
                        Password
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 placeholder-gray-500 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                        placeholder="Enter your password"
                    />
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                    <a href="#" class="text-sm text-primary font-medium hover:underline">Forgot Password?</a>
                </div>

                <button 
                    type="submit"
                    class="w-full bg-primary text-white font-semibold py-3.5 px-4 rounded-xl hover:bg-primary/90 transition-colors shadow-sm"
                >
                    Log In
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-3 bg-white text-gray-500 font-medium">🔒 Secure Login</span>
                </div>
            </div>

            <!-- Google Sign In -->
            <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-3 px-4 py-3.5 border-2 border-gray-200 rounded-xl hover:bg-gray-50 transition-all group">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                <span class="text-gray-700 font-semibold">Sign in with Google</span>
            </a>

            <!-- Sign Up Link -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account? 
                    <a href="{{ route('register.tutor') }}" class="text-primary font-semibold hover:underline">Sign up as a Tutor</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Right Panel - Image Background with Text Overlay (Hidden on mobile) -->
    <div class="hidden lg:flex flex-1 relative overflow-hidden">
        <!-- Background Image -->
        <img src="{{ asset('svg/side.avif') }}" alt="Tutor Illustration" class="absolute inset-0 w-full h-full object-cover" />
        
        <!-- Dark Overlay for better text readability -->
        <div class="absolute inset-0 bg-black/40"></div>
        
        <!-- Text Content Overlay -->
        
    </div>

</div>
</body>
</html>
