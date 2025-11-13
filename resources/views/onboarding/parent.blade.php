<!DOCTYPE html>
<html class="light" lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>Add Learner - HTC</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
</head>
<body class="bg-page-bg font-sans text-sm text-black min-h-screen p-4 md:p-8 flex items-center justify-center">
  <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-header-chunky border-2 border-black p-10 w-full">
    <!-- Header/Illustration Section -->
    <div class="mb-8 text-center">
      <h1 class="font-heading text-h2 uppercase mb-2">Add your learner</h1>
      <p class="text-sm text-text-subtle max-w-md mx-auto">Tell us about your child so we can match them with the perfect tutor</p>
    </div>

    <!-- Success/Error messages (unchanged, but colors updated)-->
    @if(session('success'))
      <div class="mb-6 p-3 rounded-lg border border-green-200 bg-green-50 text-green-700 font-medium flex gap-2 items-center">
        <span class="material-symbols-outlined">check_circle</span>
        {{ session('success') }}
      </div>
    @endif
    @if($errors->any())
      <div class="mb-6 p-3 rounded-lg border border-red-200 bg-red-50 text-red-700 font-medium flex gap-2 items-center">
        <span class="material-symbols-outlined">error</span>
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('onboarding.parent.child.store') }}" enctype="multipart/form-data" class="space-y-6">
      @csrf
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block font-bold text-black mb-1.5 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary text-lg">person</span>
            Child's First Name
          </label>
          <input 
            name="first_name" 
            value="{{ old('first_name') }}"
            class="w-full rounded-lg border-2 border-black bg-white px-4 py-2.5 text-sm text-black focus:border-primary focus:ring-2 focus:ring-primary/50 outline-none" 
            placeholder="Enter first name"
            required
          />
        </div>
        <div>
          <label class="block font-bold text-black mb-1.5 flex items-center gap-2">
            <span class="material-symbols-outlined text-accent-yellow text-lg">cake</span>
            Age
          </label>
          <input
            type="number"
            name="age"
            min="1"
            max="20"
            value="{{ old('age') }}"
            class="w-full rounded-lg border-2 border-black bg-white px-4 py-2.5 text-sm text-black focus:border-primary focus:ring-2 focus:ring-primary/50 outline-none"
            placeholder="Enter age"
          />
        </div>
      </div>
      <div>
        <label class="block font-bold text-black mb-1.5 flex items-center gap-2">
          <span class="material-symbols-outlined text-primary text-lg">school</span>
          Class/Slab
        </label>
        <select
          name="class_slab"
          class="w-full rounded-lg border-2 border-black bg-white px-4 py-2.5 text-sm text-black focus:border-primary focus:ring-2 focus:ring-primary/50 outline-none"
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
      <div>
        <label class="block font-bold text-black mb-1.5 flex items-center gap-2">
          <span class="material-symbols-outlined text-accent-yellow text-lg">photo_camera</span>
          Profile Photo
          <span class="text-xs font-normal text-text-subtle">(optional)</span>
        </label>
        <input
          type="file"
          name="profile_photo"
          accept="image/*"
          class="w-full text-sm text-black file:mr-3 file:px-3 file:py-1.5 file:rounded-lg file:border-0 file:bg-accent-yellow file:font-bold file:text-black hover:file:bg-accent-yellow/80"
        />
      </div>
      <div>
        <label class="block font-bold text-black mb-1.5 flex items-center gap-2">
          <span class="material-symbols-outlined text-primary text-lg">flag</span>
          Learning Goals
          <span class="text-xs font-normal text-text-subtle">(optional)</span>
        </label>
        <textarea
          name="goals"
          rows="3"
          class="w-full rounded-lg border-2 border-black bg-white px-4 py-2.5 text-sm text-black focus:border-primary focus:ring-2 focus:ring-primary/50 outline-none resize-none"
          placeholder="e.g., Master multiplication tables, improve reading comprehension, learn basic coding"
        >{{ old('goals') }}</textarea>
      </div>
      <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 pt-4">
        <button
          type="submit"
          name="add_another"
          value="1"
          class="bg-accent-yellow border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 px-6 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active flex items-center gap-2"
        >
          <span class="material-symbols-outlined text-lg">add</span>
          Save & Add Another
        </button>
        <button
          type="submit"
          class="bg-accent-yellow border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 px-6 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active flex items-center gap-2"
        >
          Complete Setup
          <span class="material-symbols-outlined text-lg">arrow_forward</span>
        </button>
      </div>
      <div class="mt-6 p-4 bg-steps-bg rounded-xl border border-black/10 flex gap-3 items-start">
        <span class="material-symbols-outlined text-primary text-xl flex-shrink-0">info</span>
        <span class="text-xs text-black"><span class="font-semibold">Quick tip:</span> You can manage multiple learners from your dashboard. Add all your children now or come back later to add more.</span>
      </div>
    </form>
  </div>
</body>
</html>
