@extends('layouts.tutor')

@section('title', 'Page Title')

@section('content')
<body class="bg-gray-50 font-display">
<header class="bg-white border-b px-6 py-4">
<a href="{{ route('tutor.dashboard') }}" class="text-primary font-bold">← Back</a>
</header>
<main class="max-w-7xl mx-auto px-4 py-8">
  <h1 class="text-3xl font-black mb-6">Earnings</h1>

  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl border p-4">
      <div class="text-xs text-gray-500">Pending</div>
      <div class="text-2xl font-black">₹{{ number_format($summary['pending'] ?? 0, 2) }}</div>
    </div>
    <div class="bg-white rounded-xl border p-4">
      <div class="text-xs text-gray-500">Available</div>
      <div class="text-2xl font-black text-green-600">₹{{ number_format($summary['available'] ?? 0, 2) }}</div>
    </div>
    <div class="bg-white rounded-xl border p-4">
<div class="text-xs text-gray-500">In Approval</div>
      <div class="text-2xl font-black">₹{{ number_format($summary['requested'] ?? 0, 2) }}</div>
    </div>
    <div class="bg-white rounded-xl border p-4">
      <div class="text-xs text-gray-500">Withdrawn</div>
      <div class="text-2xl font-black">₹{{ number_format($summary['withdrawn'] ?? 0, 2) }}</div>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-xl border p-4">
      <h2 class="text-lg font-bold mb-3">Earnings History</h2>
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-3 py-2 text-left">Booking</th>
              <th class="px-3 py-2 text-left">Date</th>
              <th class="px-3 py-2 text-left">Amount</th>
              <th class="px-3 py-2 text-left">Status</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            @forelse($earnings as $e)
            <tr>
              <td class="px-3 py-2">{{ optional($e->booking)->booking_code ?? '#' }}</td>
              <td class="px-3 py-2">{{ optional($e->booking)->session_date?->format('M d, Y') ?? $e->created_at->format('M d, Y') }}</td>
              <td class="px-3 py-2 font-semibold">₹{{ number_format($e->amount, 2) }}</td>
              <td class="px-3 py-2">
                <span class="px-2 py-1 rounded-full text-xs
                  @class([
                    'bg-gray-100 text-gray-800' => $e->status==='pending',
                    'bg-green-100 text-green-800' => $e->status==='available',
                    'bg-amber-100 text-amber-800' => $e->status==='requested',
                    'bg-blue-100 text-blue-800' => $e->status==='withdrawn',
                  ])
                ">{{ ucfirst($e->status) }}</span>
              </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-3 py-6 text-center text-gray-500">No earnings yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="mt-3">{{ $earnings->links() }}</div>
    </div>

    <div class="bg-white rounded-xl border p-4">
      <h2 class="text-lg font-bold mb-3">Request Payout</h2>
      <form method="POST" action="{{ route('tutor.earnings.withdraw') }}" class="space-y-3">
        @csrf
        <div>
          <label class="text-sm font-semibold">Amount (₹)</label>
@php $avail = (int)($availableNet ?? (($summary['available'] ?? 0) - ($summary['requested'] ?? 0))); $avail = max($avail,0); @endphp
          <input type="number" step="1" @if($avail>=1) min="1" max="{{ $avail }}" @endif name="amount" class="w-full px-3 py-2 border rounded-lg" placeholder="e.g. 1000" @if($avail<1) disabled @endif required>
          <p class="text-xs text-gray-500 mt-1">Available to request: ₹{{ number_format($avail, 2) }}. Pending approval: ₹{{ number_format($summary['requested'] ?? 0, 2) }}</p>
          @if($avail<1)
            <p class="text-xs text-amber-600 mt-1">No available balance to withdraw (requests in approval).</p>
          @endif
        </div>
        <div>
          <label class="text-sm font-semibold">Bank Account Number</label>
          <input type="text" name="bank_account_number" class="w-full px-3 py-2 border rounded-lg">
        </div>
        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="text-sm font-semibold">IFSC</label>
            <input type="text" name="bank_ifsc_code" class="w-full px-3 py-2 border rounded-lg">
          </div>
          <div>
            <label class="text-sm font-semibold">Account Holder</label>
            <input type="text" name="bank_account_holder_name" class="w-full px-3 py-2 border rounded-lg">
          </div>
        </div>
<button class="w-full px-4 py-2 bg-primary text-white rounded-lg" @if($avail<1) disabled @endif>Submit Request</button>
      </form>

      <h3 class="text-md font-bold mt-6 mb-2">Recent Payout Requests</h3>
      <div class="space-y-2 text-sm">
        @forelse($payouts as $p)
          <div class="flex items-center justify-between border rounded-lg px-3 py-2">
            <div>₹{{ number_format($p->amount,2) }} • <span class="text-gray-500">{{ $p->created_at->format('M d, Y') }}</span></div>
            <div class="text-xs px-2 py-1 rounded-full @class([
                'bg-amber-100 text-amber-800' => $p->status==='pending',
                'bg-green-100 text-green-800' => $p->status==='approved',
                'bg-red-100 text-red-800' => $p->status==='rejected',
            ])">{{ ucfirst($p->status) }}</div>
          </div>
        @empty
          <div class="text-gray-500">No payout requests yet.</div>
        @endforelse
      </div>
      <div class="mt-3">{{ $payouts->links() }}</div>
    </div>
  </div>
</main>
</body>
</html>
@endsection
