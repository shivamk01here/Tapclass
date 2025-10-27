@extends('layouts.admin')

@section('page-title', 'Tutors Management')

@push('styles')
<style>
    /* Responsive Table Styles */
    @media (max-width: 767px) {
        .responsive-table thead {
            display: none;
        }
        .responsive-table tbody tr.tutor-row {
            display: block;
            margin-bottom: 1.5rem;
            border: 1px solid #e5e7eb; /* border-gray-200 */
            border-radius: 0.75rem; /* rounded-xl */
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); /* shadow-sm */
            overflow: hidden;
            background-color: #ffffff; /* bg-white */
        }
        .responsive-table tbody tr.tutor-row:hover {
            background-color: #f9fafb; /* hover:bg-gray-50 */
        }
        .responsive-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            text-align: right;
            border-bottom: 1px solid #f3f4f6; /* border-gray-100 */
        }
        .responsive-table tbody tr.tutor-row td:last-child {
            border-bottom: none;
        }
        .responsive-table tbody td[data-label]::before {
            content: attr(data-label);
            font-weight: 600; /* semibold */
            text-align: left;
            margin-right: 1rem;
            color: #111827; /* text-gray-900 */
        }
        
        /* Specific adjustments for content alignment */
        .responsive-table tbody td[data-label="Tutor"] {
            background-color: #f9fafb; /* bg-gray-50 */
        }
        .responsive-table tbody td[data-label="Tutor"] .flex {
            flex-grow: 1;
            justify-content: flex-end;
        }
        .responsive-table tbody td[data-label="Subjects"] .flex {
            flex-grow: 1;
            justify-content: flex-end;
        }
        .responsive-table tbody td[data-label="Actions"] .flex {
            flex-grow: 1;
            justify-content: flex-end;
        }
        .responsive-table tbody tr.empty-row td {
            display: table-cell; /* Revert for the empty row */
            text-align: center;
            padding: 3rem 1.5rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Filters -->
<div class="bg-white rounded-xl border border-gray-200 p-4 sm:p-6 mb-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div class="flex flex-wrap items-center gap-2">
            <!-- Reverted: 'Pending' is now the default tab -->
            <a href="{{ route('admin.tutors', ['status' => 'pending']) }}" 
               class="px-4 py-2 rounded-lg font-medium transition-colors {{ (request('status') === 'pending' || !request('status')) ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Pending ({{ $stats['pending'] ?? 0 }})
            </a>
            <a href="{{ route('admin.tutors', ['status' => 'verified']) }}" 
               class="px-4 py-2 rounded-lg font-medium transition-colors {{ request('status') === 'verified' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Verified ({{ $stats['verified'] ?? 0 }})
            </a>
            <a href="{{ route('admin.tutors', ['status' => 'rejected']) }}" 
               class="px-4 py-2 rounded-lg font-medium transition-colors {{ request('status') === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Rejected ({{ $stats['rejected'] ?? 0 }})
            </a>
            <a href="{{ route('admin.tutors', ['status' => 'all']) }}" 
               class="px-4 py-2 rounded-lg font-medium transition-colors {{ request('status') === 'all' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                All Tutors ({{ $stats['total'] ?? 0 }})
            </a>
        </div>

        <div class="flex items-center gap-3 w-full lg:w-auto">
            <input type="text" id="search" placeholder="Search tutors..." 
                   class="w-full lg:w-auto px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary" />
        </div>
    </div>
</div>

<!-- Tutors List -->
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden md:bg-transparent md:border-none">
    <div class="md:overflow-x-auto md:bg-white md:rounded-xl md:border md:border-gray-200">
        <table class="w-full responsive-table">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Tutor</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Contact</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Experience</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Subjects</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Registered</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 md:divide-y-0">
                @forelse($tutors as $tutor)
                <tr class="transition-colors tutor-row">
                    <td data-label="Tutor" class="px-6 py-4 md:py-4">
                        <div class="flex items-center gap-3">
                            @if($tutor->user->profile_picture)
                            <img src="{{ asset('storage/' . $tutor->user->profile_picture) }}" class="w-10 h-10 rounded-full object-cover" alt="{{ $tutor->user->name }}" />
                            @else
                            <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center flex-shrink-0">
                                <span class="text-primary font-bold">{{ substr($tutor->user->name, 0, 1) }}</span>
                            </div>
                            @endif
                            <div class="text-left">
                                <p class="font-semibold text-gray-900">{{ $tutor->user->name }}</p>
                                <p class="text-xs text-gray-500">ID: {{ $tutor->id }}</p>
                            </div>
                        </div>
                    </td>
                    <td data-label="Contact" class="px-6 py-4 md:py-4">
                        <div class="text-right md:text-left">
                            <p class="text-sm text-gray-900">{{ $tutor->user->email }}</p>
                            <p class="text-xs text-gray-500">{{ $tutor->user->phone ?? 'N/A' }}</p>
                        </div>
                    </td>
                    <td data-label="Experience" class="px-6 py-4 md:py-4">
                        <p class="text-sm font-medium">{{ $tutor->experience_years }} years</p>
                    </td>
                    <td data-label="Subjects" class="px-6 py-4 md:py-4">
                        <div class="flex flex-wrap gap-1 justify-end md:justify-start">
                            @foreach($tutor->subjects->take(2) as $subject)
                            <span class="px-2 py-1 bg-primary/10 text-primary text-xs rounded-full font-medium">{{ $subject->name }}</span>
                            @endforeach
                            @if($tutor->subjects->count() > 2)
                            <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full font-medium">+{{ $tutor->subjects->count() - 2 }}</span>
                            @endif
                        </div>
                    </td>
                    <td data-label="Status" class="px-6 py-4 md:py-4">
                        @if($tutor->verification_status === 'pending')
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">
                            <span class="material-symbols-outlined text-sm">schedule</span>
                            Pending
                        </span>
                        @elseif($tutor->verification_status === 'verified')
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                            <span class="material-symbols-outlined text-sm">verified</span>
                            Verified
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">
                            <span class="material-symbols-outlined text-sm">cancel</span>
                            Rejected
                        </span>
                        @endif
                    </td>
                    <td data-label="Registered" class="px-6 py-4 md:py-4">
                        <div class="text-right md:text-left">
                            <p class="text-sm text-gray-600">{{ $tutor->created_at->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $tutor->created_at->diffForHumans() }}</p>
                        </div>
                    </td>
                    <td data-label="Actions" class="px-6 py-4 md:py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.tutors.verify', $tutor->user_id) }}" 
                               class="p-2 hover:bg-primary/10 rounded-lg transition-colors" title="View Profile">
                                <span class="material-symbols-outlined text-primary">visibility</span>
                            </a>
                            @if($tutor->verification_status !== 'verified')
                            <form method="POST" action="{{ route('admin.tutors.approve', $tutor->user_id) }}" class="inline">
                                @csrf
                                <button type="submit" class="p-2 hover:bg-green-50 rounded-lg transition-colors" title="Approve">
                                    <span class="material-symbols-outlined text-green-600">check_circle</span>
                                </button>
                            </form>
                            @endif
                            <button onclick="openBanModal({{ $tutor->user_id }}, '{{ $tutor->user->name }}')"
                                    class="p-2 hover:bg-red-50 rounded-lg transition-colors" title="Ban Tutor">
                                <span class="material-symbols-outlined text-red-600">block</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr class="empty-row">
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                        <span class="material-symbols-outlined text-5xl text-gray-300 mb-2">school</span>
                        <p class="font-medium">No tutors found</p>
                        <p class="text-sm">Try adjusting your filters</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($tutors->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 bg-white rounded-b-xl">
        {{ $tutors->links() }}
    </div>
    @endif
</div>

<!-- Ban Modal -->
<div id="ban-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl p-6 max-w-md w-full">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                <span class="material-symbols-outlined text-red-600 text-2xl">block</span>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900">Ban Tutor</h3>
                <p class="text-sm text-gray-600">This action can be reversed later</p>
            </div>
        </div>

        <p class="text-gray-700 mb-4">Are you sure you want to ban <strong id="ban-tutor-name"></strong>?</p>

        <form method="POST" id="ban-form">
            @csrf
            <textarea name="reason" rows="3" required
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary mb-4"
                      placeholder="Reason for banning (required)"></textarea>

            <div class="flex flex-col sm:flex-row gap-3">
                <button type="button" onclick="closeBanModal()" 
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg font-bold hover:bg-red-700">
                    Ban Tutor
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openBanModal(tutorId, tutorName) {
        document.getElementById('ban-modal').classList.remove('hidden');
        document.getElementById('ban-tutor-name').textContent = tutorName;
        document.getElementById('ban-form').action = `/admin/tutors/${tutorId}/ban`;
    }

    function closeBanModal() {
        document.getElementById('ban-modal').classList.add('hidden');
    }

    // Close modal on background click
    document.getElementById('ban-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeBanModal();
        }
    });

    // Search functionality
    document.getElementById('search').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr.tutor-row');
        const emptyRow = document.querySelector('tbody tr.empty-row');
        let visibleRows = 0;

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = 'block'; // 'block' for mobile, will be overridden by 'table-row' on desktop
                visibleRows++;
            } else {
                row.style.display = 'none';
            }
        });

        // Show/hide the empty row placeholder
        if (emptyRow) {
            emptyRow.style.display = visibleRows > 0 ? 'none' : 'table-row';
        }
    });
</script>
@endpush

