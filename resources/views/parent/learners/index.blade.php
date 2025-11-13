@extends('layouts.parent')

@section('content')
  <main>
    <div class="py-10 px-4 sm:px-6 lg:px-8">
      <div 
        class="max-w-7xl mx-auto space-y-6"
        x-data="{ 
          addFormOpen: false, 
          editModalOpen: false, 
          selectedLearner: null 
        }"
      >

        <!-- Header -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
          <div>
            <h1 class="text-3xl font-black text-gray-900 dark:text-white">
              My Learners
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
              Add, view, and manage your children's profiles.
            </p>
          </div>
          <div class="flex items-center gap-3">
            <a href="{{ route('parent.dashboard') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm">
              <span class="material-symbols-outlined text-base">arrow_back</span>
              Dashboard
            </a>
            <button 
              id="toggle-add-form-btn" 
              @click="addFormOpen = !addFormOpen"
              class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-[#0071b2] to-[#00639c] rounded-lg hover:shadow-lg hover:shadow-[#0071b2]/25 hover:-translate-y-0.5 transition-all duration-300"
            >
              <span class="material-symbols-outlined text-base" x-text="addFormOpen ? 'close' : 'add_circle'">add_circle</span>
              <span x-text="addFormOpen ? 'Close Form' : 'Add New Learner'">Add New Learner</span>
            </button>
          </div>
        </div>

        <!-- Add Learner Form -->
        <div 
          id="add-form-container" 
          class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-lg shadow-gray-900/5 p-6" 
          x-show="addFormOpen" 
          x-transition
          style="display: none;"
        >
          <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
            Add a New Learner
          </h2>
          <form method="POST" action="{{ route('parent.learners.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label for="first_name" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">First Name *</label>
                <input id="first_name" name="first_name" class="w-full rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3.5 py-2 text-sm text-gray-900 dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" required>
              </div>
              <div>
                <label for="age" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Age</label>
                <input id="age" name="age" type="number" min="1" max="20" class="w-full rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3.5 py-2 text-sm text-gray-900 dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
              </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label for="class_slab" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Class/Slab *</label>
                <select id="class_slab" name="class_slab" class="w-full rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3.5 py-2 text-sm text-gray-900 dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" required>
                  @foreach(['1-5','6-8','9-12','graduate','postgraduate'] as $slab)
                    <option value="{{ $slab }}">{{ strtoupper($slab) }}</option>
                  @endforeach
                </select>
              </div>
              <div>
                <label for="profile_photo" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Profile Photo</label>
                <input id="profile_photo" name="profile_photo" type="file" accept="image/*" class="w-full text-sm text-gray-700 dark:text-gray-300 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary dark:file:bg-primary/20 dark:file:text-primary/90 hover:file:bg-primary/20">
              </div>
            </div>

            <div>
              <label for="goals" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Learning Goals (optional)</label>
              <input id="goals" name="goals" class="w-full rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3.5 py-2 text-sm text-gray-900 dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" placeholder="e.g. Phonics, counting to 20">
            </div>
            
            <div class="flex items-center justify-end gap-3 pt-2">
              <button type="button" @click="addFormOpen = false" class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                Cancel
              </button>
              <button type="submit" class="px-5 py-2 text-sm font-semibold text-white bg-[#0071b2] rounded-lg hover:bg-[#005a8e] transition-all">
                Add Learner
              </button>
            </div>
          </form>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
          <div class="p-3 rounded-lg bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 text-sm border border-green-200 dark:border-green-800">
            {{ session('success') }}
          </div>
        @endif
        
        @if($errors->any())
          <div class="p-3 rounded-lg bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 text-sm border border-red-200 dark:border-red-800">
            {{ $errors->first() }}
          </div>
        @endif

        <!-- Learner Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          @forelse($children as $c)
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-lg shadow-gray-900/5 p-4">
              <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                  @php($avatar = $c->profile_photo_path ? (\Illuminate\Support\Str::startsWith($c->profile_photo_path, ['/storage','http']) ? asset(ltrim($c->profile_photo_path,'/')) : asset('storage/'.$c->profile_photo_path)) : null)
                  <div class="w-12 h-12 rounded-full overflow-hidden bg-primary/10 text-primary flex-shrink-0 flex items-center justify-center font-bold text-lg">
                    @if($avatar) 
                      <img src="{{ $avatar }}" class="w-full h-full object-cover" alt="{{ $c->first_name }}"> 
                    @else 
                      {{ strtoupper(substr($c->first_name, 0, 1)) }} 
                    @endif
                  </div>
                  <div>
                    <div class="font-bold text-gray-900 dark:text-white">{{ $c->first_name }} @if($c->age) ({{ $c->age }}) @endif</div>
                    <div class="text-xs text-gray-600 dark:text-gray-400">Class: {{ strtoupper($c->class_slab) }}</div>
                  </div>
                </div>
                
                <div class="flex items-center gap-2">
                  @if($activeChildId == $c->id)
                    <span class="text-xs px-2.5 py-1 rounded-full bg-green-100 dark:bg-green-800/30 text-green-700 dark:text-green-300 font-medium">
                      Active
                    </span>
                  @else
                    <form method="POST" action="{{ route('parent.child.switch') }}">
                      @csrf
                      <input type="hidden" name="child_id" value="{{ $c->id }}">
                      <button class="text-xs px-2.5 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                        Make Active
                      </button>
                    </form>
                  @endif
                  
                  <button 
                    @click="selectedLearner = {{ json_encode($c) }}; editModalOpen = true"
                    class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-secondary dark:hover:text-secondary transition-all"
                  >
                    <span class="material-symbols-outlined text-lg">edit</span>
                  </button>

                  <form method="POST" action="{{ route('parent.learners.delete', $c) }}" onsubmit="return confirm('Are you sure you want to delete this learner? This action cannot be undone.');">
                    @csrf 
                    @method('DELETE')
                    <button type="submit" class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-red-600 dark:hover:text-red-500 transition-all">
                      <span class="material-symbols-outlined text-lg">delete</span>
                    </button>
                  </form>
                </div>
              </div>
            </div>
          @empty
            <div class="col-span-full py-10 text-center text-gray-500 dark:text-gray-400">
              <span class="material-symbols-outlined text-4xl mb-2">person_search</span>
              <p class="text-sm">You haven't added any learners yet.</p>
            </div>
          @endforelse
        </div>

        <!-- Edit Modal -->
        <div 
          x-show="editModalOpen" 
          x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0"
          x-transition:enter-end="opacity-100"
          x-transition:leave="transition ease-in duration-200"
          x-transition:leave-start="opacity-100"
          x-transition:leave-end="opacity-0"
          class="fixed inset-0 z-50 flex items-center justify-center p-4"
          style="display: none;"
        >
          <div 
            class="fixed inset-0 bg-black/50" 
            @click="editModalOpen = false"
          ></div>

          <div 
            class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl w-full max-w-2xl z-10"
            x-show="editModalOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
          >
            <template x-if="selectedLearner">
              <form 
                method="POST" 
                :action="`/parent/learners/${selectedLearner.id}`" 
                enctype="multipart/form-data" 
                class="p-6"
              >
                @csrf
                @method('PUT')
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                  Edit Learner: <span x-text="selectedLearner.first_name"></span>
                </h2>
                
                <div class="space-y-4">
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                      <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">First Name *</label>
                      <input x-model="selectedLearner.first_name" name="first_name" class="w-full rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3.5 py-2 text-sm text-gray-900 dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" required>
                    </div>
                    <div>
                      <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Age</label>
                      <input x-model="selectedLearner.age" name="age" type="number" min="1" max="20" class="w-full rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3.5 py-2 text-sm text-gray-900 dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                    </div>
                  </div>
                  
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                      <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Class/Slab *</label>
                      <select x-model="selectedLearner.class_slab" name="class_slab" class="w-full rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3.5 py-2 text-sm text-gray-900 dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" required>
                        @foreach(['1-5','6-8','9-12','graduate','postgraduate'] as $slab)
                          <option value="{{ $slab }}">{{ strtoupper($slab) }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div>
                      <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Profile Photo (Leave blank to keep current)</label>
                      <input name="profile_photo" type="file" accept="image/*" class="w-full text-sm text-gray-700 dark:text-gray-300 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary dark:file:bg-primary/20 dark:file:text-primary/90 hover:file:bg-primary/20">
                    </div>
                  </div>

                  <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Learning Goals (optional)</label>
                    <input x-model="selectedLearner.goals" name="goals" class="w-full rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3.5 py-2 text-sm text-gray-900 dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" placeholder="e.g. Phonics, counting to 20">
                  </div>
                </div>
                
                <div class="flex items-center justify-end gap-3 pt-6">
                  <button type="button" @click="editModalOpen = false" class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                    Cancel
                  </button>
                  <button type="submit" class="px-5 py-2 text-sm font-semibold text-white bg-[#FFA500] rounded-lg hover:bg-[#E29412] transition-all">
                    Update Learner
                  </button>
                </div>
              </form>
            </template>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection
