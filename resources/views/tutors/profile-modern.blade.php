@extends('layouts.public')

@section('content')
@if(session('toast_error'))
  <div class="fixed top-4 right-4 z-50 bg-red-50 text-red-700 border border-red-200 px-4 py-2 rounded-lg shadow">{{ session('toast_error') }}</div>
@endif
<main class="max-w-7xl mx-auto px-4 py-6 sm:py-10 text-[14px]">
  <section class="bg-white rounded-2xl border border-gray-200 p-6 sm:p-8 mb-6">
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-6">
      <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 text-center sm:text-left">
        @php
          $pp = $tutor->user->profile_picture ?? '';
          $ppUrl = $pp ? (Str::startsWith($pp, ['/storage','http'])) ? asset(ltrim($pp,'/')) : asset('storage/'.ltrim($pp,'/')) : '';
        @endphp
        @if($ppUrl)
          <img src="{{ $ppUrl }}" class="w-24 h-24 sm:w-28 sm:h-28 rounded-full object-cover" alt="{{ $tutor->user->name }}"/>
        @else
          <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full bg-primary/20 flex items-center justify-center">
            <span class="text-primary font-extrabold text-3xl">{{ substr($tutor->user->name, 0, 1) }}</span>
          </div>
        @endif
        <div>
          <div class="flex items-center gap-2 mb-1">
            <h1 class="text-2xl sm:text-3xl font-black">{{ $tutor->user->name }}</h1>
            @if($tutor->is_verified_badge)
              <span class="material-symbols-outlined text-green-600" title="Verified">verified</span>
            @endif
          </div>
          <div class="flex flex-wrap items-center gap-3 text-gray-600">
            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-yellow-500">star</span> <b>{{ number_format($tutor->average_rating,1) }}</b> / 5</span>
            <span class="flex items-center gap-1"><span class="material-symbols-outlined">location_on</span> {{ $tutor->city ?? $tutor->location ?? '—' }} @if($tutor->pin_code) ({{ $tutor->pin_code }}) @endif</span>
            @if($tutor->teaching_mode)
              <span class="flex items-center gap-1"><span class="material-symbols-outlined">deployed_code</span> {{ ucfirst($tutor->teaching_mode) }}</span>
            @endif
          </div>
        </div>
      </div>
      <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
        <a href="{{ route('booking.create', $tutor->user_id) }}?type=consultation" class="flex-1 sm:flex-none px-5 py-2.5 bg-white border border-primary text-primary rounded-lg font-semibold hover:bg-primary/5">Book Consultation (₹{{ (int)$tutor->hourly_rate }})</a>
        <a href="{{ route('booking.create', $tutor->user_id) }}" class="flex-1 sm:flex-none px-5 py-2.5 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90">Book Session</a>
        @auth
          @if(auth()->user()->isStudent())
            <button id="wishBtn" onclick="toggleWishlist('{{ route('student.tutor.toggle-like', $tutor->id ?? $tutor->user_id) }}')" class="px-5 py-2.5 border rounded-lg font-semibold flex items-center gap-2 {{ (!empty($isLiked) && $isLiked) ? 'border-red-300 text-red-600' : '' }}">
              <span class="material-symbols-outlined">{{ (!empty($isLiked) && $isLiked) ? 'favorite' : 'favorite_border' }}</span>
              <span>{{ (!empty($isLiked) && $isLiked) ? 'Saved' : 'Add to Wishlist' }}</span>
            </button>
          @elseif(auth()->user()->isParent())
            <button id="wishBtn" onclick="toggleWishlist('{{ route('parent.tutor.toggle-like', $tutor->id ?? $tutor->user_id) }}')" class="px-5 py-2.5 border rounded-lg font-semibold flex items-center gap-2">
              <span class="material-symbols-outlined">favorite_border</span>
              <span>Add to Wishlist</span>
            </button>
          @endif
        @else
          <a href="{{ route('login') }}" class="px-5 py-2.5 border rounded-lg font-semibold flex items-center gap-2">Login to Save</a>
        @endauth
      </div>
    </div>
  </section>

  <div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
      <section class="bg-white rounded-2xl border border-gray-200 p-6">
        <h2 class="text-xl font-bold mb-3">About</h2>
        <p class="text-gray-700 leading-relaxed">{{ $tutor->bio ?? '—' }}</p>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mt-5">
          <div class="flex items-start gap-2">
            <span class="material-symbols-outlined text-primary">workspace_premium</span>
            <div>
              <div class="text-gray-500">Experience</div>
              <div class="font-semibold">{{ (int)$tutor->experience_years }}+ years</div>
            </div>
          </div>
          <div class="flex items-start gap-2">
            <span class="material-symbols-outlined text-primary">school</span>
            <div>
              <div class="text-gray-500">Qualification</div>
              <div class="font-semibold">{{ $tutor->qualification ?? '—' }}</div>
            </div>
          </div>
          <div class="flex items-start gap-2">
            <span class="material-symbols-outlined text-primary">transgender</span>
            <div>
              <div class="text-gray-500">Gender</div>
              <div class="font-semibold">{{ ucfirst($tutor->gender ?? '—') }}</div>
            </div>
          </div>
          <div class="flex items-start gap-2 col-span-2 sm:col-span-1">
            <span class="material-symbols-outlined text-primary">chat</span>
            <div>
              <div class="text-gray-500">Languages</div>
              <div class="font-semibold">{{ count($languages) ? implode(', ', $languages) : '—' }}</div>
            </div>
          </div>
          <div class="flex items-start gap-2 col-span-2">
            <span class="material-symbols-outlined text-primary">sell</span>
            <div>
              <div class="text-gray-500">Consultation Fee</div>
              <div class="font-semibold">₹{{ (int)$tutor->hourly_rate }} per hour</div>
            </div>
          </div>
        </div>
      </section>

      <section class="bg-white rounded-2xl border border-gray-200 p-6">
        <h2 class="text-xl font-bold mb-3">Teaching Preferences</h2>
        <div class="grid sm:grid-cols-2 gap-4">
          <div class="p-4 rounded-xl border">
            <div class="flex items-center gap-2 mb-1"><span class="material-symbols-outlined text-primary">wifi</span><b>Online</b></div>
            <div class="text-gray-600">{{ in_array($tutor->teaching_mode, ['online','both']) ? 'Available' : 'Not available' }}</div>
          </div>
          <div class="p-4 rounded-xl border">
            <div class="flex items-center gap-2 mb-1"><span class="material-symbols-outlined text-primary">home</span><b>At tutor’s location</b></div>
            <div class="text-gray-600">{{ in_array($tutor->teaching_mode, ['offline','both']) ? 'Available' : 'Not available' }}</div>
          </div>
          <div class="p-4 rounded-xl border sm:col-span-2">
            <div class="flex items-center gap-2 mb-1"><span class="material-symbols-outlined text-primary">pin_drop</span><b>At student’s location</b></div>
            <div class="text-gray-600">@if(in_array($tutor->teaching_mode,['offline','both']) && $tutor->travel_radius_km) Travels up to <b>{{ $tutor->travel_radius_km }} km</b> @else Not specified @endif</div>
          </div>
        </div>
        @if($gradeLevels && count($gradeLevels))
        <div class="mt-4">
          <div class="text-gray-500 mb-1">Grades/Levels</div>
          <div class="flex flex-wrap gap-2">
            @foreach($gradeLevels as $gl)
              <span class="px-3 py-1 bg-gray-100 rounded-full text-gray-700">{{ strtoupper(is_string($gl)?$gl:json_encode($gl)) }}</span>
            @endforeach
          </div>
        </div>
        @endif
      </section>

      <section class="bg-white rounded-2xl border border-gray-200 p-6">
        <h2 class="text-xl font-bold mb-3">Subjects & Rates</h2>
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead>
              <tr class="border-b">
                <th class="text-left py-2">Subject</th>
                <th class="text-left py-2">Online</th>
                <th class="text-left py-2">Offline</th>
              </tr>
            </thead>
            <tbody>
              @forelse($subjectsDetailed as $row)
                <tr class="border-b last:border-0">
                  <td class="py-2 font-medium">{{ $row->subject }}</td>
                  <td class="py-2">
                    @if($row->is_online_available)
                      <span class="inline-flex items-center gap-1 text-green-700"><span class="material-symbols-outlined text-sm">check_circle</span> ₹{{ (int)$row->online_rate }}</span>
                    @else
                      <span class="inline-flex items-center gap-1 text-gray-500"><span class="material-symbols-outlined text-sm">cancel</span> —</span>
                    @endif
                  </td>
                  <td class="py-2">
                    @if($row->is_offline_available)
                      <span class="inline-flex items-center gap-1 text-green-700"><span class="material-symbols-outlined text-sm">check_circle</span> ₹{{ (int)$row->offline_rate }}</span>
                    @else
                      <span class="inline-flex items-center gap-1 text-gray-500"><span class="material-symbols-outlined text-sm">cancel</span> —</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr><td colspan="3" class="py-3 text-gray-500">No subjects added yet</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </section>

      <section class="bg-white rounded-2xl border border-gray-200 p-6">
        <h2 class="text-xl font-bold mb-3">Reviews</h2>
        @forelse($tutor->reviews()->latest()->take(6)->get() as $review)
          <div class="mb-4 pb-4 border-b last:border-0">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-1 text-yellow-500">
                @for($i=1;$i<=5;$i++)
                  <span class="material-symbols-outlined text-sm">{{ $i <= $review->rating ? 'star' : 'star_outline' }}</span>
                @endfor
              </div>
              <span class="text-gray-500">{{ $review->student->name }}</span>
            </div>
            <p class="text-gray-700 mt-1">{{ $review->review_text }}</p>
          </div>
        @empty
          <div class="text-gray-500">No reviews yet.</div>
        @endforelse
      </section>
    </div>

    <aside class="space-y-6">
      <div class="bg-white rounded-2xl border border-gray-200 p-6 sticky top-4">
        <h3 class="text-lg font-bold mb-3">Book with {{ $tutor->user->name }}</h3>
        <div class="space-y-2 text-gray-700">
          <div class="flex items-center justify-between">
            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-primary">support_agent</span> Consultation</span>
            <span class="font-bold">₹{{ (int)$tutor->hourly_rate }}/hr</span>
          </div>
        </div>
        <div class="mt-4 grid grid-cols-1 gap-3">
          <a href="{{ route('booking.create', $tutor->user_id) }}?type=consultation" class="px-4 py-2.5 border border-primary text-primary rounded-lg font-semibold hover:bg-primary/5">Book Consultation</a>
          <a href="{{ route('booking.create', $tutor->user_id) }}" class="px-4 py-2.5 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90">Book a Session</a>
        </div>
        <p class="text-xs text-gray-500 mt-3">You’ll be asked to log in or sign up to continue.</p>
      </div>
    </aside>
  </div>
</main>

@push('scripts')
<script>
function toggleWishlist(url){
  fetch(url, {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}','X-Requested-With':'XMLHttpRequest'}})
    .then(r=>r.json()).then(d=>{
      const btn=document.getElementById('wishBtn');
      if(!btn) return;
      const icon=btn.querySelector('.material-symbols-outlined');
      const text=btn.querySelector('span:last-child');
      if(d.liked){ btn.classList.add('border-red-300','text-red-600'); icon.textContent='favorite'; text.textContent='Saved'; }
      else { btn.classList.remove('border-red-300','text-red-600'); icon.textContent='favorite_border'; text.textContent='Add to Wishlist'; }
    }).catch(()=>{});
}
</script>
@endpush
@endsection
