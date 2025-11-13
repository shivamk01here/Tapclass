@extends('layouts.admin')

@section('title', 'Registration Issues')
@section('page-title', 'Registration Fails')

@section('content')
<div class="flex items-center justify-between mb-4">
  <div class="flex items-center gap-2 text-sm">
    <a href="{{ route('admin.registration-issues') }}" class="px-3 py-1.5 rounded {{ !$status ? 'bg-primary/10 text-primary' : 'hover:bg-gray-100' }}">All ({{ $counts['total'] ?? '-' }})</a>
    <a href="{{ route('admin.registration-issues', ['status' => 'open']) }}" class="px-3 py-1.5 rounded {{ $status==='open' ? 'bg-primary/10 text-primary' : 'hover:bg-gray-100' }}">Open ({{ $counts['open'] ?? '-' }})</a>
    <a href="{{ route('admin.registration-issues', ['status' => 'resolved']) }}" class="px-3 py-1.5 rounded {{ $status==='resolved' ? 'bg-primary/10 text-primary' : 'hover:bg-gray-100' }}">Resolved ({{ $counts['resolved'] ?? '-' }})</a>
  </div>
</div>

<div class="bg-white border rounded-lg overflow-hidden">
  <div class="overflow-x-auto">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-50">
        <tr>
          <th class="text-left px-4 py-2">When</th>
          <th class="text-left px-4 py-2">Name</th>
          <th class="text-left px-4 py-2">Email</th>
          <th class="text-left px-4 py-2">Role</th>
          <th class="text-left px-4 py-2">Status</th>
          <th class="text-left px-4 py-2">Message</th>
          <th class="text-left px-4 py-2">Details</th>
          <th class="text-left px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($issues as $issue)
          <tr class="border-t">
            <td class="px-4 py-2 text-gray-600">{{ $issue->created_at->format('Y-m-d H:i') }}</td>
            <td class="px-4 py-2">{{ $issue->name }}</td>
            <td class="px-4 py-2">{{ $issue->email }}</td>
            <td class="px-4 py-2 uppercase text-xs font-semibold">{{ $issue->role }}</td>
            <td class="px-4 py-2">
              @if($issue->status==='resolved')
                <span class="px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-700">Resolved</span>
              @else
                <span class="px-2 py-0.5 rounded-full text-xs bg-yellow-100 text-yellow-700">Open</span>
              @endif
            </td>
            <td class="px-4 py-2 max-w-[280px]">
              <div title="{{ $issue->message }}" class="truncate">{{ $issue->message ?: '—' }}</div>
            </td>
            <td class="px-4 py-2">
              <button onclick="toggleDetails({{ $issue->id }})" class="text-primary hover:underline">View</button>
            </td>
            <td class="px-4 py-2">
              @if($issue->status!=='resolved')
              <form method="POST" action="{{ route('admin.registration-issues.resolve', $issue->id) }}">
                @csrf
                <button class="px-3 py-1.5 rounded bg-green-600 text-white">Mark resolved</button>
              </form>
              @else
              —
              @endif
            </td>
          </tr>
          <tr id="details-{{ $issue->id }}" class="hidden bg-gray-50">
            <td colspan="8" class="px-6 py-3">
              <div class="text-xs text-gray-700">
                <div class="font-semibold mb-1">Payload</div>
                <pre class="whitespace-pre-wrap break-words">{{ json_encode($issue->payload, JSON_PRETTY_PRINT) }}</pre>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8" class="px-4 py-6 text-center text-gray-500">No issues found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="p-3">{{ $issues->withQueryString()->links() }}</div>
</div>

<script>
  function toggleDetails(id){
    const row = document.getElementById('details-'+id);
    if(row){ row.classList.toggle('hidden'); }
  }
</script>
@endsection
