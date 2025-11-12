@extends('layouts.parent')

@section('content')
<div class="py-10 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-black">Saved Tutors</h1>
      <a href="{{ route('tutors.search') }}" class="text-sm text-primary font-semibold hover:underline">Find more tutors</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      @forelse($likedTutors as $tutor)
      <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-5">
        <div class="flex items-start justify-between mb-3">
          <div class="flex items-center gap-3">
            @if($tutor->user->profile_picture)
              <img src="{{ asset('storage/' . $tutor->user->profile_picture) }}" class="w-12 h-12 rounded-full object-cover"/>
            @else
              <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold text-lg">{{ substr($tutor->user->name,0,1) }}</div>
            @endif
            <div>
              <div class="font-semibold">{{ $tutor->user->name }}</div>
              <div class="text-xs text-gray-500">{{ $tutor->city ?? '—' }}</div>
            </div>
          </div>
          <button onclick="toggleLike({{ $tutor->id }})" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg" title="Remove">
            <span class="material-symbols-outlined text-red-500">favorite</span>
          </button>
        </div>
        <p class="text-sm text-gray-600 dark:text-gray-300 mb-3 line-clamp-3">{{ $tutor->bio ?? '—' }}</p>
        <div class="flex gap-2">
          <a href="{{ route('tutors.profile', $tutor->user_id) }}" class="flex-1 text-center bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-200 px-4 py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 text-sm font-medium">View Profile</a>
          <a href="{{ route('booking.create', $tutor->user_id) }}" class="flex-1 text-center bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 text-sm font-medium">Book</a>
        </div>
      </div>
      @empty
      <div class="col-span-3 text-center py-12">
        <span class="material-symbols-outlined text-gray-300 text-6xl mb-3">favorite_border</span>
        <p class="text-gray-500">No tutors saved yet.</p>
        <a href="{{ route('tutors.search') }}" class="inline-block mt-4 px-5 py-2 bg-primary text-white rounded-lg">Find Tutors</a>
      </div>
      @endforelse
    </div>
  </div>
</div>

@push('scripts')
<script>
async function toggleLike(profileId){
  try {
    const res = await fetch(`/parent/tutor/${profileId}/toggle-like`, {method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'}});
    const data = await res.json();
    if(data.success){ location.reload(); }
  } catch(e){ console.error(e); }
}
</script>
@endpush
@endsection
