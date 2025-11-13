<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Tutor Registration - htc</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <script>
    tailwind.config = {
        darkMode: 'class',
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
                    'sans': ['Poppins','sans-serif'],
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
                    'hero-lg': '4.2rem',
                    'hero-md': '2.5rem',
                    'h2': '2rem',
                    'h3': '1.5rem',
                }
            } 
        }
    };
    </script>
    
</head>
<body class="bg-page-bg font-sans text-black overflow-hidden">
    <div class="h-screen w-full grid grid-cols-1 lg:grid-cols-2">
    
    <div class="hidden lg:flex flex-col justify-center p-12 relative h-screen">
            <div class="absolute inset-0 bg-footer-bg z-0"></div>
            
            <div class="relative z-10 text-white">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mb-6">
                    <div class="size-8 text-accent-yellow">
                        <i class="bi bi-mortarboard-fill text-3xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold">htc</h2>
                </a>
                
                <h2 class="font-heading text-hero-md uppercase mb-4 leading-tight">
                    Share Your <br> knowledge.
                </h2>
                <p class="text-base mb-8 opacity-90">
                Join our community of expert tutors and make a real impact on students' lives.
                </p>
                <ul class="space-y-3">
                    <li class="flex items-center gap-3">
                        <i class="bi bi-check-circle-fill text-accent-yellow"></i>
                        <span>Set your own schedule</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="bi bi-check-circle-fill text-accent-yellow"></i>
                        <span>Reach thousands of students</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="bi bi-check-circle-fill text-accent-yellow"></i>
                        <span>Simple & secure payouts</span>
                    </li>
                </ul>
            </div>
            
            <div class="absolute -bottom-16 -right-16 size-48 bg-white/10 rounded-full blur-3xl opacity-50 z-0"></div>
        </div>

    <div class="w-full p-8 lg:p-12 flex flex-col justify-center bg-page-bg overflow-y-auto">
        <div class="max-w-md mx-auto w-full">
        
            <div class="text-left mb-6 form-header">
                <div class="lg:hidden mb-4">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-primary">
                        <i class="bi bi-mortarboard-fill text-accent-yellow text-2xl"></i>
                        <h2 class="text-xl font-bold">htc</h2>
                    </a>
                </div>
                <h1 class="font-heading text-h2 uppercase text-black mb-1">Become a Tutor</h1>
                <p class="text-sm text-text-subtle">Create your account to start teaching</p>
            </div>

            @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg error-alert">
                <ul class="text-xs text-red-600 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
            @endif

            @if(!session('google_auth'))
            <div class="mb-5 google-button">
                <a href="{{ route('auth.google', ['role' => 'tutor']) }}" class="w-full flex items-center justify-center gap-3 px-4 py-2.5 border-2 border-black rounded-lg bg-white shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active group">
                    <svg class="w-4 h-4" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    <span class="text-sm text-black font-medium">Continue with Google</span>
                </a>
                <div class="relative my-5">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-black/20"></div></div>
                    <div class="relative flex justify-center text-xs"><span class="px-3 bg-page-bg text-text-subtle">or</span></div>
                </div>
            </div>
            @else
            <div class="mb-5 p-3 bg-green-50 border border-green-200 rounded-lg success-alert">
                <p class="text-xs text-green-700 flex items-center gap-2">
                    <i class="bi bi-check-circle-fill text-base"></i>
                    Connected with Google successfully!
                </p>
            </div>
            @endif

            @php $googleData = session('google_user_data'); @endphp

            <form method="POST" action="{{ route('register.tutor') }}" class="space-y-4 registration-form">
                @csrf
                @if(session('google_auth'))
                    <input type="hidden" name="google_auth" value="1">
                @endif
                
                <div class="form-field">
                    <label class="block text-xs font-bold text-black mb-1.5">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $googleData['name'] ?? '') }}" {{ session('google_auth') ? 'readonly' : 'required' }} class="w-full rounded-lg border-2 border-black {{ session('google_auth') ? 'bg-gray-100' : 'bg-white' }} px-3.5 py-2 text-sm text-black placeholder:text-text-subtle focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/50" placeholder="John Doe" />
                </div>
                
                <div class="form-field">
                    <label class="block text-xs font-bold text-black mb-1.5">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $googleData['email'] ?? '') }}" {{ session('google_auth') ? 'readonly' : 'required' }} class="w-full rounded-lg border-2 border-black {{ session('google_auth') ? 'bg-gray-100' : 'bg-white' }} px-3.5 py-2 text-sm text-black placeholder:text-text-subtle focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/50" placeholder="john@example.com" />
                </div>
                
                @unless(session('google_auth'))
                <div class="grid grid-cols-2 gap-3">
                    <div class="form-field">
                        <label class="block text-xs font-bold text-black mb-1.5">Password</label>
                        <input type="password" name="password" required class="w-full rounded-lg border-2 border-black bg-white px-3.5 py-2 text-sm text-black placeholder:text-text-subtle focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/50" placeholder="••••••••" />
                    </div>
                    <div class="form-field">
                        <label class="block text-xs font-bold text-black mb-1.5">Confirm</label>
                        <input type="password" name="password_confirmation" required class="w-full rounded-lg border-2 border-black bg-white px-3.5 py-2 text-sm text-black placeholder:text-text-subtle focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/50" placeholder="••••••••" />
                    </div>
                </div>
                @endunless
                
                <div class="pt-2 submit-button">
                    <button type="submit" class="w-full bg-accent-yellow border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 px-6 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active flex items-center justify-center gap-2 group">
                        <span>@if(session('google_auth')) Continue @else Create Account @endif</span>
                        <i class="bi bi-arrow-right text-lg"></i>
                    </button>
                </div>
            </form>

            <div class="mt-5 text-center footer-text space-y-2">
                <p class="text-xs text-text-subtle">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-primary font-semibold hover:underline ml-1">Sign in</a>
                </p>
                <p class="text-xs text-text-subtle">
                    Want to learn? 
                    <a href="{{ route('register.student') }}" class="text-primary font-semibold hover:underline ml-1">Register as Student</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    gsap.registerPlugin();
    window.addEventListener('DOMContentLoaded', () => {
        const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });
        tl.from('.form-header', { y: 30, opacity: 0, duration: 0.8 })
          .from('.google-button, .success-alert, .error-alert', { y: 20, opacity: 0, duration: 0.6 }, '-=0.4')
          .from('.form-field', { y: 20, opacity: 0, duration: 0.5, stagger: 0.1 }, '-=0.3')
          .from('.submit-button', { y: 20, opacity: 0, duration: 0.6 }, '-=0.2')
          .from('.footer-text', { opacity: 0, duration: 0.5 }, '-=0.3');
        gsap.from('.hero-logo', { y: -20, opacity: 0, duration: 0.8, ease: 'power3.out' });
        gsap.from('.hero-content h2', { y: 30, opacity: 0, duration: 0.8, delay: 0.5 });
        gsap.from('.hero-content p', { y: 20, opacity: 0, duration: 0.8, delay: 0.7 });
        gsap.from('.feature-item', { y: 30, opacity: 0, duration: 0.6, stagger: 0.15, delay: 0.9 });
        gsap.to('.floating-circle', { y: -30, x: 20, duration: 4, repeat: -1, yoyo: true, ease: 'sine.inOut' });
        gsap.to('.floating-circle-2', { y: 25, x: -15, duration: 5, repeat: -1, yoyo: true, ease: 'sine.inOut' });
        gsap.to('.floating-circle-3', { y: -20, x: 15, duration: 3.5, repeat: -1, yoyo: true, ease: 'sine.inOut' });
    });
</script>
@if(session('mail_error'))
<script>
  console.error('OTP email send failed:', @json(session('mail_error')));
</script>
@endif
</body>
</html>
