<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>htc - Register Your Account</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
    
    <script id="tailwind-config">
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
                    'hero-lg': '4.2rem',
                    'hero-md': '2.5rem',  // For page titles
                    'h2': '2rem',
                    'h3': '1.5rem',       // For card titles
                }
            }
        }
    }
    </script>
    
    <style>
        /* Style for the GSAP highlighter (Updated to our accent color) */
        .highlight-word {
            /* This is our new --accent-yellow color */
            background: linear-gradient(to top, #FFBD59 40%, transparent 40%);
            background-size: 0% 100%;
            background-repeat: no-repeat;
            background-position: left;
        }
    </style>
</head>

<body class="bg-page-bg text-black font-sans flex items-center justify-center min-h-screen p-4">

<div class="relative flex h-auto w-full flex-col group/design-root overflow-x-hidden">
<div class="layout-container flex h-full grow flex-col">
<main class="flex-1">
    <div class="px-4 md:px-10">
        <div class="layout-content-container flex flex-col max-w-[1200px] flex-1 mx-auto">
            <div class="flex flex-col gap-12 py-16 md:py-24">

                <section class="flex flex-col gap-12" id="register">
                    
                    <div class="flex flex-col gap-4 text-center">
                        <h1 class="font-heading text-hero-md md:text-5xl uppercase leading-tight animate-in">
                            Join the htc <span class="highlight-word">Community</span>
                        </h1>
                        <p class="text-lg text-text-subtle max-w-2xl mx-auto animate-in">
                            Choose your path to start learning, teaching, or supporting today.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                        <div class="register-card block rounded-2xl bg-white border-2 border-black shadow-header-chunky 
                                    transition-all duration-300 ease-in-out 
                                    hover:-translate-y-1 hover:shadow-header-chunky hover:rotate-1 group">
                            
                            <div class="p-8 flex flex-col items-center text-center h-full">
                                <div class="w-full h-48 flex items-center justify-center mb-6">
                                    <img src="{{ asset('images/register/student.svg') }}" alt="Register as a Student" class="max-h-full object-contain">
                                </div>
                                
                                <h3 class="font-heading text-h3 uppercase mb-3">Register as a Student</h3>
                                <p class="text-text-subtle mb-6 flex-grow">
                                    Find the perfect tutor, schedule sessions, and unlock your full potential.
                                </p>
                                
                                <a href="{{ route('register.student') }}" class="w-full flex items-center justify-center bg-accent-yellow border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 px-6 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                                    <span>Get Started</span>
                                    <i class="bi bi-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>

                        <div class="register-card block rounded-2xl bg-white border-2 border-black shadow-header-chunky 
                                    transition-all duration-300 ease-in-out 
                                    hover:-translate-y-1 hover:shadow-header-chunky hover:-rotate-1 group">
                            
                            <div class="p-8 flex flex-col items-center text-center h-full">
                                <div class="w-full h-48 flex items-center justify-center mb-6">
                                    <img src="{{ asset('images/register/teacher.svg') }}" alt="Register as a Tutor" class="max-h-full object-contain">
                                </div>
                                
                                <h3 class="font-heading text-h3 uppercase mb-3">Register as a Tutor</h3>
                                <p class="text-text-subtle mb-6 flex-grow">
                                    Share your expertise, set your own schedule, and start earning.
                                </p>
                                
                                <a href="{{ route('register.tutor') }}" class="w-full flex items-center justify-center bg-white border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 px-6 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                                    <span>Start Teaching</span>
                                    <i class="bi bi-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                        
                        <div class="register-card block rounded-2xl bg-white border-2 border-black shadow-header-chunky 
                                    transition-all duration-300 ease-in-out 
                                    hover:-translate-y-1 hover:shadow-header-chunky hover:rotate-1 group">
                            
                            <div class="p-8 flex flex-col items-center text-center h-full">
                                <div class="w-full h-48 flex items-center justify-center mb-6">
                                    <img src="{{ asset('images/register/parent.png') }}" alt="Register as a Parent" class="max-h-full object-contain">
                                </div>
                                
                                <h3 class="font-heading text-h3 uppercase mb-3">Register as a Parent</h3>
                                <p class="text-text-subtle mb-6 flex-grow">
                                    Manage your child's learning, track progress, and communicate with tutors.
                                </p>
                                
                                <a href="{{ route('register.parent') }}" class="w-full flex items-center justify-center bg-accent-yellow border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 px-6 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                                    <span>Sign Up</span>
                                    <i class="bi bi-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                        
                    </div>
                </section>

            </div>
        </div>
    </div>
</main>
</div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof gsap !== "undefined") {
            
            gsap.set(".animate-in", { opacity: 0, y: 30 });
            gsap.set(".register-card", { opacity: 0, y: 50 });

            const tl = gsap.timeline({ defaults: { ease: "power3.out" } });

            tl.to(".animate-in", {
                duration: 0.8,
                opacity: 1,
                y: 0,
                stagger: 0.2
            })
            .to(".highlight-word", {
                backgroundSize: "100% 100%", 
                duration: 1,
                ease: "power2.inOut"
            }, "-=0.5")
            .to(".register-card", {
                duration: 0.8,
                opacity: 1,
                y: 0,
                stagger: 0.2
            }, "-=0.8");
        }
    });
</script>

</body>
</html>