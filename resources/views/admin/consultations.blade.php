@extends('layouts.admin')

@section('page-title', 'Consultation Requests')

@section('content')
<div class="bg-white rounded-xl border border-gray-200 p-4 sm:p-6 mb-6">
  <div class="flex flex-wrap items-center justify-between gap-3">
    <div class="flex items-center gap-2">
      <a href="{{ route('admin.consultations') }}" class="px-3 py-1.5 rounded-lg text-sm {{ !$status ? 'bg-primary/10 text-primary' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">All</a>
      @php $statuses = ['requested','contacted','in_progress','scheduled','completed','cancelled','resolved']; @endphp
      @foreach($statuses as $st)
        <a href="{{ route('admin.consultations', ['status' => $st]) }}" class="px-3 py-1.5 rounded-lg text-sm {{ $status === $st ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">{{ ucwords(str_replace('_',' ', $st)) }}</a>
      @endforeach
    </div>
    <div class="w-full md:w-64">
      <input type="text" id="search" placeholder="Search by parent, phone, child..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary"/>
    </div>
  </div>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full">
      <thead class="bg-gray-50 border-b">
        <tr>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Parent</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Child</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Contact</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Requested</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Questions</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Status</th>
          <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">Actions</th>
        </tr>
      </thead>
      <tbody id="consultation-tbody" class="divide-y divide-gray-200">
        @forelse($consultations as $c)
        <tr class="hover:bg-gray-50 transition-colors">
          <td class="px-6 py-4">
            <a href="{{ route('admin.parents.show', $c->parent_user_id) }}" class="text-primary font-semibold hover:underline">{{ $c->parent->name ?? 'Unknown' }}</a>
            <div class="text-xs text-gray-500">{{ $c->parent->email ?? '' }}</div>
          </td>
          <td class="px-6 py-4">
            <div class="text-sm">{{ $c->child->first_name ?? '—' }}</div>
            <div class="text-xs text-gray-500">{{ $c->child->class_slab ?? '' }}</div>
          </td>
          <td class="px-6 py-4 text-sm">{{ $c->contact_phone }}</td>
          <td class="px-6 py-4">
            <div class="text-sm text-gray-900">{{ $c->created_at->format('M d, Y h:i A') }}</div>
            <div class="text-xs text-gray-500">{{ $c->created_at->diffForHumans() }}</div>
          </td>
          <td class="px-6 py-4 text-sm max-w-xs truncate" title="{{ $c->questions }}">{{ $c->questions ?? '—' }}</td>
          <td class="px-6 py-4">
            <span class="px-2 py-1 rounded-full text-xs font-semibold
              @class([
                'bg-blue-100 text-blue-800' => $c->status === 'requested',
                'bg-amber-100 text-amber-800' => $c->status === 'scheduled' || $c->status === 'in_progress',
                'bg-green-100 text-green-800' => $c->status === 'completed' || $c->status === 'resolved',
                'bg-red-100 text-red-800' => $c->status === 'cancelled',
                'bg-gray-100 text-gray-800' => !in_array($c->status, ['requested','scheduled','in_progress','completed','resolved','cancelled'])
              ])
            ">{{ ucwords(str_replace('_',' ', $c->status ?? '')) }}</span>
          </td>
          <td class="px-6 py-4">
            <form method="POST" action="{{ route('admin.consultations.status', $c->id) }}" class="flex items-center gap-2">
              @csrf
              <select name="status" class="px-2 py-1 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-primary">
                @foreach(['requested','contacted','in_progress','scheduled','completed','cancelled','resolved'] as $opt)
                  <option value="{{ $opt }}" {{ $c->status === $opt ? 'selected' : '' }}>{{ ucwords(str_replace('_',' ', $opt)) }}</option>
                @endforeach
              </select>
              <button type="submit" class="px-3 py-1.5 bg-primary text-white rounded-lg text-sm font-semibold">Update</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="px-6 py-12 text-center text-gray-500">No consultation requests found.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($consultations->hasPages())
  <div class="px-6 py-4 border-t border-gray-200">
    {{ $consultations->links() }}
  </div>
  @endif
</div>
@endsection

@push('scripts')
<script>
  document.getElementById('search')?.addEventListener('input', function(e){
    const q = e.target.value.toLowerCase();
    document.querySelectorAll('#consultation-tbody tr').forEach(tr => {
      const t = tr.textContent.toLowerCase();
      tr.style.display = t.includes(q) ? '' : 'none';
    });
  });
</script>
@endpush
