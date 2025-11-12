@extends('layouts.parent')

@section('content')
<div class="py-10 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto space-y-8">

    {{-- HEADER + SWITCHER --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
      <div>
        <h1 class="text-2xl font-black text-gray-900 dark:text-white">
          Hello, {{ auth()->user()->first_name ?? 'Parent' }}!
        </h1>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
          Welcome to your dashboard. Here's what's happening.
        </p>
      </div>

      <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">

        {{-- CHILD SWITCHER --}}
        <form method="POST" action="{{ route('parent.child.switch') }}" class="flex items-center gap-2">
          @csrf
          <label class="text-sm font-semibold text-gray-800 dark:text-gray-200 flex-shrink-0 hidden sm:block">
            Viewing for:
          </label>
          <div class="relative">
            <select 
              name="child_id" 
              class="text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white rounded-lg pl-3 pr-8 py-2.5 focus:ring-[#0071b2] focus:border-[#0071b2] transition-all appearance-none"
              onchange="this.form.submit()"
            >
              @foreach($children as $c)
                <option value="{{ $c->id }}" @selected(optional($activeChild)->id === $c->id)>
                  {{ $c->first_name }}
                </option>
              @endforeach
            </select>
            <span class="material-symbols-outlined text-gray-400 absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none">
              unfold_more
            </span>
          </div>

        </form>

        {{-- MANAGE LEARNERS BUTTON --}}
        <a href="{{ route('parent.learners') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm">
          <span class="material-symbols-outlined text-base">group</span>
          Manage Learners
          <span class="material-symbols-outlined text-base">chevron_right</span>
        </a>
      </div>
    </div>

    @if(session('success'))
    <div class="p-3 rounded-lg bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 text-sm border border-green-200 dark:border-green-800">
      {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      
      <div class="lg:col-span-2 space-y-6">

        {{-- UPCOMING SESSIONS --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-lg shadow-gray-900/5 p-6">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">
              Upcoming Sessions @if($activeChild) for {{ $activeChild->first_name }} @endif
            </h2>
            <a href="{{ route('tutors.search') }}" class="text-sm text-[#0071b2] font-semibold hover:underline">
              Find a Tutor
            </a>
          </div>
          <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($upcoming as $b)
              <div class="py-4 flex flex-col gap-2">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-sm">
                  <div class="font-medium text-gray-800 dark:text-gray-200">
                    {{ $b->session_date->format('l, d M, Y') }}
                    <span class="text-gray-500 dark:text-gray-400 font-normal ml-2">{{ $b->session_start_time }} - {{ $b->session_end_time }}</span>
                  </div>
                  <div class="text-gray-600 dark:text-gray-400">
                    {{ ucfirst($b->session_type) }} • <span class="font-semibold text-gray-800 dark:text-gray-200">₹{{ number_format($b->amount,2) }}</span>
                  </div>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs text-gray-600 dark:text-gray-400">
                  <div class="flex flex-wrap items-center gap-x-4 gap-y-1">
                    <span>Booking: <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $b->booking_code }}</span></span>
                    <span>Subject: <span class="font-semibold text-gray-800 dark:text-gray-200">{{ optional($b->subject)->name }}</span></span>
                    <span>Tutor: <span class="font-semibold text-gray-800 dark:text-gray-200">{{ optional($b->tutor)->name }}</span></span>
                    @if($b->isOffline() && $b->location_address)
                      <span>Location: <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $b->location_address }}</span></span>
                    @endif
                  </div>
                  <div class="flex items-center gap-2">
                    @if($b->isOnline() && $b->meet_link && $b->isConfirmed())
                      <a href="{{ $b->meet_link }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-[#0071b2] text-white font-semibold hover:bg-[#00639c] transition">
                        <span class="material-symbols-outlined text-base">videocam</span>
                        Join Meeting
                      </a>
                      <button type="button" onclick="navigator.clipboard.writeText('{{ $b->meet_link }}')" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <span class="material-symbols-outlined text-base">content_copy</span>
                        Copy Link
                      </button>
                    @elseif($b->isOnline())
                      <span class="text-[11px] text-amber-600 font-medium">Waiting for confirmation to enable join link</span>
                    @endif
                  </div>
                </div>
              </div>
            @empty
              <div class="py-10 text-center text-gray-500 dark:text-gray-400">
                <span class="material-symbols-outlined text-4xl mb-2">calendar_month</span>
                <p class="text-sm">No upcoming sessions.</p>
              </div>
            @endforelse
          </div>
        </div>

        {{-- SAVED TUTORS --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-lg shadow-gray-900/5 p-6">
          <div class="flex items-center justify-between mb-2">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Saved Tutors</h2>
            <a href="{{ route('parent.wishlist') }}" class="text-sm text-[#0071b2] font-semibold hover:underline">View all</a>
          </div>
          @if(($savedTutors ?? collect())->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              @foreach($savedTutors as $t)
                <div class="p-3 rounded-lg border dark:border-gray-700 flex items-center gap-3">
                  @if($t->user->profile_picture)
                    <img src="{{ asset('storage/' . $t->user->profile_picture) }}" class="w-10 h-10 rounded-full object-cover"/>
                  @else
                    <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold">{{ substr($t->user->name,0,1) }}</div>
                  @endif
                  <div class="flex-1">
                    <div class="font-semibold text-sm text-gray-900 dark:text-white">{{ $t->user->name }}</div>
                    <div class="text-xs text-gray-500">{{ $t->city ?? '—' }}</div>
                  </div>
                  <a href="{{ route('tutors.profile', $t->user_id) }}" class="text-xs px-3 py-1.5 border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800">Profile</a>
                </div>
              @endforeach
            </div>
          @else
            <div class="py-10 text-center text-gray-500 dark:text-gray-400">
              <span class="material-symbols-outlined text-4xl mb-2">bookmark</span>
              <p class="text-sm">No saved tutors yet.</p>
              <a href="{{ route('tutors.search') }}" class="inline-block mt-3 text-sm text-[#0071b2] font-semibold hover:underline">Find Tutors</a>
            </div>
          @endif
        </div>

        {{-- LEARNING GOALS --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-lg shadow-gray-900/5 p-6">
          <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-3">
            Learning Goals @if($activeChild) for {{ $activeChild->first_name }} @endif
          </h2>
          <p class="text-sm text-gray-700 dark:text-gray-300">
            {{ $activeChild?->goals ?: 'No learning goals set yet.' }}
          </p>
        </div>

      </div>

      {{-- SIDEBAR SECTION --}}
      <div class="space-y-6">
        
        {{-- WALLET --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-lg shadow-gray-900/5 p-6 overflow-hidden">
          <div class="flex items-center justify-between gap-4">
            <div>
              <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                Wallet
              </h3>
              <div class="text-3xl font-black text-gray-900 dark:text-white mt-2">
                ₹{{ number_format(auth()->user()->wallet->balance, 2) }}
              </div>
              <div class="mt-4 flex items-center gap-2">
                <button type="button" onclick="showDevToast()" class="px-4 py-2 bg-gradient-to-r from-[#0071b2] to-[#00639c] text-white text-xs font-semibold rounded-lg hover:shadow-lg hover:shadow-[#0071b2]/25 hover:-translate-y-0.5 transition-all duration-300">
                  Add Funds
                </button>
                <a href="{{ route('parent.wallet') }}" class="px-4 py-2 text-xs font-semibold border border-gray-300 rounded-lg hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-800">
                  View Details
                </a>
              </div>
            </div>
            <div class="flex-shrink-0">
              <img src="{{ asset('images/onboard/wallet.svg') }}" alt="wallet" class="w-24 h-24">
            </div>
          </div>
        </div>

        {{-- TALK TO ADVISOR --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-lg shadow-gray-900/5 p-6 overflow-hidden">
          <div class="flex items-center justify-between gap-4">
            <div>
              <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                Talk to an Advisor
              </h3>
              @if($consult && $consult->status !== 'cancelled')
                <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                  @if($consult->scheduled_at) 
                    Confirmed for: <br><span class="font-semibold">{{ $consult->scheduled_at }}</span>
                  @else 
                    Request received. We will call you soon.
                  @endif
                </div>
                <a href="{{ route('parent.consultation') }}" class="inline-block mt-4 text-sm text-[#0071b2] font-semibold hover:underline">
                  Manage Request
                </a>
              @else
                <div class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                  Get a free 15-minute call to help pick the perfect tutor.
                </div>
                <a href="{{ route('parent.consultation') }}" class="inline-block mt-4 px-4 py-2 bg-gradient-to-r from-[#FFA500] to-[#f29c00] text-white text-xs font-semibold rounded-lg hover:shadow-lg hover:shadow-[#FFA500]/25 hover:-translate-y-0.5 transition-all duration-300">
                  Book Free Call
                </a>
              @endif
            </div>
            <div class="flex-shrink-0">
              <img src="{{ asset('images/onboard/consult.svg') }}" alt="Consultation" class="w-24 h-24">
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>
@endsection
