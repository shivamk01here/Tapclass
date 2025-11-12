@extends('layouts.parent')

@section('title', 'Wallet')

@section('content')
<div class="py-8 px-4 lg:px-8">
  <div class="max-w-6xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
      <h1 class="text-2xl font-black">My Wallet</h1>
      <div class="flex items-center gap-2">
        <button type="button" onclick="showDevToast()" class="px-4 py-2 rounded-lg bg-[#0071b2] text-white font-semibold hover:bg-[#00639c]">Add Funds</button>
        <a href="{{ route('parent.dashboard') }}" class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">Back</a>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-gradient-to-br from-[#0071b2] to-[#00639c] text-white rounded-xl p-6">
        <span class="material-symbols-outlined text-4xl mb-2">account_balance_wallet</span>
        <p class="text-sm opacity-90">Current Balance</p>
        <p class="text-3xl font-black">₹{{ number_format($wallet->balance, 2) }}</p>
      </div>
      <div class="bg-white rounded-xl border p-6">
        <span class="material-symbols-outlined text-green-600 text-4xl mb-2">arrow_downward</span>
        <p class="text-sm text-gray-600">Total Credited</p>
        <p class="text-2xl font-bold text-green-600">₹{{ number_format($wallet->total_credited, 2) }}</p>
      </div>
      <div class="bg-white rounded-xl border p-6">
        <span class="material-symbols-outlined text-red-600 text-4xl mb-2">arrow_upward</span>
        <p class="text-sm text-gray-600">Total Debited</p>
        <p class="text-2xl font-bold text-red-600">₹{{ number_format($wallet->total_debited, 2) }}</p>
      </div>
    </div>

    <div class="bg-white rounded-xl border p-6">
      <h2 class="text-lg font-bold mb-4">Transaction History</h2>
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50 border-b">
            <tr>
              <th class="px-4 py-3 text-left text-sm font-medium">Date</th>
              <th class="px-4 py-3 text-left text-sm font-medium">Type</th>
              <th class="px-4 py-3 text-left text-sm font-medium">Description</th>
              <th class="px-4 py-3 text-right text-sm font-medium">Amount</th>
              <th class="px-4 py-3 text-right text-sm font-medium">Balance</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            @forelse($transactions as $txn)
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-sm">{{ $txn->created_at->format('M d, Y H:i') }}</td>
                <td class="px-4 py-3">
                  @if($txn->transaction_type === 'credit')
                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Credit</span>
                  @else
                    <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full">Debit</span>
                  @endif
                </td>
                <td class="px-4 py-3 text-sm text-gray-600">{{ $txn->description }}</td>
                <td class="px-4 py-3 text-right font-bold {{ $txn->transaction_type === 'credit' ? 'text-green-600' : 'text-red-600' }}">
                  {{ $txn->transaction_type === 'credit' ? '+' : '-' }}₹{{ number_format($txn->amount, 2) }}
                </td>
                <td class="px-4 py-3 text-right text-sm">₹{{ number_format($txn->balance_after, 2) }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="px-4 py-8 text-center text-gray-500">No transactions yet</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="mt-4">{{ $transactions->links() }}</div>
    </div>
  </div>
</div>
@endsection
