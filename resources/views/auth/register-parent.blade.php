<!DOCTYPE html>
<html class="light" lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>Parent Registration - Htc</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: { 
        extend: { 
          colors: { 
            primary: '#0071b2', 
            secondary: '#FFA500', 
            'background-light': '#f6f7f8', 
            'background-dark': '#101c22' 
          }, 
          fontFamily: { 
            display: ['Manrope','sans-serif'] 
          } 
        } 
      }
    };
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
</head>
<body class="bg-background-light dark:bg-background-dark font-display overflow-hidden">
  <div class="h-screen w-full grid grid-cols-1 lg:grid-cols-2">
    
    <!-- Left Side - Illustration (Previously Right) -->
    <div class="hidden lg:flex flex-col justify-center items-center p-16 relative bg-gradient-to-br from-primary/5 via-secondary/5 to-primary/10 dark:from-primary/10 dark:via-secondary/10 dark:to-primary/20 overflow-hidden">
      <div class="absolute top-8 left-8 z-20 hero-logo">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2">
          <h2 class="text-xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">Htc</h2>
        </a>
      </div>
      
      <!-- Floating Background Elements -->
      <div class="floating-circle absolute top-20 right-20 w-32 h-32 bg-primary/10 rounded-full blur-2xl"></div>
      <div class="floating-circle-2 absolute bottom-32 left-16 w-40 h-40 bg-secondary/10 rounded-full blur-3xl"></div>
      <div class="floating-circle-3 absolute top-1/2 left-1/4 w-24 h-24 bg-primary/5 rounded-full blur-xl"></div>
      
      <div class="relative z-10 text-center max-w-lg hero-content">
        <!-- SVG Illustration will go here -->
        
        <h2 class="text-4xl font-black mb-4 leading-tight text-gray-900 dark:text-white">Manage learning<br/>for your child.</h2>
        <p class="text-lg mb-8 text-gray-600 dark:text-gray-300">Add learners, book tutors, and track progress from one place.</p>
      
        
        <div class="mt-10 flex items-center justify-center gap-8 features">
          <div class="text-center feature-item">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mx-auto mb-2">
              <span class="material-symbols-outlined text-primary text-2xl">verified</span>
            </div>
            <p class="text-xs font-medium text-gray-700 dark:text-gray-300">Verified Tutors</p>
          </div>
          <div class="text-center feature-item">
            <div class="w-12 h-12 bg-secondary/10 rounded-xl flex items-center justify-center mx-auto mb-2">
              <span class="material-symbols-outlined text-secondary text-2xl">schedule</span>
            </div>
            <p class="text-xs font-medium text-gray-700 dark:text-gray-300">Flexible Hours</p>
          </div>
          <div class="text-center feature-item">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mx-auto mb-2">
              <span class="material-symbols-outlined text-primary text-2xl">trending_up</span>
            </div>
            <p class="text-xs font-medium text-gray-700 dark:text-gray-300">Track Progress</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Side - Form (Previously Left) -->
    <div class="w-full p-8 lg:p-12 flex flex-col justify-center bg-white dark:bg-background-dark overflow-y-auto">
      <div class="max-w-md mx-auto w-full">
        
        <div class="text-left mb-6 form-header">
          <div class="lg:hidden mb-4">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2">
              <h2 class="text-xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">Htc</h2>
            </a>
          </div>
          <h1 class="text-2xl font-black text-gray-900 dark:text-white mb-1">Create Your Account</h1>
          <p class="text-xs text-gray-500 dark:text-gray-400">Start managing your child's learning today</p>
        </div>

        @if($errors->any())
        <div class="mb-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg error-alert">
          <ul class="text-xs text-red-600 dark:text-red-300 space-y-1">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        @if(!session('google_auth'))
        <div class="mb-5 google-button">
          <a href="{{ route('auth.google', ['role' => 'parent']) }}" class="w-full flex items-center justify-center gap-3 px-4 py-2.5 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-all duration-300 hover:shadow-md group">
            <svg class="w-4 h-4" viewBox="0 0 24 24">
              <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
              <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
              <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
              <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            <span class="text-sm text-gray-700 dark:text-gray-300 font-medium group-hover:text-gray-900 dark:group-hover:text-white">Continue with Google</span>
          </a>
          <div class="relative my-5">
            <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200 dark:border-gray-700"></div></div>
            <div class="relative flex justify-center text-xs"><span class="px-3 bg-white dark:bg-background-dark text-gray-400">or</span></div>
          </div>
        </div>
        @else
        <div class="mb-5 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg success-alert">
          <p class="text-xs text-green-700 dark:text-green-300 flex items-center gap-2">
            <span class="material-symbols-outlined text-base">check_circle</span>
            Connected with Google successfully!
          </p>
        </div>
        @endif

        @php $googleData = session('google_user_data'); @endphp

        <form method="POST" action="{{ route('register.parent') }}" class="space-y-4 registration-form">
          @csrf
          @if(session('google_auth'))
            <input type="hidden" name="google_auth" value="1">
          @endif
          
          <div class="form-field">
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Full Name</label>
            <input type="text" name="name" value="{{ old('name', $googleData['name'] ?? '') }}" {{ session('google_auth') ? 'readonly' : 'required' }} class="w-full rounded-lg border border-gray-200 dark:border-gray-700 {{ session('google_auth') ? 'bg-gray-50 dark:bg-gray-800' : 'bg-white dark:bg-gray-900' }} px-3.5 py-2 text-sm text-gray-900 dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" placeholder="John Doe" />
          </div>
          
          <div class="form-field">
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Email Address</label>
            <input type="email" name="email" value="{{ old('email', $googleData['email'] ?? '') }}" {{ session('google_auth') ? 'readonly' : 'required' }} class="w-full rounded-lg border border-gray-200 dark:border-gray-700 {{ session('google_auth') ? 'bg-gray-50 dark:bg-gray-800' : 'bg-white dark:bg-gray-900' }} px-3.5 py-2 text-sm text-gray-900 dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" placeholder="john@example.com" />
          </div>
          
          @unless(session('google_auth'))
          <div class="grid grid-cols-2 gap-3">
            <div class="form-field">
              <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Password</label>
              <input type="password" name="password" required class="w-full rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3.5 py-2 text-sm text-gray-900 dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" placeholder="••••••••" />
            </div>
            <div class="form-field">
              <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Confirm</label>
              <input type="password" name="password_confirmation" required class="w-full rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3.5 py-2 text-sm text-gray-900 dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" placeholder="••••••••" />
            </div>
          </div>
          @endunless
          
          <div class="pt-2 submit-button">
            <button type="submit" class="w-full px-5 py-2.5 bg-gradient-to-r from-primary to-primary/90 text-white text-sm font-semibold rounded-lg hover:shadow-lg hover:shadow-primary/25 hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2 group">
              <span>@if(session('google_auth')) Continue @else Create Account @endif</span>
              <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </button>
          </div>
        </form>

        <div class="mt-5 text-center footer-text">
          <p class="text-xs text-gray-500 dark:text-gray-400">
            Already have an account? 
            <a href="{{ route('login') }}" class="text-primary font-semibold hover:underline ml-1">Sign in</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <script>
    // GSAP Animations
    gsap.registerPlugin();

    // Animate form elements on load
    window.addEventListener('DOMContentLoaded', () => {
      const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });

      // Form side animations
      tl.from('.form-header', {
        y: 30,
        opacity: 0,
        duration: 0.8
      })
      .from('.google-button, .success-alert, .error-alert', {
        y: 20,
        opacity: 0,
        duration: 0.6
      }, '-=0.4')
      .from('.form-field', {
        y: 20,
        opacity: 0,
        duration: 0.5,
        stagger: 0.1
      }, '-=0.3')
      .from('.submit-button', {
        y: 20,
        opacity: 0,
        duration: 0.6
      }, '-=0.2')
      .from('.footer-text', {
        opacity: 0,
        duration: 0.5
      }, '-=0.3');

      // Hero side animations
      gsap.from('.hero-logo', {
        y: -20,
        opacity: 0,
        duration: 0.8,
        ease: 'power3.out'
      });

      gsap.from('.svg-container', {
        scale: 0.8,
        opacity: 0,
        duration: 1,
        ease: 'back.out(1.2)',
        delay: 0.3
      });

      gsap.from('.hero-content h2', {
        y: 30,
        opacity: 0,
        duration: 0.8,
        delay: 0.5
      });

      gsap.from('.hero-content p', {
        y: 20,
        opacity: 0,
        duration: 0.8,
        delay: 0.7
      });

      gsap.from('.feature-item', {
        y: 30,
        opacity: 0,
        duration: 0.6,
        stagger: 0.15,
        delay: 0.9
      });

      // Floating animations for background elements
      gsap.to('.floating-circle', {
        y: -30,
        x: 20,
        duration: 4,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut'
      });

      gsap.to('.floating-circle-2', {
        y: 25,
        x: -15,
        duration: 5,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut'
      });

      gsap.to('.floating-circle-3', {
        y: -20,
        x: 15,
        duration: 3.5,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut'
      });

      // Input focus animations
      document.querySelectorAll('input').forEach(input => {
        input.addEventListener('focus', function() {
          gsap.to(this, {
            scale: 1.02,
            duration: 0.2,
            ease: 'power2.out'
          });
        });

        input.addEventListener('blur', function() {
          gsap.to(this, {
            scale: 1,
            duration: 0.2,
            ease: 'power2.out'
          });
        });
      });
    });
  </script>
</body>
</html>