@extends('layouts.public')

@section('title', 'Find Tutors - HTC')

@section('content')
<div class="bg-[#fffcf0] pt-8 md:pt-28 pb-24">
  <div class="max-w-7xl mx-auto px-4">

    <!-- Filters Card -->
    <div x-data="tutorFilters()" class="relative mt-2 md:mt-4 mb-6">
      <form method="GET" action="{{ route('tutors.search') }}" @submit.prevent="submit($event)">
        <div class="bg-white border-2 border-black rounded-xl shadow-header-chunky p-4 md:p-6">
          <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
            <!-- Subject input -->
            <div class="md:col-span-6">
              <label class="block text-[11px] font-semibold text-black mb-1">Subject</label>
              <div class="border-2 border-black rounded-lg px-2 py-1.5 relative h-10 flex items-center">
                <input type="text" x-model="subjectQuery" @input.debounce.200ms="fetchSubjectSuggestions" placeholder="Type to search subjects..." class="w-full border-none focus:ring-0 text-sm h-7"/>
                <!-- Suggestions dropdown -->
                <div class="absolute z-30 bg-white border-2 border-black rounded-lg mt-1 w-full left-0 top-full" x-show="showSubjectDropdown" @click.outside="showSubjectDropdown=false">
                  <template x-if="subjectSuggestions.length === 0">
                    <div class="p-2 text-xs text-gray-500">No suggestions</div>
                  </template>
                  <template x-for="s in subjectSuggestions" :key="s.id">
                    <button type="button" class="block w-full text-left px-3 py-2 text-sm hover:bg-gray-100" @click="addSubject(s)">
                      <span x-text="s.name"></span>
                    </button>
                  </template>
                </div>
              </div>
            </div>

            <!-- City -->
            <div class="md:col-span-3">
              <label class="block text-[11px] font-semibold text-black mb-1">City</label>
              <div class="relative">
                <input type="text" name="city" x-model="cityQuery" @input.debounce.200ms="fetchCitySuggestions" placeholder="e.g., Delhi" class="w-full border-2 border-black rounded-lg px-3 py-2 text-sm" autocomplete="off"/>
                <div class="absolute z-30 bg-white border-2 border-black rounded-lg mt-1 w-full" x-show="showCityDropdown" @click.outside="showCityDropdown=false">
                  <template x-if="citySuggestions.length === 0">
                    <div class="p-2 text-xs text-gray-500">No matches</div>
                  </template>
                  <template x-for="c in citySuggestions" :key="c.id">
                    <button type="button" class="block w-full text-left px-3 py-2 text-sm hover:bg-gray-100" @click="selectCity(c.name)">
                      <span x-text="c.name"></span>
                    </button>
                  </template>
                </div>
              </div>
            </div>

            <!-- Gender -->
            <div class="md:col-span-3">
              <label class="block text-[11px] font-semibold text-black mb-1">Gender</label>
              <select name="gender" x-model="gender" class="w-full border-2 border-black rounded-lg px-3 py-2 text-sm">
                <option value="">Any</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
              </select>
            </div>
          </div>

          <!-- Selected filters row -->
          <div class="mt-3 flex flex-wrap gap-2">
            <template x-for="(s, i) in selectedSubjects" :key="'chip-'+s.id">
              <span class="inline-flex items-center gap-1 bg-accent-yellow px-2 py-0.5 rounded-md border-2 border-black text-[11px] font-semibold">
                <span x-text="s.name"></span>
                <button type="button" @click="removeSubject(i)" class="leading-none">✕</button>
                <input type="hidden" name="subjects[]" :value="s.id" />
              </span>
            </template>
            <template x-if="cityQuery">
              <span class="inline-flex items-center gap-1 bg-white px-2 py-0.5 rounded-md border-2 border-black text-[11px]">
                <span x-text="cityQuery"></span>
                <button type="button" @click="cityQuery='';" class="leading-none">✕</button>
              </span>
            </template>
            <template x-if="gender">
              <span class="inline-flex items-center gap-1 bg-white px-2 py-0.5 rounded-md border-2 border-black text-[11px]">
                <span x-text="gender"></span>
                <button type="button" @click="gender='';" class="leading-none">✕</button>
              </span>
            </template>
            <template x-if="mode">
              <span class="inline-flex items-center gap-1 bg-white px-2 py-0.5 rounded-md border-2 border-black text-[11px]">
                <span>Mode: <span x-text="mode"></span></span>
                <button type="button" @click="mode='';" class="leading-none">✕</button>
              </span>
            </template>
            <template x-if="minRating">
              <span class="inline-flex items-center gap-1 bg-white px-2 py-0.5 rounded-md border-2 border-black text-[11px]">
                <span>Rating: <span x-text="minRating"></span>+</span>
                <button type="button" @click="minRating='';" class="leading-none">✕</button>
              </span>
            </template>
            <template x-if="maxPrice">
              <span class="inline-flex items-center gap-1 bg-white px-2 py-0.5 rounded-md border-2 border-black text-[11px]">
                <span>Max ₹/hr: <span x-text="maxPrice"></span></span>
                <button type="button" @click="maxPrice='';" class="leading-none">✕</button>
              </span>
            </template>
          </div>

          <!-- Hidden fields for sidebar-bound state -->
          <input type="hidden" name="mode" :value="mode">
          <input type="hidden" name="min_rating" :value="minRating">
          <input type="hidden" name="max_price" :value="maxPrice">

          <!-- Buttons centered -->
          <div class="mt-4 flex items-center justify-center gap-3">
            <button type="reset" @click="resetFilters" class="bg-white border-2 border-black rounded-lg text-black font-bold uppercase text-xxs py-2 px-5 shadow-button-chunky hover:shadow-button-chunky-hover transition">Clear</button>
            <button type="submit" class="bg-accent-yellow border-2 border-black rounded-lg text-black font-bold uppercase text-xxs py-2 px-6 shadow-button-chunky hover:shadow-button-chunky-hover transition">Search</button>
          </div>
        </div>
      </form>
    </div>

    <!-- Content with sidebar -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
      <!-- Sidebar (desktop) -->
      <aside class="hidden lg:block lg:col-span-3">
        <div class="bg-white border-2 border-black rounded-xl p-4 sticky top-28">
          <div class="mb-3">
            <label class="block text-[11px] font-semibold text-black mb-1">Mode</label>
            <select x-model="mode" class="w-full border-2 border-black rounded-lg px-3 py-2 text-sm">
              <option value="">Any</option>
              <option value="online">Online</option>
              <option value="offline">Offline</option>
              <option value="both">Both</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="block text-[11px] font-semibold text-black mb-1">Min Rating</label>
            <select x-model="minRating" class="w-full border-2 border-black rounded-lg px-3 py-2 text-sm">
              <option value="">Any</option>
              <template x-for="r in [5,4,3,2,1]" :key="'r'+r">
                <option :value="r" x-text="r+'+'"></option>
              </template>
            </select>
          </div>
          <div class="mb-4">
            <label class="block text-[11px] font-semibold text-black mb-1">Max Price (₹/hr)</label>
            <input type="number" x-model="maxPrice" min="0" step="50" class="w-full border-2 border-black rounded-lg px-3 py-2 text-sm"/>
          </div>
          <button type="button" @click="submitFromSidebar" class="w-full bg-accent-yellow border-2 border-black rounded-lg text-black font-bold uppercase text-xxs py-2 px-5 shadow-button-chunky">Apply Filters</button>
        </div>
      </aside>

      <!-- Results grid -->
      <div class="lg:col-span-9">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-4">
          @forelse($tutors as $tutor)
        <div class="bg-white border-2 border-black rounded-xl p-4 text-[12px] shadow-button-chunky transition-all duration-150 hover:-translate-y-0.5 hover:shadow-button-chunky-hover">
          <div class="flex items-center gap-3 mb-3">
            @php $pp = $tutor->user->profile_picture; $ppUrl = $pp ? (\Illuminate\Support\Str::startsWith($pp, ['/storage','http']) ? asset(ltrim($pp,'/')) : asset('storage/'.$pp)) : null; @endphp
            @if($ppUrl)
              <div class="relative">
                <img src="{{ $ppUrl }}" class="w-14 h-14 rounded-full object-cover border" alt="{{ $tutor->user->name }}">
                @if($tutor->is_verified_badge)
                  <span class="material-symbols-outlined text-green-600 text-[16px] absolute -right-1 -bottom-1 bg-white rounded-full border">verified</span>
                @endif
              </div>
            @else
              <div class="w-14 h-14 rounded-full bg-primary/20 flex items-center justify-center border">
                <span class="text-primary font-bold text-lg">{{ substr($tutor->user->name,0,1) }}</span>
              </div>
            @endif
            <div class="min-w-0">
              <div class="font-semibold truncate">{{ $tutor->user->name }}</div>
              @if(($tutor->average_rating ?? 0) > 0)
                <div class="text-xs text-yellow-600 inline-flex items-center gap-0.5">{{ number_format($tutor->average_rating,1) }} <span class="material-symbols-outlined text-xs">star</span></div>
              @endif
              <div class="text-xs text-gray-600 truncate">{{ $tutor->city ?? $tutor->location ?? '—' }}</div>
            </div>
          </div>
          <div class="flex flex-wrap gap-1 mb-3">
            @foreach($tutor->subjects->take(3) as $s)
              <span class="px-2 py-0.5 bg-gray-100 rounded-full text-gray-700 text-[11px]">{{ $s->name }}</span>
            @endforeach
          </div>
          <div class="flex items-center justify-between">
            <div class="text-sm"><span class="font-bold">₹{{ number_format($tutor->hourly_rate,0) }}</span><span class="text-gray-500 text-[11px]">/hr</span></div>
            <a href="{{ route('tutors.profile', $tutor->user_id) }}" class="text-primary font-bold uppercase text-[11px]">View</a>
          </div>
        </div>
      @empty
        <div class="col-span-full text-center py-16 text-gray-600">No tutors found.</div>
          @endforelse
        </div>

        @if($tutors->hasPages())
          <div class="flex justify-center mt-6">
            {{ $tutors->links() }}
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  function tutorFilters(){
    return {
      // state
      subjectQuery: '',
      subjectSuggestions: [],
      selectedSubjects: [],
      showSubjectDropdown: false,

      cityQuery: @json(request('city','')),
      citySuggestions: [],
      showCityDropdown: false,

      gender: @json(request('gender','')),
      mode: @json(request('mode','')),
      minRating: @json(request('min_rating','')),
      maxPrice: @json(request('max_price','')),

      async fetchSubjectSuggestions(){
        const q = this.subjectQuery.trim();
        this.showSubjectDropdown = true;
        try{
          const res = await fetch(`{{ route('subjects.suggest') }}?q=`+encodeURIComponent(q));
          const data = await res.json();
          this.subjectSuggestions = data.filter(d=>!this.selectedSubjects.find(s=>s.id===d.id));
        }catch(e){ this.subjectSuggestions = []; }
      },
      addSubject(s){
        if(!this.selectedSubjects.find(x=>x.id===s.id)) this.selectedSubjects.push(s);
        this.subjectQuery = '';
        this.subjectSuggestions = [];
        this.showSubjectDropdown = false;
      },
      removeSubject(i){ this.selectedSubjects.splice(i,1); },

      async fetchCitySuggestions(){
        const q = this.cityQuery.trim();
        this.showCityDropdown = true;
        try{
          const res = await fetch(`{{ route('cities.suggest') }}?q=`+encodeURIComponent(q));
          this.citySuggestions = await res.json();
        }catch(e){ this.citySuggestions = []; }
      },
      selectCity(name){ this.cityQuery = name; this.showCityDropdown=false; },

      resetFilters(){
        this.selectedSubjects = [];
        this.cityQuery = '';
        this.gender = '';
        this.mode = '';
        this.minRating = '';
        this.maxPrice = '';
      },

      submit(e){
        e.target.closest('form').submit();
      },

      submitFromSidebar(){
        const f = document.querySelector('form[action="{{ route('tutors.search') }}"]');
        if (f) f.requestSubmit();
      }
    }
  }
</script>
@endpush
@endsection
