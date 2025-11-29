<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login - htc Community</title>
    
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
                        'page-bg': '#fffcf0',       // Our new theme background
                        'footer-bg': '#334457',
                        'subscribe-bg': '#D1E3E6',
                        'steps-bg': '#b6e1e3',
                    },
                    fontFamily: {
                        'sans': ['Poppins', 'sans-serif'], // Poppins for body
                        'heading': ['Anton', 'sans-serif']  // Anton for titles
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
                        'h2': '2rem',
                    },
                    // Kept your animations
                    animation: {
                        'fade-in': 'fadeIn 0.6s ease-out',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'float': 'float 3s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                    }
                }
            }
        }
    </script>
    
    </head>

<body class="font-sans bg-page-bg">

<div class="min-h-screen flex flex-col lg:flex-row relative">
    
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-primary/5 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-primary/5 rounded-full blur-3xl animate-float" style="animation-delay: 1s;"></div>
    </div>
    
    <div class="hidden lg:flex flex-1 items-center justify-center p-8 relative z-10">
        <div class="flex flex-col items-center justify-center text-center animate-fade-in">
            
            <div class="relative w-full max-w-xs h-64 mb-6">
                <img src="{{ asset('images/login/Learning-bro.svg') }}" alt="Tutor Illustration" id="svg-tutor" class="absolute inset-0 w-full h-full object-contain transition-all duration-700 ease-in-out animate-float">
                <img src="{{ asset('images/login/tutor.svg') }}" alt="Student Illustration" id="svg-student" class="absolute inset-0 w-full h-full object-contain transition-all duration-700 ease-in-out opacity-0 scale-95 animate-float" style="animation-delay: 0.5s">
                <img src="{{ asset('images/homepage/parent.svg') }}" alt="Parent Illustration" id="svg-parent" class="absolute inset-0 w-full h-full object-contain transition-all duration-700 ease-in-out opacity-0 scale-95 animate-float" style="animation-delay: 1s;">
            </div>

            <div class="flex gap-3 mb-6">
                <div id="dot-0" class="carousel-dot w-3 h-3 rounded-full transition-all duration-300 cursor-pointer bg-accent-yellow border-2 border-black"></div>
                <div id="dot-1" class="carousel-dot w-3 h-3 rounded-full transition-all duration-300 cursor-pointer bg-gray-300"></div>
                <div id="dot-2" class="carousel-dot w-3 h-3 rounded-full transition-all duration-300 cursor-pointer bg-gray-300"></div>
            </div>

            <h2 class="font-heading text-h2 uppercase">Welcome to htc Community</h2>
            <p class="text-text-subtle max-w-sm">
                One unified platform connecting Tutors, Students, and Parents in a seamless learning experience.
            </p>

        </div>
    </div>

    <div class="flex-1 flex items-center justify-center p-6 sm:p-8 lg:p-12 relative z-10 min-h-screen">
        
        <div class="w-full max-w-sm bg-white border-2 border-black rounded-2xl shadow-header-chunky p-8 animate-slide-up">

            <div class="mb-6 text-center">
                <h1 class="font-heading text-2xl uppercase">Welcome Back</h1>
                <p class="text-sm text-text-subtle">Sign in to continue your journey</p>
            </div>

            @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-start gap-2 text-sm">
                    <i class="bi bi-exclamation-triangle-fill mt-0.5"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4 mb-6">
                @csrf
                @if(request()->has('redirect'))
                    <input type="hidden" name="redirect" value="{{ request('redirect') }}">
                @endif
                <div>
                    <label class="block text-xs font-bold text-black mb-1.5" for="email">
                        Email Address
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required
                        class="w-full bg-white border-2 border-black rounded-lg px-4 py-2.5 text-sm text-black placeholder:text-text-subtle focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary"
                        placeholder="you@example.com"
                    />
                    @error('email')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-black mb-1.5" for="password">
                        Password
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        class="w-full bg-white border-2 border-black rounded-lg px-4 py-2.5 text-sm text-black placeholder:text-text-subtle focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary"
                        placeholder="••••••••"
                    />
                    @error('password')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary">
                        <span class="ml-2 text-text-subtle group-hover:text-black transition-colors">Remember me</span>
                    </label>
<a href="{{ route('password.forgot') }}" class="text-primary font-semibold hover:text-primary transition-colors">Forgot Password?</a>
                </div>

                <button 
                    type="submit"
                    class="w-full bg-accent-yellow border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-2.5 px-6 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active"
                >
                    Sign In
                </button>
            </form>

            <div class="relative my-5">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-black/20"></div>
                </div>
                <div class="relative flex justify-center text-xs">
                    <span class="px-3 bg-white text-text-subtle font-medium">Or continue with</span>
                </div>
            </div>

            <a href="{{ route('auth.google', ['role' => 'student', 'redirect' => request('redirect')]) }}" 
               class="w-full flex items-center justify-center gap-2.5 px-4 py-2.5 border-2 border-black rounded-lg bg-white shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active group">
                <svg class="w-4 h-4" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                <span class="text-sm text-black font-semibold">Sign in with Google</span>
            </a>

            <div class="mt-6 text-center">
                <p class="text-xs text-text-subtle">
                    Don't have an account? 
                    <a href="{{ route('register.tutor') }}" class="text-primary font-semibold hover:underline">Sign up as a Tutor</a>,
                    <a href="{{ route('register.student') }}" class="text-primary font-semibold hover:underline">Student</a>,
                    or <a href="{{ route('register.parent') }}" class="text-primary font-semibold hover:underline">Parent</a>
                </p>
            </div>
            
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const svgs = [
            document.getElementById('svg-tutor'),
            document.getElementById('svg-student'),
            document.getElementById('svg-parent')
        ];
        
        const dots = [
            document.getElementById('dot-0'),
            document.getElementById('dot-1'),
            document.getElementById('dot-2')
        ];
        
        let currentIndex = 0;
        const totalSlides = svgs.length;

        function showSlide(index) {
            svgs.forEach((svg, i) => {
                if (svg) { // Check if element exists
                    if (i === index) {
                        svg.classList.remove('opacity-0', 'scale-95');
                        svg.classList.add('opacity-100', 'scale-100');
                    } else {
                        svg.classList.add('opacity-0', 'scale-95');
                        svg.classList.remove('opacity-100', 'scale-100');
                    }
                }
            });
            
            // Updated to toggle our new theme classes
            dots.forEach((dot, i) => {
                if (dot) { // Check if element exists
                    if (i === index) {
                        dot.classList.add('bg-accent-yellow', 'border-2', 'border-black');
                        dot.classList.remove('bg-gray-300');
                    } else {
                        dot.classList.remove('bg-accent-yellow', 'border-2', 'border-black');
                        dot.classList.add('bg-gray-300');
                    }
                }
            });
        }

        setInterval(() => {
            currentIndex = (currentIndex + 1) % totalSlides;
            showSlide(currentIndex);
        }, 3000);
        
        dots.forEach((dot, index) => {
            if (dot) { // Check if element exists
                dot.addEventListener('click', () => {
                    currentIndex = index;
                    showSlide(currentIndex);
                });
            }
        });
    });
</script>

</body>
</html>