@extends('layouts.admin')

@section('page-title', 'Payout Requests')

@section('content')
<!-- Filters -->
<div class="bg-white rounded-xl border border-gray-200 p-4 mb-6">
<div class="flex items-center gap-2">
<a href="{{ route('admin.payouts', ['status' => 'pending']) }}" 
   class="px-4 py-2 rounded-lg font-medium transition-colors {{ request('status') === 'pending' || !request('status') ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
Pending
</a>
<a href="{{ route('admin.payouts', ['status' => 'approved']) }}" 
   class="px-4 py-2 rounded-lg font-medium transition-colors {{ request('status') === 'approved' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
Approved
</a>
<a href="{{ route('admin.payouts', ['status' => 'rejected']) }}" 
   class="px-4 py-2 rounded-lg font-medium transition-colors {{ request('status') === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
Rejected
</a>
</div>
</div>

<!-- Payouts List -->
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full">
<thead class="bg-gray-50 border-b border-gray-200">
<tr>
<th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Request ID</th>
<th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Tutor</th>
<th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Amount</th>
<th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Bank Details</th>
<th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Requested</th>
<th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Status</th>
<th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-200">
@forelse($payouts as $payout)
<tr class="hover:bg-gray-50 transition-colors">
<td class="px-6 py-4">
<p class="font-mono text-sm">#{{ $payout->id }}</p>
</td>
<td class="px-6 py-4">
<p class="font-semibold text-gray-900">{{ $payout->tutor->name }}</p>
<p class="text-xs text-gray-500">{{ $payout->tutor->email }}</p>
</td>
<td class="px-6 py-4">
<p class="text-lg font-bold text-green-600">₹{{ number_format($payout->amount, 2) }}</p>
</td>
<td class="px-6 py-4">
<p class="text-sm text-gray-700">{{ $payout->bank_name }}</p>
<p class="text-xs text-gray-500">{{ $payout->account_number }}</p>
</td>
<td class="px-6 py-4">
<p class="text-sm text-gray-600">{{ $payout->created_at->format('M d, Y') }}</p>
<p class="text-xs text-gray-500">{{ $payout->created_at->diffForHumans() }}</p>
</td>
<td class="px-6 py-4">
@if($payout->status === 'pending')
<span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">Pending</span>
@elseif($payout->status === 'approved')
<span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Approved</span>
@else
<span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">Rejected</span>
@endif
</td>
<td class="px-6 py-4">
@if($payout->status === 'pending')
<div class="flex items-center justify-center gap-2">
<form method="POST" action="{{ route('admin.payouts.approve', $payout->id) }}" class="inline">
@csrf
<button type="submit" class="p-2 hover:bg-green-50 rounded-lg transition-colors" title="Approve">
<span class="material-symbols-outlined text-green-600">check_circle</span>
</button>
</form>
<button onclick="openRejectModal({{ $payout->id }}, '{{ $payout->tutor->name }}')"
        class="p-2 hover:bg-red-50 rounded-lg transition-colors" title="Reject">
<span class="material-symbols-outlined text-red-600">cancel</span>
</button>
</div>
@else
<p class="text-center text-sm text-gray-500">-</p>
@endif
</td>
</tr>
@empty
<tr>
<td colspan="7" class="px-6 py-12 text-center text-gray-500">
<span class="material-symbols-outlined text-5xl text-gray-300 mb-2">payments</span>
<p class="font-medium">No payout requests found</p>
</td>
</tr>
@endforelse
</tbody>
</table>
</div>

@if($payouts->hasPages())
<div class="px-6 py-4 border-t border-gray-200">
{{ $payouts->links() }}
</div>
@endif
</div>

<!-- Reject Modal -->
<div id="reject-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
<div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
<h3 class="text-lg font-bold text-gray-900 mb-4">Reject Payout Request</h3>
<p class="text-gray-700 mb-4">Rejecting payout for <strong id="reject-tutor-name"></strong></p>

<form method="POST" id="reject-form">
@csrf
<textarea name="reason" rows="3" required
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary mb-4"
          placeholder="Reason for rejection (required)"></textarea>

<div class="flex gap-3">
<button type="button" onclick="closeRejectModal()" 
        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50">
Cancel
</button>
<button type="submit" 
        class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg font-bold hover:bg-red-700">
Reject
</button>
</div>
</form>
</div>
</div>
@endsection

@push('scripts')
<script>
function openRejectModal(payoutId, tutorName) {
    document.getElementById('reject-modal').classList.remove('hidden');
    document.getElementById('reject-tutor-name').textContent = tutorName;
    document.getElementById('reject-form').action = `/admin/payouts/reject/${payoutId}`;
}

function closeRejectModal() {
    document.getElementById('reject-modal').classList.add('hidden');
}

document.getElementById('reject-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRejectModal();
    }
});
</script>
@endpush
