@extends('layouts.public')

 <title>{{ $tutor->user->name }} - Tutor Profile - Htc</title>

@section('content')
<main class="max-w-7xl mx-auto px-4 py-6 sm:py-10">
  <!-- Tutor Header -->
  <section class="bg-white rounded-xl border border-gray-200 p-5 sm:p-8 mb-6">
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-6">
      <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 text-center sm:text-left">
        @if($tutor->user->profile_picture)
        <img src="{{ asset('storage/' . $tutor->user->profile_picture) }}" class="w-28 h-28 sm:w-32 sm:h-32 rounded-full object-cover" alt="{{ $tutor->user->name }}" />
        @else
        <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-full bg-primary/20 flex items-center justify-center">
          <span class="text-primary font-bold text-5xl">{{ substr($tutor->user->name, 0, 1) }}</span>
        </div>
        @endif

        <div>
          <h1 class="text-3xl sm:text-4xl font-black mb-2">{{ $tutor->user->name }}</h1>
          <div class="flex flex-wrap items-center justify-center sm:justify-start gap-3 text-gray-600 mb-3">
            <div class="flex items-center gap-1">
              <span class="material-symbols-outlined text-yellow-500">star</span>
              <span class="font-semibold">{{ number_format($tutor->average_rating, 1) }}/5</span>
            </div>
            @if($tutor->is_verified_badge)
            <div class="flex items-center gap-1">
              <span class="material-symbols-outlined text-green-600">verified</span>
              <span class="text-green-600 font-semibold">Verified</span>
            </div>
            @endif
            <div class="flex items-center gap-1">
              <span class="material-symbols-outlined">location_on</span>
              <span>{{ $tutor->location ?? ' ' }}</span>
            </div>
          </div>
        </div>
      </div>

      <a href="#booking" class="w-full sm:w-auto text-center px-6 py-3 bg-primary text-white rounded-lg font-bold text-lg hover:bg-primary/90 transition">
        Book a Trial Session
      </a>
    </div>
  </section>

  <div class="grid lg:grid-cols-3 gap-6">
    <!-- Left Column -->
    <div class="lg:col-span-2 space-y-6">
      <!-- About -->
      <section class="bg-white rounded-xl border border-gray-200 p-5 sm:p-6">
        <h2 class="text-2xl font-bold mb-4">About {{ $tutor->user->name }}</h2>
        <p class="text-gray-700 leading-relaxed">{{ $tutor->bio ?? 'A passionate educator with a proven track record...' }}</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mt-6">
          <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
              <span class="material-symbols-outlined text-primary text-2xl">workspace_premium</span>
            </div>
            <div>
              <p class="text-sm text-gray-500">Experience</p>
              <p class="font-bold">{{ $tutor->experience_years }}+ Years</p>
            </div>
          </div>
          <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
              <span class="material-symbols-outlined text-primary text-2xl">translate</span>
            </div>
            <div>
              <p class="text-sm text-gray-500">Languages</p>
              <p class="font-bold">English, Spanish</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Subjects -->
      <section class="bg-white rounded-xl border border-gray-200 p-5 sm:p-6">
        <h2 class="text-2xl font-bold mb-4">Subjects & Hourly Rates</h2>
        <div class="overflow-x-auto">
          <table class="w-full text-sm sm:text-base">
            <thead>
              <tr class="border-b border-gray-200">
                <th class="text-left py-3 font-semibold">Subject</th>
                <th class="text-left py-3 font-semibold">Mode</th>
                <th class="text-right py-3 font-semibold">Hourly Rate</th>
              </tr>
            </thead>
            <tbody>
              @foreach($tutor->subjects as $subject)
              <tr class="border-b border-gray-100">
                <td class="py-3 font-medium">{{ $subject->name }}</td>
                <td class="py-3">
                  @if($tutor->teaching_mode == 'online')
                  <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full font-semibold">Online</span>
                  @elseif($tutor->teaching_mode == 'offline')
                  <span class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full font-semibold">Offline</span>
                  @else
                  <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full font-semibold mr-1">Online</span>
                  <span class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full font-semibold">Offline</span>
                  @endif
                </td>
                <td class="py-3 text-right font-bold">₹{{ number_format($tutor->hourly_rate, 0) }}/hr</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </section>

      <!-- Reviews -->
      <section class="bg-white rounded-xl border border-gray-200 p-5 sm:p-6">
        <h2 class="text-2xl font-bold mb-5">What Students Are Saying</h2>
        @forelse($tutor->reviews()->latest()->take(3)->get() as $review)
        <div class="mb-5 pb-5 border-b border-gray-100 last:border-0">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2 gap-1">
            <div class="flex items-center gap-1 text-yellow-500">
              @for($i = 1; $i <= 5; $i++)
              <span class="material-symbols-outlined text-sm">{{ $i <= $review->rating ? 'star' : 'star_outline' }}</span>
              @endfor
            </div>
            <span class="text-sm text-gray-500">{{ $review->student->name }}</span>
          </div>
          <p class="text-gray-700 italic text-sm sm:text-base">"{{ $review->review_text }}"</p>
        </div>
        @empty
        <p class="text-gray-500 text-center py-6">No reviews yet</p>
        @endforelse
      </section>
    </div>

    <!-- Right Column (Availability) -->
    <aside class="space-y-6">
      <div class="bg-white rounded-xl border border-gray-200 p-5 sm:p-6 sticky top-4" id="booking">
        <h2 class="text-2xl font-bold mb-4">My Weekly Availability</h2>
        <div class="mb-4">
          <div class="flex items-center justify-between mb-3">
            <button onclick="changeWeek(-1)" class="p-2 hover:bg-gray-100 rounded-lg">
              <span class="material-symbols-outlined">chevron_left</span>
            </button>
            <span class="font-semibold" id="weekDisplay">October 21-27</span>
            <button onclick="changeWeek(1)" class="p-2 hover:bg-gray-100 rounded-lg">
              <span class="material-symbols-outlined">chevron_right</span>
            </button>
          </div>
          <div class="grid grid-cols-7 gap-1 text-[11px] sm:text-xs text-center text-gray-600 mb-2">
            <div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div><div>Sun</div>
          </div>
        </div>

        <div class="space-y-4">
          <div>
            <h3 class="font-semibold mb-2 text-sm text-gray-600">Morning</h3>
            <div class="flex flex-wrap gap-2">
              <button onclick="selectSlot(this, '9:00 AM')" class="slot-btn">9:00 AM</button>
              <button disabled class="slot-btn-disabled">10:00 AM</button>
              <button onclick="selectSlot(this, '11:00 AM')" class="slot-btn">11:00 AM</button>
            </div>
          </div>

          <div>
            <h3 class="font-semibold mb-2 text-sm text-gray-600">Afternoon</h3>
            <div class="flex flex-wrap gap-2">
              <button onclick="selectSlot(this, '2:00 PM')" class="slot-btn">2:00 PM</button>
              <button onclick="selectSlot(this, '3:00 PM')" class="slot-btn">3:00 PM</button>
              <button onclick="selectSlot(this, '4:00 PM')" class="slot-btn active">4:00 PM</button>
            </div>
          </div>

          <div>
            <h3 class="font-semibold mb-2 text-sm text-gray-600">Evening</h3>
            <div class="flex flex-wrap gap-2">
              <button disabled class="slot-btn-disabled">6:00 PM</button>
              <button onclick="selectSlot(this, '7:00 PM')" class="slot-btn">7:00 PM</button>
              <button disabled class="slot-btn-disabled">8:00 PM</button>
            </div>
          </div>
        </div>

        <a href="{{ route('booking.create', $tutor->user_id) }}" class="block w-full py-3 mt-5 bg-primary text-white text-center rounded-lg font-bold hover:bg-primary/90 transition">
          Book a Trial Session
        </a>
      </div>
    </aside>
  </div>
</main>

<script>
  let selectedSlot = null;

  function selectSlot(button, time) {
    if (selectedSlot) {
      selectedSlot.classList.remove('bg-primary', 'text-white');
      selectedSlot.classList.add('text-primary');
    }
    button.classList.add('bg-primary', 'text-white');
    button.classList.remove('text-primary');
    selectedSlot = button;
    console.log('Selected time:', time);
  }

  function changeWeek(direction) {
    console.log('Change week by', direction);
  }

  // Mobile nav toggle
  document.getElementById('menuToggle').addEventListener('click', () => {
    document.getElementById('mobileMenu').classList.toggle('hidden');
  });
</script>

<style>
  .slot-btn {
    @apply px-4 py-2 border border-primary text-primary rounded-lg text-sm font-medium hover:bg-primary hover:text-white transition-colors;
  }
  .slot-btn-disabled {
    @apply px-4 py-2 border border-gray-300 text-gray-400 rounded-lg text-sm font-medium cursor-not-allowed;
  }
  .slot-btn.active {
    @apply bg-primary text-white;
  }
</style>

</body>
</html>
@endsection
