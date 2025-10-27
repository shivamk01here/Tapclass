@extends('layouts.admin')

@section('page-title', 'Students Management')

@section('content')
<!-- Students List -->
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full">
<thead class="bg-gray-50 border-b border-gray-200">
<tr>
<th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Student</th>
<th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Contact</th>
<th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Wallet Balance</th>
<th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Total Bookings</th>
<th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Registered</th>
<th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-200">
@forelse($students as $student)
<tr class="hover:bg-gray-50 transition-colors">
<td class="px-6 py-4">
<div class="flex items-center gap-3">
@if($student->profile_picture)
<img src="{{ asset('storage/' . $student->profile_picture) }}" class="w-10 h-10 rounded-full object-cover" alt="{{ $student->name }}" />
@else
<div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center">
<span class="text-primary font-bold">{{ substr($student->name, 0, 1) }}</span>
</div>
@endif
<div>
<p class="font-semibold text-gray-900">{{ $student->name }}</p>
<p class="text-xs text-gray-500">ID: {{ $student->id }}</p>
</div>
</div>
</td>
<td class="px-6 py-4">
<p class="text-sm text-gray-900">{{ $student->email }}</p>
<p class="text-xs text-gray-500">{{ $student->phone ?? 'N/A' }}</p>
</td>
<td class="px-6 py-4">
<p class="text-lg font-bold text-green-600">₹{{ number_format($student->wallet->balance ?? 0, 2) }}</p>
</td>
<td class="px-6 py-4">
<p class="text-sm font-medium">{{ $student->bookingsAsStudent->count() }}</p>
</td>
<td class="px-6 py-4">
<p class="text-sm text-gray-600">{{ $student->created_at->format('M d, Y') }}</p>
<p class="text-xs text-gray-500">{{ $student->created_at->diffForHumans() }}</p>
</td>
<td class="px-6 py-4">
<div class="flex items-center justify-center gap-2">
<button onclick="openWalletModal({{ $student->id }}, '{{ $student->name }}', {{ $student->wallet->balance ?? 0 }})"
        class="p-2 hover:bg-primary/10 rounded-lg transition-colors" title="Adjust Wallet">
<span class="material-symbols-outlined text-primary">account_balance_wallet</span>
</button>
</div>
</td>
</tr>
@empty
<tr>
<td colspan="6" class="px-6 py-12 text-center text-gray-500">
<span class="material-symbols-outlined text-5xl text-gray-300 mb-2">group</span>
<p class="font-medium">No students found</p>
</td>
</tr>
@endforelse
</tbody>
</table>
</div>

<!-- Pagination -->
@if($students->hasPages())
<div class="px-6 py-4 border-t border-gray-200">
{{ $students->links() }}
</div>
@endif
</div>

<!-- Wallet Adjustment Modal -->
<div id="wallet-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
<div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
<div class="flex items-center gap-3 mb-4">
<div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center">
<span class="material-symbols-outlined text-primary text-2xl">account_balance_wallet</span>
</div>
<div>
<h3 class="text-lg font-bold text-gray-900">Adjust Wallet</h3>
<p class="text-sm text-gray-600" id="wallet-student-name"></p>
<p class="text-xs text-gray-500">Current Balance: ₹<span id="wallet-current-balance">0</span></p>
</div>
</div>

<form method="POST" id="wallet-form">
@csrf
<div class="mb-4">
<label class="block text-sm font-medium text-gray-700 mb-2">Transaction Type</label>
<select name="type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
<option value="credit">Credit (Add Money)</option>
<option value="debit">Debit (Deduct Money)</option>
</select>
</div>

<div class="mb-4">
<label class="block text-sm font-medium text-gray-700 mb-2">Amount (₹)</label>
<input type="number" name="amount" step="0.01" min="0.01" required
       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary"
       placeholder="Enter amount" />
</div>

<div class="mb-4">
<label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
<textarea name="description" rows="2" required
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary"
          placeholder="Reason for adjustment"></textarea>
</div>

<div class="flex gap-3">
<button type="button" onclick="closeWalletModal()" 
        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50">
Cancel
</button>
<button type="submit" 
        class="flex-1 px-4 py-2 bg-primary text-white rounded-lg font-bold hover:bg-primary/90">
Adjust Wallet
</button>
</div>
</form>
</div>
</div>

@endsection

@push('scripts')
<script>
function openWalletModal(studentId, studentName, currentBalance) {
    document.getElementById('wallet-modal').classList.remove('hidden');
    document.getElementById('wallet-student-name').textContent = studentName;
    document.getElementById('wallet-current-balance').textContent = parseFloat(currentBalance).toFixed(2);
    document.getElementById('wallet-form').action = `/admin/students/${studentId}/adjust-wallet`;
}

function closeWalletModal() {
    document.getElementById('wallet-modal').classList.add('hidden');
}

// Close modal on background click
document.getElementById('wallet-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeWalletModal();
    }
});
</script>
@endpush
