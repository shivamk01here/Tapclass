@extends('layouts.admin')

@section('page-title', 'Parents Management')

@section('content')
<!-- Summary / Filters -->
<div class="bg-white rounded-xl border border-gray-200 p-4 sm:p-6 mb-6">
  <div class="flex flex-wrap items-center justify-between gap-3">
    <div class="flex items-center gap-3 text-sm text-gray-700">
      <span class="px-2 py-1 bg-gray-100 rounded-lg">Total Parents: <strong>{{ $stats['total'] ?? 0 }}</strong></span>
      <span class="px-2 py-1 bg-gray-100 rounded-lg">With Children: <strong>{{ $stats['with_children'] ?? 0 }}</strong></span>
    </div>
    <div class="w-full md:w-64">
      <input type="text" id="search-parents" placeholder="Search parents..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary" />
    </div>
  </div>
</div>

<!-- Parents List -->
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full">
      <thead class="bg-gray-50 border-b border-gray-200">
        <tr>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Parent</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Contact</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Children</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Wallet</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Registered</th>
          <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200" id="parents-tbody">
        @forelse($parents as $parent)
        <tr class="hover:bg-gray-50 transition-colors parent-row">
          <td class="px-6 py-4">
            <div class="flex items-center gap-3">
              @if($parent->profile_picture)
                <img src="{{ asset('storage/' . $parent->profile_picture) }}" class="w-10 h-10 rounded-full object-cover" alt="{{ $parent->name }}" />
              @else
                <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center">
                  <span class="text-primary font-bold">{{ substr($parent->name, 0, 1) }}</span>
                </div>
              @endif
<div>
                <p class="font-semibold text-gray-900 flex items-center gap-2">{{ $parent->name }}
                  @if(($parent->children ?? collect())->count() > 0)
                    <span class="px-2 py-0.5 rounded-full text-[10px] bg-green-100 text-green-800">Onboarding Completed</span>
                  @else
                    <span class="px-2 py-0.5 rounded-full text-[10px] bg-amber-100 text-amber-800">Onboarding Pending</span>
                  @endif
                  @if($parent->email_verified_at)
                    <span class="px-2 py-0.5 rounded-full text-[10px] bg-blue-100 text-blue-800">Email Verified</span>
                  @else
                    <span class="px-2 py-0.5 rounded-full text-[10px] bg-gray-100 text-gray-700">Email Unverified</span>
                  @endif
                </p>
                <p class="text-xs text-gray-500">ID: {{ $parent->id }}</p>
              </div>
            </div>
          </td>
          <td class="px-6 py-4">
            <p class="text-sm text-gray-900">{{ $parent->email }}</p>
            <p class="text-xs text-gray-500">{{ $parent->phone ?? 'N/A' }}</p>
          </td>
          <td class="px-6 py-4">
            <div class="flex flex-wrap gap-1">
              @forelse(($parent->children ?? []) as $child)
                <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">{{ $child->first_name }} ({{ $child->class_slab ?? 'N/A' }})</span>
              @empty
                <span class="text-xs text-gray-500">0</span>
              @endforelse
            </div>
          </td>
          <td class="px-6 py-4">
            <p class="text-sm font-semibold">₹{{ number_format($parent->wallet->balance ?? 0, 2) }}</p>
          </td>
          <td class="px-6 py-4">
            <p class="text-sm text-gray-600">{{ $parent->created_at->format('M d, Y') }}</p>
            <p class="text-xs text-gray-500">{{ $parent->created_at->diffForHumans() }}</p>
          </td>
          <td class="px-6 py-4">
            <div class="flex items-center justify-center">
              <a href="{{ route('admin.parents.show', $parent->id) }}" class="p-2 hover:bg-primary/10 rounded-lg" title="View Details">
                <span class="material-symbols-outlined text-primary">visibility</span>
              </a>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="px-6 py-12 text-center text-gray-500">
            <span class="material-symbols-outlined text-5xl text-gray-300 mb-2">family_restroom</span>
            <p class="font-medium">No parents found</p>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  @if($parents->hasPages())
  <div class="px-6 py-4 border-t border-gray-200">
    {{ $parents->links() }}
  </div>
  @endif
</div>

@endsection

@push('scripts')
<script>
  document.getElementById('search-parents').addEventListener('input', function(e){
    const q = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#parents-tbody tr.parent-row');
    rows.forEach(r => {
      const text = r.textContent.toLowerCase();
      r.style.display = text.includes(q) ? '' : 'none';
    });
  });
</script>
@endpush
