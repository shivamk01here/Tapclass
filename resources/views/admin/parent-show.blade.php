@extends('layouts.admin')

@section('page-title', 'Parent Details')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  <!-- Parent Summary -->
  <div class="lg:col-span-1 bg-white rounded-xl border border-gray-200 p-6">
    <div class="flex items-center gap-4 mb-4">
      @if($parent->profile_picture)
        <img src="{{ asset('storage/' . $parent->profile_picture) }}" class="w-16 h-16 rounded-full object-cover" alt="{{ $parent->name }}" />
      @else
        <div class="w-16 h-16 rounded-full bg-primary/20 flex items-center justify-center">
          <span class="text-primary font-bold text-2xl">{{ substr($parent->name, 0, 1) }}</span>
        </div>
      @endif
      <div>
        <h2 class="text-xl font-bold">{{ $parent->name }}</h2>
        <p class="text-sm text-gray-600">Parent • ID: {{ $parent->id }}</p>
      </div>
    </div>
    <div class="space-y-2 text-sm">
      <p><span class="text-gray-500">Email:</span> {{ $parent->email }}</p>
      <p><span class="text-gray-500">Phone:</span> {{ $parent->phone ?? 'N/A' }}</p>
      <p><span class="text-gray-500">Registered:</span> {{ $parent->created_at->format('M d, Y') }} ({{ $parent->created_at->diffForHumans() }})</p>
      <p><span class="text-gray-500">Wallet Balance:</span> ₹{{ number_format($parent->wallet->balance ?? 0, 2) }}</p>
      <p><span class="text-gray-500">Total Bookings:</span> {{ $totalBookings }}</p>
    </div>
  </div>

  <!-- Children -->
  <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-lg font-bold">Children</h3>
    </div>
    @if(($parent->children ?? collect())->count() > 0)
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($parent->children as $child)
          <div class="border rounded-lg p-4">
            <div class="flex items-center gap-3 mb-2">
              @if($child->profile_photo_path)
                <img src="{{ asset('storage/' . $child->profile_photo_path) }}" class="w-12 h-12 rounded-full object-cover" alt="{{ $child->first_name }}" />
              @else
                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
                  <span class="text-primary font-bold">{{ strtoupper(substr($child->first_name, 0, 1)) }}</span>
                </div>
              @endif
              <div>
                <p class="font-semibold">{{ $child->first_name }}</p>
                <p class="text-xs text-gray-500">Class: {{ $child->class_slab ?? 'N/A' }} • Age: {{ $child->age ?? 'N/A' }}</p>
              </div>
            </div>
            <div class="text-sm text-gray-700">
              <p><span class="text-gray-500">Goals:</span> {{ $child->goals ?? '—' }}</p>
              <p><span class="text-gray-500">Bookings:</span> {{ ($child->bookings ?? collect())->count() }}</p>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <p class="text-sm text-gray-500">No children added.</p>
    @endif
  </div>

  <!-- Consultations -->
  <div class="lg:col-span-3 bg-white rounded-xl border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-lg font-bold">Consultation Requests</h3>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-gray-50 border-b">
          <tr>
            <th class="px-4 py-3 text-left text-sm font-medium">Child</th>
            <th class="px-4 py-3 text-left text-sm font-medium">Contact</th>
            <th class="px-4 py-3 text-left text-sm font-medium">Scheduled At</th>
            <th class="px-4 py-3 text-left text-sm font-medium">Status</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          @forelse($consultations as $c)
            <tr>
              <td class="px-4 py-3 text-sm">{{ $c->child->first_name ?? '—' }}</td>
              <td class="px-4 py-3 text-sm">{{ $c->contact_phone ?? '—' }}</td>
              <td class="px-4 py-3 text-sm">{{ $c->scheduled_at ? $c->scheduled_at->format('M d, Y h:i A') : '—' }}</td>
              <td class="px-4 py-3 text-sm">
                <span class="px-2 py-1 rounded-full text-xs
                  {{ $c->status === 'scheduled' ? 'bg-blue-100 text-blue-800' : ($c->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700') }}
                ">
                  {{ ucfirst($c->status ?? 'pending') }}
                </span>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="px-4 py-8 text-center text-gray-500">No consultations</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
