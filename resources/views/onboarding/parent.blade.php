<!DOCTYPE html>
<html class="light" lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>Add Learner - Htc</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: { 
        extend: { 
          colors: { 
            primary: '#13a4ec', 
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
<body class="bg-gradient-to-br from-background-light via-white to-primary/5 dark:from-background-dark dark:via-gray-900 dark:to-primary/10 font-display min-h-screen">
  <div class="pt-28 pb-7 px-6">
    <div class="max-w-5xl mx-auto">
      
      <!-- Header Section with Illustration -->
      <div class="text-center mb-8 header-section">
        <h1 class="text-3xl font-black text-gray-900 dark:text-white mb-2">Add Your Learner</h1>
        <p class="text-sm text-gray-600 dark:text-gray-400 max-w-md mx-auto">Tell us about your child so we can match them with the perfect tutor</p>
      </div>

      @if(session('success'))
      <div class="max-w-2xl mx-auto mb-6 p-4 rounded-xl bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-200 dark:border-green-800 success-alert">
        <div class="flex items-center gap-3">
          <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-xl">check_circle</span>
          <p class="text-sm text-green-700 dark:text-green-300 font-medium">{{ session('success') }}</p>
        </div>
      </div>
      @endif

      @if($errors->any())
      <div class="max-w-2xl mx-auto mb-6 p-4 rounded-xl bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 border border-red-200 dark:border-red-800 error-alert">
        <div class="flex items-center gap-3">
          <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-xl">error</span>
          <p class="text-sm text-red-700 dark:text-red-300 font-medium">{{ $errors->first() }}</p>
        </div>
      </div>
      @endif

      <!-- Main Form Card -->
      <div class="max-w-2xl mx-auto form-card">
        <form method="POST" action="{{ route('onboarding.parent.child.store') }}" enctype="multipart/form-data" class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl shadow-primary/5 border border-gray-200 dark:border-gray-800 p-8 space-y-6">
          @csrf
          
          <!-- Name and Age Row -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 form-row-1">
            <div class="form-field">
              <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                <span class="material-symbols-outlined text-primary text-lg">person</span>
                Child's First Name
              </label>
              <input 
                name="first_name" 
                value="{{ old('first_name') }}" 
                class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" 
                placeholder="Enter first name"
                required 
              />
            </div>
            <div class="form-field">
              <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                <span class="material-symbols-outlined text-secondary text-lg">cake</span>
                Age
              </label>
              <input 
                type="number" 
                name="age" 
                min="1" 
                max="20" 
                value="{{ old('age') }}" 
                class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                placeholder="Enter age"
              />
            </div>
          </div>

          <!-- Class/Slab -->
          <div class="form-field form-row-2">
            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
              <span class="material-symbols-outlined text-primary text-lg">school</span>
              Class/Slab
            </label>
            <select 
              name="class_slab" 
              class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" 
              required
            >
              <option value="">Select class level...</option>
              @foreach(['1-5','6-8','9-12','graduate','postgraduate'] as $slab)
                <option value="{{ $slab }}" @selected(old('class_slab')===$slab)>
                  {{ $slab === '1-5' ? 'Class 1-5 (Primary)' : ($slab === '6-8' ? 'Class 6-8 (Middle School)' : ($slab === '9-12' ? 'Class 9-12 (High School)' : ucfirst($slab))) }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- Profile Photo -->
          <div class="form-field form-row-3">
            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
              <span class="material-symbols-outlined text-secondary text-lg">photo_camera</span>
              Profile Photo
              <span class="text-xs font-normal text-gray-400">(optional)</span>
            </label>
            <div class="relative">
              <input 
                type="file" 
                name="profile_photo" 
                accept="image/*" 
                class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-all"
              />
            </div>
          </div>

          <!-- Learning Goals -->
          <div class="form-field form-row-4">
            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
              <span class="material-symbols-outlined text-primary text-lg">flag</span>
              Learning Goals
              <span class="text-xs font-normal text-gray-400">(optional)</span>
            </label>
            <textarea 
              name="goals" 
              rows="3" 
              class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all resize-none" 
              placeholder="e.g., Master multiplication tables, improve reading comprehension, learn basic coding"
            >{{ old('goals') }}</textarea>
          </div>

          <!-- Action Buttons -->
          <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 pt-4 button-group">
            <button 
              type="submit"
              name="add_another" 
              value="1" 
              class="group px-6 py-3 rounded-xl bg-gradient-to-r from-secondary to-orange-500 hover:shadow-lg hover:shadow-secondary/25 text-white text-sm font-semibold transition-all duration-300 hover:-translate-y-0.5 flex items-center justify-center gap-2"
            >
              <span class="material-symbols-outlined text-lg">add</span>
              <span>Save & Add Another</span>
            </button>
            <button 
              type="submit"
              class="group px-6 py-3 rounded-xl bg-gradient-to-r from-primary to-blue-500 hover:shadow-lg hover:shadow-primary/25 text-white text-sm font-semibold transition-all duration-300 hover:-translate-y-0.5 flex items-center justify-center gap-2"
            >
              <span>Complete Setup</span>
              <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </button>
          </div>

          <!-- Info Card -->
          <div class="mt-6 p-4 bg-gradient-to-r from-primary/5 to-secondary/5 rounded-xl border border-primary/10 info-card">
            <div class="flex gap-3">
              <span class="material-symbols-outlined text-primary text-xl flex-shrink-0">info</span>
              <div>
                <p class="text-xs text-gray-700 dark:text-gray-300 leading-relaxed">
                  <span class="font-semibold">Quick tip:</span> You can manage multiple learners from your dashboard. Add all your children now or come back later to add more.
                </p>
              </div>
            </div>
          </div>
        </form>
      </div>

      <!-- Features Section -->
      <div class="max-w-2xl mx-auto mt-10 features-section">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div class="text-center p-4 rounded-xl bg-white/50 dark:bg-gray-900/50 backdrop-blur-sm border border-gray-200 dark:border-gray-800 feature-card">
            <div class="w-12 h-12 bg-gradient-to-br from-primary/10 to-primary/5 rounded-xl flex items-center justify-center mx-auto mb-2">
              <span class="material-symbols-outlined text-primary text-2xl">verified_user</span>
            </div>
            <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">Verified Tutors</p>
          </div>
          <div class="text-center p-4 rounded-xl bg-white/50 dark:bg-gray-900/50 backdrop-blur-sm border border-gray-200 dark:border-gray-800 feature-card">
            <div class="w-12 h-12 bg-gradient-to-br from-secondary/10 to-secondary/5 rounded-xl flex items-center justify-center mx-auto mb-2">
              <span class="material-symbols-outlined text-secondary text-2xl">analytics</span>
            </div>
            <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">Progress Tracking</p>
          </div>
          <div class="text-center p-4 rounded-xl bg-white/50 dark:bg-gray-900/50 backdrop-blur-sm border border-gray-200 dark:border-gray-800 feature-card">
            <div class="w-12 h-12 bg-gradient-to-br from-primary/10 to-primary/5 rounded-xl flex items-center justify-center mx-auto mb-2">
              <span class="material-symbols-outlined text-primary text-2xl">schedule</span>
            </div>
            <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">Flexible Scheduling</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Floating Background Elements -->
  <div class="fixed inset-0 pointer-events-none overflow-hidden -z-10">
    <div class="floating-bg-1 absolute top-20 right-20 w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
    <div class="floating-bg-2 absolute bottom-20 left-20 w-96 h-96 bg-secondary/5 rounded-full blur-3xl"></div>
  </div>

  <script>
    // GSAP Animations
    window.addEventListener('DOMContentLoaded', () => {
      const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });

      // Progress bar animation
      gsap.from('.progress-bar-container', {
        y: -100,
        opacity: 0,
        duration: 0.8,
        ease: 'power3.out'
      });

      gsap.from('.progress-fill', {
        width: '0%',
        duration: 1.5,
        delay: 0.5,
        ease: 'power2.inOut'
      });

      // Header section
      tl.from('.illustration-container', {
        scale: 0.5,
        opacity: 0,
        duration: 1,
        ease: 'back.out(1.4)'
      })
      .from('.header-section h1', {
        y: 30,
        opacity: 0,
        duration: 0.8
      }, '-=0.5')
      .from('.header-section p', {
        y: 20,
        opacity: 0,
        duration: 0.6
      }, '-=0.4');

      // Alerts
      gsap.from('.success-alert, .error-alert', {
        scale: 0.9,
        opacity: 0,
        duration: 0.5,
        ease: 'back.out(1.2)'
      });

      // Form card
      gsap.from('.form-card', {
        y: 50,
        opacity: 0,
        duration: 0.8,
        delay: 0.6
      });

      // Form fields stagger
      gsap.from('.form-row-1, .form-row-2, .form-row-3, .form-row-4, .button-group, .info-card', {
        y: 30,
        opacity: 0,
        duration: 0.6,
        stagger: 0.1,
        delay: 0.9
      });

      // Features section
      gsap.from('.feature-card', {
        y: 30,
        opacity: 0,
        duration: 0.6,
        stagger: 0.15,
        delay: 1.4
      });

      // Floating background animations
      gsap.to('.floating-bg-1', {
        x: 50,
        y: -50,
        duration: 8,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut'
      });

      gsap.to('.floating-bg-2', {
        x: -50,
        y: 50,
        duration: 10,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut'
      });

      // Floating elements around illustration
      gsap.to('.floating-element-1', {
        y: -20,
        x: 10,
        scale: 1.2,
        duration: 3,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut'
      });

      gsap.to('.floating-element-2', {
        y: 15,
        x: -15,
        scale: 0.8,
        duration: 4,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut'
      });

      // Input focus animations
      document.querySelectorAll('input, select, textarea').forEach(input => {
        input.addEventListener('focus', function() {
          gsap.to(this, {
            scale: 1.01,
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

      // Button hover animations
      document.querySelectorAll('button[type="submit"]').forEach(button => {
        button.addEventListener('mouseenter', function() {
          gsap.to(this, {
            scale: 1.02,
            duration: 0.2,
            ease: 'power2.out'
          });
        });

        button.addEventListener('mouseleave', function() {
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
