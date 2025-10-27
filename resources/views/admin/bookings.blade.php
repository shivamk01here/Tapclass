@extends('layouts.admin')

@section('page-title', 'All Bookings')

@section('content')
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full">
<thead class="bg-gray-50 border-b border-gray-200">
<tr>
<th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Booking ID</th>
<th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Student</th>
<th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Tutor</th>
<th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Subject</th>
<th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Session Date</th>
<th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Amount</th>
<th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Status</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-200">
@forelse($bookings as $booking)
<tr class="hover:bg-gray-50 transition-colors">
<td class="px-6 py-4">
<p class="font-mono text-sm">#{{ $booking->id }}</p>
</td>
<td class="px-6 py-4">
<p class="font-semibold text-gray-900">{{ $booking->student->name }}</p>
<p class="text-xs text-gray-500">{{ $booking->student->email }}</p>
</td>
<td class="px-6 py-4">
<p class="font-semibold text-gray-900">{{ $booking->tutor->name }}</p>
<p class="text-xs text-gray-500">{{ $booking->tutor->email }}</p>
</td>
<td class="px-6 py-4">
<span class="px-2 py-1 bg-primary/10 text-primary text-xs rounded-full font-medium">{{ $booking->subject->name }}</span>
</td>
<td class="px-6 py-4">
<p class="text-sm">{{ $booking->session_date->format('M d, Y') }}</p>
<p class="text-xs text-gray-500">{{ $booking->start_time }} - {{ $booking->end_time }}</p>
</td>
<td class="px-6 py-4">
<p class="font-bold text-gray-900">₹{{ number_format($booking->total_amount, 2) }}</p>
</td>
<td class="px-6 py-4">
@if($booking->status === 'confirmed')
<span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Confirmed</span>
@elseif($booking->status === 'completed')
<span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">Completed</span>
@elseif($booking->status === 'cancelled')
<span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">Cancelled</span>
@else
<span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">{{ ucfirst($booking->status) }}</span>
@endif
</td>
</tr>
@empty
<tr>
<td colspan="7" class="px-6 py-12 text-center text-gray-500">
<span class="material-symbols-outlined text-5xl text-gray-300 mb-2">event</span>
<p class="font-medium">No bookings found</p>
</td>
</tr>
@endforelse
</tbody>
</table>
</div>

@if($bookings->hasPages())
<div class="px-6 py-4 border-t border-gray-200">
{{ $bookings->links() }}
</div>
@endif
</div>
@endsection
