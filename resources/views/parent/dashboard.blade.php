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
          <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2">
            Saved Tutors
          </h2>
          <div class="py-10 text-center text-gray-500 dark:text-gray-400">
            <span class="material-symbols-outlined text-4xl mb-2">bookmark</span>
            <p class="text-sm">Your saved tutors will appear here. Coming soon!</p>
          </div>
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
              <a href="{{ route('student.wallet') }}" class="inline-block mt-4 px-4 py-2 bg-gradient-to-r from-[#0071b2] to-[#00639c] text-white text-xs font-semibold rounded-lg hover:shadow-lg hover:shadow-[#0071b2]/25 hover:-translate-y-0.5 transition-all duration-300">
                Add Funds
              </a>
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
