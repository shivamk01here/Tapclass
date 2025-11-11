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
              "primary": "#13a4ec",
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
      /* Define CSS variables from your config for use in custom CSS */
      :root {
          --primary: #13a4ec;
          --secondary: #FFA500;
          --text-light: #111618;
          --text-dark: #f8f9fa;
          --shadow-light: #111618;
          --shadow-dark: #f8f9fa;
      }
      
      .dark:root {
          --shadow-light: #f8f9fa;
          --shadow-dark: #111618;
      }
    
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
      
      /* --- Enhanced Card Hover --- */
      /* We apply this using JS or just by adding the class, but for simplicity, let's target the classes */
      .register-card.card-primary {
        transition: all 0.3s ease-in-out;
      }
      .register-card.card-secondary {
        transition: all 0.3s ease-in-out;
      }
      
      .register-card.card-primary:hover {
          border-color: var(--primary); /* Highlight with primary color */
      }
      .register-card.card-secondary:hover {
          border-color: var(--secondary); /* Highlight with secondary color */
      }
      
      
      /* --- NEW ANIMATED BUTTON STYLES --- */
      .cta {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px 25px;
        text-decoration: none;
        font-family: 'Manrope', sans-serif; /* Use your loaded font */
        font-size: 20px;
        font-weight: 700;
        color: white;
        background: var(--primary); /* Will be overridden by Tailwind */
        transition: 1s;
        box-shadow: 6px 6px 0 var(--shadow-light);
        transform: skewX(-15deg);
        border-radius: 0.5rem; /* Match your theme's border radius */
      }

      .cta:focus {
        outline: none; 
      }

      /* --- Primary Button Theming --- */
      .cta-primary:hover {
        transition: 0.5s;
        box-shadow: 10px 10px 0 var(--secondary);
      }
      
      /* --- Secondary Button Theming --- */
      .cta-secondary:hover {
        transition: 0.5s;
        box-shadow: 10px 10px 0 var(--primary);
      }

      .cta span:nth-child(2) {
        transition: 0.5s;
        margin-right: 0px;
      }

      .cta:hover span:nth-child(2) {
        transition: 0.5s;
        margin-right: 30px;
      }

      .cta span {
        transform: skewX(15deg) 
      }

      .cta span:nth-child(2) {
        /* This span holds the SVG */
        width: 44px; /* Scaled down from 66px */
        margin-left: 20px;
        position: relative;
        top: 5px; /* Manual vertical alignment */
      }
      
      .cta span:nth-child(2) svg {
        width: 100%; /* SVG scales to its container */
        height: auto;
      }
        
      /**************SVG****************/

      path.one {
        transition: 0.4s;
        transform: translateX(-60%);
      }

      path.two {
        transition: 0.5s;
        transform: translateX(-30%);
      }

      /* --- Primary Hover SVG Animation --- */
      .cta-primary:hover path.three {
        animation: color_anim_secondary 1s infinite 0.2s;
      }
      .cta-primary:hover path.one {
        transform: translateX(0%);
        animation: color_anim_secondary 1s infinite 0.6s;
      }
      .cta-primary:hover path.two {
        transform: translateX(0%);
        animation: color_anim_secondary 1s infinite 0.4s;
      }
      
      /* --- Secondary Hover SVG Animation --- */
      .cta-secondary:hover path.three {
        animation: color_anim_primary 1s infinite 0.2s;
      }
      .cta-secondary:hover path.one {
        transform: translateX(0%);
        animation: color_anim_primary 1s infinite 0.6s;
      }
      .cta-secondary:hover path.two {
        transform: translateX(0%);
        animation: color_anim_primary 1s infinite 0.4s;
      }

      /* SVG keyframes */

      @keyframes color_anim_secondary {
        0% {
          fill: white;
        }
        50% {
          fill: var(--secondary); /* #FFA500 */
        }
        100% {
          fill: white;
        }
      }
      
      @keyframes color_anim_primary {
        0% {
          fill: white;
        }
        50% {
          fill: var(--primary); /* #13a4ec */
        }
        100% {
          fill: white;
        }
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

                        <!-- === CARD 1: STUDENT (PRIMARY) === -->
                        <div class="register-card card-primary block rounded-xl bg-white dark:bg-background-dark/50 border border-gray-200 dark:border-gray-700 shadow-lg 
                                      transition-all duration-300 ease-in-out 
                                      hover:-translate-y-2 hover:shadow-2xl group">
                            
                            <div class="p-8 flex flex-col items-center text-center h-full">
                                <div class="w-full h-48 flex items-center justify-center mb-6">
                                    <!-- Reverted to your original image path -->
                                    <img src="images/register/student.png" 
                                         onerror="this.src='https://placehold.co/300x200/13a4ec/white?text=Student+Image&font=manrope'" 
                                         alt="Register as a Student" class="max-h-full object-contain rounded-lg">
                                </div>
                                
                                <h3 class="text-2xl font-bold mb-3">Register as a Student</h3>
                                <p class="text-subtext-light dark:text-subtext-dark mb-6 flex-grow">
                                    Find the perfect tutor, schedule sessions, and unlock your full potential.
                                </p>
                                
                                <!-- NEW ANIMATED BUTTON -->
                                <a href="/register/student" class="cta cta-primary bg-primary">
                                    <span>Get Started</span>
                                    <span>
                                      <svg width="66px" height="43px" viewBox="0 0 66 43" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <g id="arrow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                          <path class="one" d="M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z" fill="#FFFFFF"></path>
                                          <path class="two" d="M20.1543933,3.89485454 L23.9763149,0.139296592 C24.1708311,-0.0518420739 24.4826329,-0.0518571125 24.6771675,0.139262789 L45.6916134,20.7848311 C46.0855801,21.1718824 46.0911863,21.8050225 45.704135,22.1989893 C45.7000188,22.2031791 45.6958657,22.2073326 45.6916762,22.2114492 L24.677098,42.8607841 C24.4825957,43.0519059 24.1708242,43.0519358 23.9762853,42.8608513 L20.1545186,39.1069479 C19.9575152,38.9134427 19.9546793,38.5968729 20.1481845,38.3998695 C20.1502893,38.3977268 20.1524132,38.395603 20.1545562,38.3934985 L36.9937789,21.8567812 C37.1908028,21.6632968 37.193672,21.3467273 37.0001876,21.1497035 C36.9980647,21.1475418 36.9959223,21.1453995 36.9937605,21.1432767 L20.1545208,4.60825197 C19.9574869,4.41477773 19.9546013,4.09820839 20.1480756,3.90117456 C20.1501626,3.89904911 20.1522686,3.89694235 20.1543933,3.89485454 Z" fill="#FFFFFF"></path>
                                          <path class="three" d="M0.154393339,3.89485454 L3.97631488,0.139296592 C4.17083111,-0.0518420739 4.48263286,-0.0518571125 4.67716753,0.139262789 L25.6916134,20.7848311 C26.0855801,21.1718824 26.0911863,21.8050225 25.704135,22.1989893 C25.7000188,22.2031791 25.6958657,22.2073326 25.6916762,22.2114492 L4.67709797,42.8607841 C4.48259567,43.0519059 4.17082418,43.0519358 3.97628526,42.8608513 L0.154518591,39.1069479 C-0.0424848215,38.9134427 -0.0453206733,38.5968729 0.148184538,38.3998695 C0.150289256,38.3977268 0.152413239,38.395603 0.154556228,38.3934985 L16.9937789,21.8567812 C17.1908028,21.6632968 17.193672,21.3467273 17.0001876,21.1497035 C16.9980647,21.1475418 16.9959223,21.1453995 16.9937605,21.1432767 L0.15452076,4.60825197 C-0.0425130651,4.41477773 -0.0453986756,4.09820839 0.148075568,3.90117456 C0.150162624,3.89904911 0.152268631,3.89694235 0.154393339,3.89485454 Z" fill="#FFFFFF"></path>
                                        </g>
                                      </svg>
                                    </span> 
                                  </a>
                            </div>
                        </div>

                        <!-- === CARD 2: TUTOR (SECONDARY) === -->
                        <div class="register-card card-secondary block rounded-xl bg-white dark:bg-background-dark/50 border border-gray-200 dark:border-gray-700 shadow-lg 
                                      transition-all duration-300 ease-in-out 
                                      hover:-translate-y-2 hover:shadow-2xl group">
                            
                            <div class="p-8 flex flex-col items-center text-center h-full">
                                <div class="w-full h-48 flex items-center justify-center mb-6">
                                    <!-- Reverted to your original image path -->
                                    <img src="images/register/tutor.png" 
                                         onerror="this.src='https://placehold.co/300x200/FFA500/white?text=Tutor+Image&font=manrope'"
                                         alt="Register as a Tutor" class="max-h-full object-contain rounded-lg">
                                </div>
                                
                                <h3 class="text-2xl font-bold mb-3">Register as a Tutor</h3>
                                <p class="text-subtext-light dark:text-subtext-dark mb-6 flex-grow">
                                    Share your expertise, set your own schedule, and start earning.
                                </p>
                                
                                <!-- NEW ANIMATED BUTTON -->
                                <a href="/register/tutor" class="cta cta-secondary bg-secondary">
                                    <span>Start Teaching</span>
                                    <span>
                                      <svg width="66px" height="43px" viewBox="0 0 66 43" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <g id="arrow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                          <path class="one" d="M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z" fill="#FFFFFF"></path>
                                          <path class="two" d="M20.1543933,3.89485454 L23.9763149,0.139296592 C24.1708311,-0.0518420739 24.4826329,-0.0518571125 24.6771675,0.139262789 L45.6916134,20.7848311 C46.0855801,21.1718824 46.0911863,21.8050225 45.704135,22.1989893 C45.7000188,22.2031791 45.6958657,22.2073326 45.6916762,22.2114492 L24.677098,42.8607841 C24.4825957,43.0519059 24.1708242,43.0519358 23.9762853,42.8608513 L20.1545186,39.1069479 C19.9575152,38.9134427 19.9546793,38.5968729 20.1481845,38.3998695 C20.1502893,38.3977268 20.1524132,38.395603 20.1545562,38.3934985 L36.9937789,21.8567812 C37.1908028,21.6632968 37.193672,21.3467273 37.0001876,21.1497035 C36.9980647,21.1475418 36.9959223,21.1453995 36.9937605,21.1432767 L20.1545208,4.60825197 C19.9574869,4.41477773 19.9546013,4.09820839 20.1480756,3.90117456 C20.1501626,3.89904911 20.1522686,3.89694235 20.1543933,3.89485454 Z" fill="#FFFFFF"></path>
                                          <path class="three" d="M0.154393339,3.89485454 L3.97631488,0.139296592 C4.17083111,-0.0518420739 4.48263286,-0.0518571125 4.67716753,0.139262789 L25.6916134,20.7848311 C26.0855801,21.1718824 26.0911863,21.8050225 25.704135,22.1989893 C25.7000188,22.2031791 25.6958657,22.2073326 25.6916762,22.2114492 L4.67709797,42.8607841 C4.48259567,43.0519059 4.17082418,43.0519358 3.97628526,42.8608513 L0.154518591,39.1069479 C-0.0424848215,38.9134427 -0.0453206733,38.5968729 0.148184538,38.3998695 C0.150289256,38.3977268 0.152413239,38.395603 0.154556228,38.3934985 L16.9937789,21.8567812 C17.1908028,21.6632968 17.193672,21.3467273 17.0001876,21.1497035 C16.9980647,21.1475418 16.9959223,21.1453995 16.9937605,21.1432767 L0.15452076,4.60825197 C-0.0425130651,4.41477773 -0.0453986756,4.09820839 0.148075568,3.90117456 C0.150162624,3.89904911 0.152268631,3.89694235 0.154393339,3.89485454 Z" fill="#FFFFFF"></path>
                                        </g>
                                      </svg>
                                    </span> 
                                  </a>
                            </div>
                        </div>
                        
                        <!-- === CARD 3: PARENT (PRIMARY) === -->
                        <div class="register-card card-primary block rounded-xl bg-white dark:bg-background-dark/50 border border-gray-200 dark:border-gray-700 shadow-lg 
                                      transition-all duration-300 ease-in-out 
                                      hover:-translate-y-2 hover:shadow-2xl group">
                            
                            <div class="p-8 flex flex-col items-center text-center h-full">
                                <div class="w-full h-48 flex items-center justify-center mb-6">
                                    <!-- Reverted to your original image path -->
                                    <img src="images/register/parent.png"
                                         onerror="this.src='https://placehold.co/300x200/13a4ec/white?text=Parent+Image&font=manrope'"
                                         alt="Register as a Parent" class="max-h-full object-contain rounded-lg">
                                </div>
                                
                                <h3 class="text-2xl font-bold mb-3">Register as a Parent</h3>
                                <p class="text-subtext-light dark:text-subtext-dark mb-6 flex-grow">
                                    Manage your child's learning, track progress, and communicate with tutors.
                                </p>
                                
                                <!-- NEW ANIMATED BUTTON -->
                                <a href="/register/parent" class="cta cta-primary bg-primary">
                                    <span>Sign Up</span>
                                    <span>
                                      <svg width="66px" height="43px" viewBox="0 0 66 43" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <g id="arrow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                          <path class="one" d="M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z" fill="#FFFFFF"></path>
                                          <path class="two" d="M20.1543933,3.89485454 L23.9763149,0.139296592 C24.1708311,-0.0518420739 24.4826329,-0.0518571125 24.6771675,0.139262789 L45.6916134,20.7848311 C46.0855801,21.1718824 46.0911863,21.8050225 45.704135,22.1989893 C45.7000188,22.2031791 45.6958657,22.2073326 45.6916762,22.2114492 L24.677098,42.8607841 C24.4825957,43.0519059 24.1708242,43.0519358 23.9762853,42.8608513 L20.1545186,39.1069479 C19.9575152,38.9134427 19.9546793,38.5968729 20.1481845,38.3998695 C20.1502893,38.3977268 20.1524132,38.395603 20.1545562,38.3934985 L36.9937789,21.8567812 C37.1908028,21.6632968 37.193672,21.3467273 37.0001876,21.1497035 C36.9980647,21.1475418 36.9959223,21.1453995 36.9937605,21.1432767 L20.1545208,4.60825197 C19.9574869,4.41477773 19.9546013,4.09820839 20.1480756,3.90117456 C20.1501626,3.89904911 20.1522686,3.89694235 20.1543933,3.89485454 Z" fill="#FFFFFF"></path>
                                          <path class="three" d="M0.154393339,3.89485454 L3.97631488,0.139296592 C4.17083111,-0.0518420739 4.48263286,-0.0518571125 4.67716753,0.139262789 L25.6916134,20.7848311 C26.0855801,21.1718824 26.0911863,21.8050225 25.704135,22.1989893 C25.7000188,22.2031791 25.6958657,22.2073326 25.6916762,22.2114492 L4.67709797,42.8607841 C4.48259567,43.0519059 4.17082418,43.0519358 3.97628526,42.8608513 L0.154518591,39.1069479 C-0.0424848215,38.9134427 -0.0453206733,38.5968729 0.148184538,38.3998695 C0.150289256,38.3977268 0.152413239,38.395603 0.154556228,38.3934985 L16.9937789,21.8567812 C17.1908028,21.6632968 17.193672,21.3467273 17.0001876,21.1497035 C16.9980647,21.1475418 16.9959223,21.1453995 16.9937605,21.1432767 L0.15452076,4.60825197 C-0.0425130651,4.41477773 -0.0453986756,4.09820839 0.148075568,3.90117456 C0.150162624,3.89904911 0.152268631,3.89694235 0.154393339,3.89485454 Z" fill="#FFFFFF"></path>
                                        </g>
                                      </svg>
                                    </span> 
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
        
        // Replace broken image paths with placeholders
        const images = document.querySelectorAll('img');
        images.forEach(img => {
            img.onerror = function() {
                const alt = img.alt || "Placeholder";
                let color = "cccccc"; // default
                if (alt.includes("Student")) color = "13a4ec";
                if (alt.includes("Tutor")) color = "FFA500";
                if (alt.includes("Parent")) color = "13a4ec";
                
                this.src = `https://placehold.co/300x200/${color}/white?text=${encodeURIComponent(alt)}&font=manrope`;
            };
            // Trigger load check in case it's already broken
            if (img.src.includes('placehold.co')) return; // Don't re-trigger for placeholders
            if (!img.complete || img.naturalHeight === 0) {
                // If src is the original path (e.g., "images/register/student.png") and it's broken,
                // the onerror will fire automatically. If not, this re-triggers it.
                const originalSrc = img.src;
                img.src = ''; // Clear src
                img.src = originalSrc; // Set it back to trigger load/error
            }
        });
    });
</script>

</body>
</html>