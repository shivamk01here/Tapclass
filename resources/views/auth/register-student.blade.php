<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Student Registration - htc</title>
    
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
                        'hero-lg': '4.2rem',
                        'hero-md': '2.5rem',
                        'h2': '2rem',
                        'h3': '1.5rem',
                    }
                }
            }
        }
    </script>
    
    <style>
        .form-panel::-webkit-scrollbar {
            width: 6px;
        }
        .form-panel::-webkit-scrollbar-thumb {
            background-color: #FFBD59; /* accent-yellow */
            border-radius: 3px;
        }
        .form-panel::-webkit-scrollbar-track {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body class="bg-page-bg font-sans">

<div class="h-screen overflow-hidden flex items-center justify-center p-0">
    <div class="w-full h-screen bg-white shadow-xl overflow-hidden grid grid-cols-1 lg:grid-cols-2">

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
                    Start your <br>learning journey.
                </h2>
                <p class="text-base mb-8 opacity-90">
                    Connect with the best tutors, achieve your goals, and unlock your potential.
                </p>
                <ul class="space-y-3">
                    <li class="flex items-center gap-3">
                        <i class="bi bi-check-circle-fill text-accent-yellow"></i>
                        <span>Find verified expert tutors</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="bi bi-check-circle-fill text-accent-yellow"></i>
                        <span>Personalized 1-on-1 sessions</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="bi bi-check-circle-fill text-accent-yellow"></i>
                        <span>Flexible scheduling & payments</span>
                    </li>
                </ul>
            </div>
            
            <div class="absolute -bottom-16 -right-16 size-48 bg-white/10 rounded-full blur-3xl opacity-50 z-0"></div>
        </div>

        <div class="w-full h-screen p-6 md:p-8 lg:p-10 overflow-y-auto form-panel">
            
            <div class="w-full max-w-lg mx-auto"> 
                <div class="text-center lg:text-left mb-6">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-primary mb-4 lg:hidden">
                        <div class="size-8 text-accent-yellow">
                             <i class="bi bi-mortarboard-fill text-3xl text-primary"></i>
                        </div>
                        <h2 class="text-2xl font-bold">htc</h2>
                    </a>
                    <h1 class="font-heading text-h2 uppercase text-black">Create Student Account</h1>
                    <p class="mt-2 text-sm text-text-subtle">Join htc and start learning today</p>
                </div>

                @if($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <ul class="text-sm text-red-600 space-y-1">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if(!session('google_auth'))
                <div class="mb-4">
                    <a href="{{ route('auth.google', ['role' => 'student']) }}" class="w-full flex items-center justify-center gap-3 px-4 py-2.5 border-2 border-black rounded-lg bg-white shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span class="text-black font-bold text-sm">Register with Google</span>
                    </a>

                    <div class="relative my-4">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-black/20"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-page-bg text-text-subtle">Or register with email</span>
                        </div>
                    </div>
                </div>
                @else
                <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-sm text-green-700 flex items-center gap-2">
                        <i class="bi bi-check-circle-fill text-green-600"></i>
                        <span>Connected with Google! Please complete your profile.</span>
                    </p>
                </div>
                @endif

                <form method="POST" action="{{ route('register.student') }}" class="space-y-5">
                    @csrf

                    @if(session('google_auth'))
                        <input type="hidden" name="google_auth" value="1">
                    @endif

                    @php $googleData = session('google_user_data'); @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @unless(session('google_auth'))
                        <div>
                            <label class="block text-sm font-bold text-black mb-1.5">First Name *</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" required class="w-full text-sm rounded-lg border-2 border-black bg-white px-4 py-2.5 focus:border-primary focus:ring-2 focus:ring-primary/50 outline-none" placeholder="John" />
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-black mb-1.5">Last Name *</label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" required class="w-full text-sm rounded-lg border-2 border-black bg-white px-4 py-2.5 focus:border-primary focus:ring-2 focus:ring-primary/50 outline-none" placeholder="Doe" />
                        </div>
                        @endunless

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-black mb-1.5">Email *</label>
                            <input type="email" name="email" value="{{ old('email', $googleData['email'] ?? '') }}" {{ session('google_auth') ? 'readonly' : 'required' }} class="w-full text-sm rounded-lg border-2 border-black {{ session('google_auth') ? 'bg-gray-100' : 'bg-white' }} px-4 py-2.5 focus:border-primary focus:ring-2 focus:ring-primary/50 outline-none" placeholder="you@example.com" />
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-black mb-1.5">Class/Level *</label>
                            <select name="class_slab" required class="w-full text-sm rounded-lg border-2 border-black bg-white px-4 py-2.5 focus:border-primary focus:ring-2 focus:ring-primary/50 outline-none">
                                <option value="">Select</option>
                                @foreach(['1-5','6-8','9-12','undergrad','postgrad'] as $slab)
                                    <option value="{{ $slab }}" {{ old('class_slab')===$slab ? 'selected' : '' }}>{{ strtoupper($slab) }}</option>
                                @endforeach
                            </select>
                        </div>

                        @unless(session('google_auth'))
                        <div>
                            <label class="block text-sm font-bold text-black mb-1.5">Password *</label>
                            <input type="password" name="password" required class="w-full text-sm rounded-lg border-2 border-black bg-white px-4 py-2.5 focus:border-primary focus:ring-2 focus:ring-primary/50 outline-none" placeholder="Minimum 6 characters" />
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-black mb-1.5">Confirm Password *</label>
                            <input type="password" name="password_confirmation" required class="w-full text-sm rounded-lg border-2 border-black bg-white px-4 py-2.5 focus:border-primary focus:ring-2 focus:ring-primary/50 outline-none" placeholder="Re-enter password" />
                        </div>
                        @endunless
                    </div>

                    <button type="submit" class="w-full bg-accent-yellow border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 px-6 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active flex items-center justify-center gap-2">
                        <span>Create Account</span>
                        <i class="bi bi-arrow-right text-lg"></i>
                    </button>
                </form>

                <div class="mt-4 text-center">
                    <p class="text-sm text-text-subtle">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-primary font-medium hover:underline">Login here</a>
                    </p>
                    <p class="mt-2 text-sm text-text-subtle">
                        Want to teach instead? 
                        <a href="{{ route('register.tutor') }}" class="text-primary font-medium hover:underline">Register as Tutor</a>
                    </p>
                </div>

                <p class="mt-6 text-center text-xs text-text-subtle">
                    By creating an account, you agree to our Terms of Service and Privacy Policy
                </p>

            </div>
        </div>
    </div>
</div>

@if(session('mail_error'))
<script>
  console.error('OTP email send failed:', @json(session('mail_error')));
</script>
@endif
</body>
</html>
