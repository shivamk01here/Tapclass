<!DOCTYPE html>
<html class="light" lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>Book Consultation - Htc</title>
  
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

  <style>
    :root {
        --primary: #0071b2;
        --secondary: #FFA500;
    }
    
    .material-symbols-outlined {
      font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    
    /* Animated Button Styles */
    .cta {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 10px 24px;
      text-decoration: none;
      font-family: 'Manrope', sans-serif;
      font-size: 14px;
      font-weight: 700;
      color: white;
      background: linear-gradient(135deg, var(--primary) 0%, #005a8e 100%);
      transition: 1s;
      box-shadow: 5px 5px 0 #111618;
      transform: skewX(-15deg);
      border-radius: 0.75rem;
      border: none;
      cursor: pointer;
    }

    .dark .cta {
      box-shadow: 5px 5px 0 #f8f9fa;
    }

    .cta:focus {
      outline: none; 
    }

    .cta-primary:hover {
      transition: 0.5s;
      box-shadow: 8px 8px 0 var(--secondary);
    }

    /* FIX 1: Removed hover rule that changed margin/size */
    .cta span:nth-child(2) {
      transition: 0.5s;
      /* margin-right: 0px; <-- REMOVED */
    }
    /*
    .cta:hover span:nth-child(2) {
      transition: 0.5s;
      margin-right: 25px; <-- REMOVED
    }
    */

    .cta span {
      transform: skewX(15deg);
    }

    .cta span:nth-child(2) {
      width: 32px;
      margin-left: 16px;
      position: relative;
      top: 3px;
    }
    
    .cta span:nth-child(2) svg {
      width: 100%;
      height: auto;
    }
      
    /* SVG Animations */
    path.one {
      transition: 0.4s;
      transform: translateX(-60%);
    }
    path.two {
      transition: 0.5s;
      transform: translateX(-30%);
    }
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

    @keyframes color_anim_secondary {
      0% { fill: white; }
      50% { fill: var(--secondary); }
      100% { fill: white; }
    }

    /* Removed .btn-skip styles as it's now a simple link */
  </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display overflow-hidden">

  <div class="h-screen w-full flex items-center justify-center p-4 sm:p-6 lg:p-8">
    
    <div class="w-full max-w-5xl mx-auto bg-white dark:bg-background-dark rounded-2xl shadow-xl shadow-primary/10 overflow-hidden border border-gray-200 dark:border-gray-800">
      <div class="grid grid-cols-1 lg:grid-cols-2">

        <div class="p-8 sm:p-12 flex flex-col justify-center bg-gray-50 dark:bg-gray-900/50 hero-content">
          <p class="text-xs font-semibold uppercase text-primary mb-3">
            We're here to help
          </p>
          <h1 class="text-3xl lg:text-4xl font-black text-gray-900 dark:text-white mb-4 leading-tight">
            Book a Free Consultation
          </h1>
          <p class="text-base text-gray-600 dark:text-gray-300 mb-8">
            Our advisor will call you to help find the perfect tutor for your child's needs.
          </p>

          <div class="space-y-5">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 flex-shrink-0 bg-primary/10 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-primary text-xl">call</span>
              </div>
              <div>
                <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">Phone number</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $supportNumber ?? '+123 456 7890' }}</p>
              </div>
            </div>
            
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 flex-shrink-0 bg-secondary/10 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-secondary text-xl">schedule</span>
              </div>
              <div>
                <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">Availability</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white">Mon-Fri, 9 AM - 6 PM</p>
              </div>
            </div>
          </div>
        </div>
        
        <div class="p-8 sm:p-12 flex flex-col justify-center">
          
          
          @if(session('success'))
          <div class="mb-4 p-3 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 success-alert">
            <div class="flex items-center gap-2">
              <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-lg">check_circle</span>
              <p class="text-xs text-green-700 dark:text-green-300 font-medium">{{ session('success') }}</p>
            </div>
          </div>
          @endif
          
          @if($errors->any())
          <div class="mb-4 p-3 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 error-alert">
            <div class="flex items-center gap-2">
              <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-lg">error</span>
              <p class="text-xs text-red-700 dark:text-red-300 font-medium">{{ $errors->first() }}</p>
            </div>
          </div>
          @endif

          @if($existing)
          <div class="mb-5 p-4 border rounded-xl bg-gray-50 dark:bg-background-dark/50 border-gray-200 dark:border-gray-700 existing-request">
            <div class="flex items-center justify-between mb-2">
              <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">support_agent</span>
                <div class="text-sm font-semibold text-gray-900 dark:text-white">Last Consultation</div>
              </div>
              @php
                $status = strtolower($existing->status ?? 'pending');
                $statusClasses = [
                  'requested' => 'bg-blue-100 text-blue-800',
                  'scheduled' => 'bg-amber-100 text-amber-800',
                  'completed' => 'bg-green-100 text-green-800',
                  'cancelled' => 'bg-red-100 text-red-800',
                ];
                $pill = $statusClasses[$status] ?? 'bg-gray-100 text-gray-800';
              @endphp
              <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $pill }}">{{ ucfirst($status) }}</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
              <div class="flex items-start gap-2">
                <span class="material-symbols-outlined text-blue-600">history</span>
                <div>
                  <div class="text-gray-500">Requested On</div>
                  <div class="font-medium text-gray-900 dark:text-gray-100">{{ $existing->created_at->format('M d, Y h:i A') }} <span class="text-gray-500">({{ $existing->created_at->diffForHumans() }})</span></div>
                </div>
              </div>
              @if($existing->scheduled_at)
              <div class="flex items-start gap-2">
                <span class="material-symbols-outlined text-amber-600">schedule</span>
                <div>
                  <div class="text-gray-500">Scheduled For</div>
                  <div class="font-medium text-gray-900 dark:text-gray-100">{{ $existing->scheduled_at->format('M d, Y h:i A') }}</div>
                </div>
              </div>
              @endif
              <div class="sm:col-span-2">
                <div class="text-gray-500 mb-1">Notes</div>
                <div class="text-gray-800 dark:text-gray-200 overflow-hidden">{{ $existing->questions ?? '—' }}</div>
              </div>
            </div>
          </div>
          @endif

          <form method="POST" action="{{ route('onboarding.parent.consultation.store') }}" class="space-y-4 consultation-form">
            @csrf
            
            <div class="form-field">
              <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Contact Number</label>
              <input 
                type="tel"
                name="contact_phone" 
                value="{{ old('contact_phone', auth()->user()->phone) }}" 
                class="w-full rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3.5 py-2 text-sm text-gray-900 dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" 
                placeholder="+1 (555) 123-4567"
                required 
              />
            </div>
            
            <div class="form-field">
              <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                Additional Notes <span class="text-xs font-normal text-gray-400">(optional)</span>
              </label>
              <textarea 
                name="questions" 
                rows="4" 
                class="w-full rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3.5 py-2 text-sm text-gray-900 dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all resize-none" 
                placeholder="Tell us about your child's learning needs..."
              >{{ old('questions') }}</textarea>
            </div>
            
            <div class="pt-3 button-group">
              <button type="submit" class="cta cta-primary w-full">
                <span style="white-space: nowrap;">Request Call</span>
                <span>
                  <svg width="66px" height="43px" viewBox="0 0 66 43" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <g id="arrow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                      <path class="one" d="M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z" fill="#FFFFFF"></path>
                      <path class="two" d="M20.1543933,3.89485454 L23.9763149,0.139296592 C24.1708311,-0.0518420739 24.4826329,-0.0518571125 24.6771675,0.139262789 L45.6916134,20.7848311 C46.0855801,21.1718824 46.0911863,21.8050225 45.704135,22.1989893 C45.7000188,22.2031791 45.6958657,22.2073326 45.6916762,22.2114492 L24.677098,42.8607841 C24.4825957,43.0519059 24.1708242,43.0519358 23.9762853,42.8608513 L20.1545186,39.1069479 C19.9575152,38.9134427 19.9546793,38.5968729 20.1481845,38.3998695 C20.1502893,38.3977268 20.1524132,38.395603 20.1545562,38.3934985 L36.9937789,21.8567812 C37.1908028,21.6632968 37.193672,21.3467273 37.0001876,21.1497035 C36.9980647,21.1475418 36.9959223,21.1453995 36.9937605,21.1432767 L20.1545208,4.60825197 C19.9574869,4.41477773 19.9546013,4.09820839 20.1480756,3.90117456 C20.1501626,3.89904911 20.1522686,3.89694235 20.1543933,3.89485454 Z" fill="#FFFFFF"></path>
                      <path class="three" d="M0.154393339,3.89485454 L3.97631488,0.139296592 C4.17083111,-0.0518420739 4.48263286,-0.0518571125 4.67716753,0.139262789 L25.6916134,20.7848311 C26.0855801,21.1718824 26.0911863,21.8050225 25.704135,22.1989893 C25.7000188,22.2031791 25.6958657,22.2073326 25.6916762,22.2114492 L4.67709797,42.8607841 C4.48259567,43.0519059 4.17082418,43.0519358 3.97628526,42.8608513 L0.154518591,39.1069479 C-0.0424848215,38.9134427 -0.0453206733,38.5968729 0.148184538,38.3998695 C0.150289256,38.3977268 0.152413239,38.395603 0.154556228,38.3934985 L16.9937789,21.8567812 C17.1908028,21.6632968 17.193672,21.3467273 17.0001876,21.1497035 C16.9980647,21.1475418 16.9959223,21.1453995 16.9937605,21.1432767 L0.15452076,4.60825197 C-0.0425130651,4.41477773 -0.0453986756,4.09820839 0.148075568,3.90117456 C0.150162624,3.89904911 0.152268631,3.89694235 0.154393339,3.89485454 Z" fill="#FFFFFF"></path>
                    </g>
                  </svg>
                </span> 
              </button>
            </div>
            
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    gsap.registerPlugin();

    window.addEventListener('DOMContentLoaded', () => {
      const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });

      // Animate skip link
      gsap.from('.skip-link', {
        y: -30,
        opacity: 0,
        duration: 0.8,
        delay: 0.2
      });

      // Animate left side
      gsap.from('.hero-content > *', {
        x: -30,
        opacity: 0,
        duration: 0.8,
        stagger: 0.1,
        delay: 0.4
      });

      // Animate right side
      tl.from('.success-alert, .error-alert, .existing-request', {
        y: 20,
        opacity: 0,
        duration: 0.6,
        delay: 0.7
      })
      .from('.form-field', {
        y: 20,
        opacity: 0,
        duration: 0.5,
        stagger: 0.1
      }, '-=0.3')
      .from('.button-group', {
        y: 20,
        opacity: 0,
        duration: 0.6
      }, '-=0.2');

      // Input focus animations
      document.querySelectorAll('input, textarea').forEach(input => {
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