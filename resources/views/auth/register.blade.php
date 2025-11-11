    <!DOCTYPE html>
    <html class="light" lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <title>Htc - Register Your Account</title>
        
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
        
        <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
            extend: {
                colors: {
                "primary": "#0071b3",
                "secondary": "#FFA500",
                "background-light": "#f6f7f8",
                "background-dark": "#101c22",
                "text-light": "#111618",
                "text-dark": "#f8f9fa",
                "subtext-light": "#617c89",
                "subtext-dark": "#a0aec0",
                },
                fontFamily: {
                "display": ["Manrope", "sans-serif"]
                },
                borderRadius: {"DEFAULT": "0.5rem", "lg": "0.75rem", "xl": "1rem", "full": "9999px"},
            },
            },
        }
        </script>
        
        <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        
        /* Style for the GSAP highlighter effect */
        .highlight-word {
            /* This gradient paints a 40% high block at the bottom of the text */
            background: linear-gradient(to top, #FFA500 40%, transparent 40%);
            /* Start with the background size at 0% width */
            background-size: 0% 100%;
            background-repeat: no-repeat;
            background-position: left;
        }
        </style>
    </head>

    <body class="bg-background-light dark:bg-background-dark text-text-light dark:text-text-dark font-display flex items-center justify-center min-h-screen p-4">

    <div class="relative flex h-auto w-full flex-col group/design-root overflow-x-hidden">
    <div class="layout-container flex h-full grow flex-col">

    <main class="flex-1">
        <div class="px-4 md:px-10">
            <div class="layout-content-container flex flex-col max-w-[1200px] flex-1 mx-auto">
                <div class="flex flex-col gap-12 py-16 md:py-24">

                    <section class="flex flex-col gap-12" id="register">
                        
                        <div class="flex flex-col gap-4 text-center">
                            <h1 class="text-3xl md:text-5xl font-bold leading-tight tracking-[-0.015em] animate-in">
                                Join the Htc <span class="highlight-word">Community</span>
                            </h1>
                            <p class="text-lg text-subtext-light dark:text-subtext-dark max-w-2xl mx-auto animate-in">
                                Choose your path to start learning, teaching, or supporting today.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                            <div class="register-card block rounded-xl bg-white dark:bg-background-dark/50 border border-gray-200 dark:border-gray-700 shadow-lg 
                                        transition-all duration-300 ease-in-out 
                                        hover:-translate-y-2 hover:shadow-2xl hover:rotate-1 group">
                                
                                <div class="p-8 flex flex-col items-center text-center h-full">
                                    <div class="w-full h-48 flex items-center justify-center mb-6">
                                        <img src="images/register/student.svg" alt="Register as a Student" class="max-h-full object-contain">
                                    </div>
                                    
                                    <h3 class="text-2xl font-bold mb-3">Register as a Student</h3>
                                    <p class="text-subtext-light dark:text-subtext-dark mb-6 flex-grow">
                                        Find the perfect tutor, schedule sessions, and unlock your full potential.
                                    </p>
                                    
                                    <a href="/register/student" class="flex min-w-[84px] w-full max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-6 bg-primary text-white text-base font-bold leading-normal tracking-[0.015em] hover:bg-primary/90 transition-colors">
                                        <span class="truncate">Get Started</span>
                                        <span class="material-symbols-outlined ml-2 transition-transform duration-300 group-hover:translate-x-1">arrow_forward</span>
                                    </a>
                                </div>
                            </div>

                            <div class="register-card block rounded-xl bg-white dark:bg-background-dark/50 border border-gray-200 dark:border-gray-700 shadow-lg 
                                        transition-all duration-300 ease-in-out 
                                        hover:-translate-y-2 hover:shadow-2xl hover:-rotate-1 group">
                                
                                <div class="p-8 flex flex-col items-center text-center h-full">
                                    <div class="w-full h-48 flex items-center justify-center mb-6">
                                        <img src="images/register/teacher.svg" alt="Register as a Tutor" class="max-h-full object-contain">
                                    </div>
                                    
                                    <h3 class="text-2xl font-bold mb-3">Register as a Tutor</h3>
                                    <p class="text-subtext-light dark:text-subtext-dark mb-6 flex-grow">
                                        Share your expertise, set your own schedule, and start earning.
                                    </p>
                                    
                                    <a href="/register/tutor" class="flex min-w-[84px] w-full max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-6 bg-secondary text-white text-base font-bold leading-normal tracking-[0.015em] hover:bg-secondary/90 transition-colors">
                                        <span class="truncate">Start Teaching</span>
                                        <span class="material-symbols-outlined ml-2 transition-transform duration-300 group-hover:translate-x-1">arrow_forward</span>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="register-card block rounded-xl bg-white dark:bg-background-dark/50 border border-gray-200 dark:border-gray-700 shadow-lg 
                                        transition-all duration-300 ease-in-out 
                                        hover:-translate-y-2 hover:shadow-2xl hover:rotate-1 group">
                                
                                <div class="p-8 flex flex-col items-center text-center h-full">
                                    <div class="w-full h-48 flex items-center justify-center mb-6">
                                        <img src="images/register/parent.png" alt="Register as a Parent" class="max-h-full object-contain">
                                    </div>
                                    
                                    <h3 class="text-2xl font-bold mb-3">Register as a Parent</h3>
                                    <p class="text-subtext-light dark:text-subtext-dark mb-6 flex-grow">
                                        Manage your child's learning, track progress, and communicate with tutors.
                                    </p>
                                    
                                    <a href="/register/parent" class="flex min-w-[84px] w-full max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-6 bg-primary text-white text-base font-bold leading-normal tracking-[0.015em] hover:bg-primary/90 transition-colors">
                                        <span class="truncate">Sign Up</span>
                                        <span class="material-symbols-outlined ml-2 transition-transform duration-300 group-hover:translate-x-1">arrow_forward</span>
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
                
                // Set initial states for animations
                gsap.set(".animate-in", { opacity: 0, y: 30 });
                gsap.set(".register-card", { opacity: 0, y: 50 });

                // Create a timeline
                const tl = gsap.timeline({ defaults: { ease: "power3.out" } });

                tl.to(".animate-in", {
                    duration: 0.8,
                    opacity: 1,
                    y: 0,
                    stagger: 0.2
                })
                .to(".highlight-word", {
                    backgroundSize: "100% 100%", // Animate the highlighter
                    duration: 1,
                    ease: "power2.inOut"
                }, "-=0.5") // Start highlighter animation 0.5s before the text anim is done
                .to(".register-card", {
                    duration: 0.8,
                    opacity: 1,
                    y: 0,
                    stagger: 0.2
                }, "-=0.8"); // Start card animation
            }
        });
    </script>

    </body>
    </html>