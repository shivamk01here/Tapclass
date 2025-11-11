<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login - Htc Community</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script>
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "primary": "#0071b2",
              "primary-dark": "#005a8f",
              "primary-light": "#e6f4fb",
              "background-light": "#fafbfc",
              "background-dark": "#0a1929",
            },
            fontFamily: { 
              "sans": ["Inter", "sans-serif"] 
            },
            animation: {
              'fade-in': 'fadeIn 0.6s ease-out',
              'slide-up': 'slideUp 0.6s ease-out',
              'float': 'float 3s ease-in-out infinite',
              'glow': 'glow 2s ease-in-out infinite alternate',
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
              glow: {
                '0%': { boxShadow: '0 0 20px rgba(0, 113, 178, 0.3)' },
                '100%': { boxShadow: '0 0 30px rgba(0, 113, 178, 0.5)' },
              }
            }
          },
        },
      }
    </script>
    
    <style>
      body {
        background: linear-gradient(135deg, #fafbfc 0%, #e6f4fb 100%);
      }
      
      .glass-effect {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.8);
      }
      
      .carousel-dot.active {
        background: linear-gradient(135deg, #0071b2, #005a8f);
        transform: scale(1.4);
        box-shadow: 0 0 15px rgba(0, 113, 178, 0.5);
      }
      
      .input-focus {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      }
      
      .input-focus:focus {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 113, 178, 0.15);
      }
      
      .btn-premium {
        background: linear-gradient(135deg, #0071b2 0%, #005a8f 100%);
        box-shadow: 0 4px 15px rgba(0, 113, 178, 0.3);
        transition: all 0.3s ease;
      }
      
      .btn-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 113, 178, 0.4);
      }
      
      .btn-premium:active {
        transform: translateY(0);
      }
      
      .svg-container {
        filter: drop-shadow(0 10px 30px rgba(0, 113, 178, 0.2));
      }
      
      @keyframes shimmer {
        0% { background-position: -1000px 0; }
        100% { background-position: 1000px 0; }
      }
      
      .shimmer {
        background: linear-gradient(90deg, transparent, rgba(0, 113, 178, 0.1), transparent);
        background-size: 1000px 100%;
        animation: shimmer 2s infinite;
      }
      
      .gradient-text {
        background: linear-gradient(135deg, #0071b2, #005a8f);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
      }
    </style>
</head>

<body class="font-sans overflow-hidden">

<div class="h-screen flex flex-col lg:flex-row relative">
    
    <!-- Decorative background elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-primary/5 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-primary/5 rounded-full blur-3xl animate-float" style="animation-delay: 1s;"></div>
    </div>
    
    <!-- Left Panel - Carousel -->
    <div class="hidden lg:flex flex-1 items-center justify-center p-8 relative z-10">
        <div class="flex flex-col items-center justify-center text-center animate-fade-in">
            
            <div class="relative w-full max-w-xs h-64 mb-6 svg-container">
                <img src="{{ asset('images/login/Learning-bro.svg') }}" alt="Tutor Illustration" id="svg-tutor" class="absolute inset-0 w-full h-full object-contain transition-all duration-700 ease-in-out animate-float">
                
                <img src="{{ asset('images/login/tutor.svg') }}" alt="Student Illustration" id="svg-student" class="absolute inset-0 w-full h-full object-contain transition-all duration-700 ease-in-out opacity-0 scale-95">
                
                <img src="{{ asset('images/homepage/parent.svg') }}" alt="Parent Illustration" id="svg-parent" class="absolute inset-0 w-full h-full object-contain transition-all duration-700 ease-in-out opacity-0 scale-95">
            </div>

            <div class="flex gap-2 mb-6">
                <div id="dot-0" class="carousel-dot active w-2 h-2 bg-gray-300 rounded-full transition-all duration-300 cursor-pointer"></div>
                <div id="dot-1" class="carousel-dot w-2 h-2 bg-gray-300 rounded-full transition-all duration-300 cursor-pointer"></div>
                <div id="dot-2" class="carousel-dot w-2 h-2 bg-gray-300 rounded-full transition-all duration-300 cursor-pointer"></div>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mb-2 gradient-text">Welcome to HTC Community</h2>
            <p class="text-sm text-gray-600 max-w-sm">One unified platform connecting Tutors, Students, and Parents in a seamless learning experience.</p>

        </div>
    </div>

    <!-- Right Panel - Login Form -->
    <div class="flex-1 flex items-center justify-center p-6 sm:p-8 lg:p-12 relative z-10">
        <div class="w-full max-w-sm glass-effect rounded-3xl shadow-2xl p-8 animate-slide-up">

            <div class="mb-6 text-center">
                <h1 class="text-2xl font-bold text-gray-900 mb-1 gradient-text">Welcome Back</h1>
                <p class="text-sm text-gray-600">Sign in to continue your journey</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-4 mb-6">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5" for="email">
                        Email Address
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required
                        class="input-focus w-full rounded-xl border-2 border-gray-200 bg-white/80 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-primary focus:ring-4 focus:ring-primary/10 focus:outline-none"
                        placeholder="you@example.com"
                    />
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5" for="password">
                        Password
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        class="input-focus w-full rounded-xl border-2 border-gray-200 bg-white/80 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-primary focus:ring-4 focus:ring-primary/10 focus:outline-none"
                        placeholder="••••••••"
                    />
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-3.5 h-3.5 rounded border-gray-300 text-primary focus:ring-primary transition-all">
                        <span class="ml-2 text-gray-600 group-hover:text-gray-900 transition-colors">Remember me</span>
                    </label>
                    <a href="{{ route('contact') }}" class="text-primary font-semibold hover:text-primary-dark transition-colors">Forgot Password?</a>
                </div>

                <button 
                    type="submit"
                    class="btn-premium w-full text-white font-semibold py-2.5 px-4 rounded-xl text-sm"
                >
                    Sign In
                </button>
            </form>

            <div class="relative my-5">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-xs">
                    <span class="px-3 bg-white text-gray-500 font-medium">Or continue with</span>
                </div>
            </div>

            <a href="{{ route('auth.google', ['role' => 'student']) }}" class="w-full flex items-center justify-center gap-2.5 px-4 py-2.5 border-2 border-gray-200 rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all group">
                <svg class="w-4 h-4" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                <span class="text-sm text-gray-700 font-semibold">Sign in with Google</span>
            </a>

            <div class="mt-6 text-center">
                <p class="text-xs text-gray-600">
                    Don't have an account? 
                    <a href="{{ route('register.tutor') }}" class="text-primary font-semibold hover:text-primary-dark transition-colors">Sign up as a Tutor</a>,
                    <a href="{{ route('register.student') }}" class="text-primary font-semibold hover:text-primary-dark transition-colors">Student</a>,
                    or <a href="{{ route('register.parent') }}" class="text-primary font-semibold hover:text-primary-dark transition-colors">Parent</a>
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
            // Hide all SVGs and deactivate all dots
            svgs.forEach((svg, i) => {
                if (i === index) {
                    svg.classList.remove('opacity-0', 'scale-95');
                    svg.classList.add('opacity-100', 'scale-100');
                } else {
                    svg.classList.add('opacity-0', 'scale-95');
                    svg.classList.remove('opacity-100', 'scale-100');
                }
            });
            
            dots.forEach((dot, i) => {
                if (i === index) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        }

        // Auto-rotate carousel
        setInterval(() => {
            currentIndex = (currentIndex + 1) % totalSlides;
            showSlide(currentIndex);
        }, 3000);
        
        // Click handlers for dots
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentIndex = index;
                showSlide(currentIndex);
            });
        });
        
        // Input animations
        const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('shimmer');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('shimmer');
            });
        });
    });
</script>

</body>
</html>