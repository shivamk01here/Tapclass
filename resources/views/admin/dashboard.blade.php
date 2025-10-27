@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
<div class="bg-white rounded-xl border p-6">
<div class="flex items-center justify-between mb-2">
<span class="material-symbols-outlined text-blue-600 text-3xl">group</span>
</div>
<p class="text-gray-600 text-sm">Total Students</p>
<p class="text-3xl font-black">{{ $stats['total_students'] }}</p>
</div>

<div class="bg-white rounded-xl border p-6">
<span class="material-symbols-outlined text-green-600 text-3xl">school</span>
<p class="text-gray-600 text-sm">Total Tutors</p>
<p class="text-3xl font-black">{{ $stats['total_tutors'] }}</p>
</div>

<div class="bg-white rounded-xl border p-6">
<span class="material-symbols-outlined text-primary text-3xl">currency_rupee</span>
<p class="text-gray-600 text-sm">Total Revenue</p>
<p class="text-3xl font-black">₹{{ number_format($stats['total_revenue'], 2) }}</p>
</div>

<div class="bg-white rounded-xl border p-6">
<span class="material-symbols-outlined text-yellow-600 text-3xl">event</span>
<p class="text-gray-600 text-sm">Total Bookings</p>
<p class="text-3xl font-black">{{ $stats['total_bookings'] }}</p>
</div>
</div>

<!-- Pending Tutors -->
<div class="bg-white rounded-xl border p-6 mb-8">
<div class="flex items-center justify-between mb-4">
<h2 class="text-xl font-bold">Pending Tutor Verifications</h2>
<a href="{{ route('admin.tutors') }}" class="text-primary text-sm font-medium hover:underline">View All</a>
</div>

<div class="overflow-x-auto">
<table class="w-full">
<thead class="bg-gray-50 border-b">
<tr>
<th class="px-4 py-3 text-left text-sm font-medium">Name</th>
<th class="px-4 py-3 text-left text-sm font-medium">Email</th>
<th class="px-4 py-3 text-left text-sm font-medium">Submitted</th>
<th class="px-4 py-3 text-left text-sm font-medium">Action</th>
</tr>
</thead>
<tbody class="divide-y">
@forelse($pendingTutors as $tutor)
<tr>
<td class="px-4 py-3">{{ $tutor->user->name }}</td>
<td class="px-4 py-3 text-sm text-gray-600">{{ $tutor->user->email }}</td>
<td class="px-4 py-3 text-sm">{{ $tutor->created_at->diffForHumans() }}</td>
<td class="px-4 py-3">
<a href="{{ route('admin.tutors.verify', $tutor->user_id) }}" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-primary/90">
Review
</a>
</td>
</tr>
@empty
<tr>
<td colspan="4" class="px-4 py-8 text-center text-gray-500">No pending verifications</td>
</tr>
@endforelse
</tbody>
</table>
</div>
</div>

<!-- Recent Bookings -->
<div class="bg-white rounded-xl border p-6">
<h2 class="text-xl font-bold mb-4">Recent Bookings</h2>
<div class="space-y-3">
@forelse($recentBookings as $booking)
<div class="flex items-center justify-between border-b pb-3">
<div>
<p class="font-medium">{{ $booking->student->name }} → {{ $booking->tutor->name }}</p>
<p class="text-sm text-gray-500">{{ $booking->subject->name }} • {{ $booking->booking_code }}</p>
</div>
<div class="text-right">
<p class="font-bold">₹{{ number_format($booking->amount, 2) }}</p>
<span class="text-xs px-2 py-1 rounded-full {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
{{ ucfirst($booking->status) }}
</span>
</div>
</div>
@empty
<p class="text-center text-gray-500 py-4">No bookings yet</p>
@endforelse
</div>
</div>
@endsection
