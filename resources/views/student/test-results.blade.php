@extends('layouts.student')

@section('title', 'Test Results - Htc')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-black text-gray-900">Test Results</h1>
            <p class="text-gray-600 mt-1">View your performance history and detailed analysis</p>
        </div>
        <a href="{{ route('ai-test.landing') }}" class="px-4 py-2 bg-primary text-white rounded-lg font-bold hover:bg-blue-700 transition flex items-center gap-2">
            <span class="material-symbols-outlined">add_circle</span>
            New Mock Test
        </a>
    </div>

    @if($mockTests->count() > 0)
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-xs uppercase text-gray-500 font-semibold">
                            <th class="px-6 py-4">Test Details</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4 text-center">Score</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($mockTests as $test)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-start gap-3">
                                        <div class="p-2 bg-blue-50 text-primary rounded-lg">
                                            <span class="material-symbols-outlined text-xl">psychology</span>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $test->exam_context }}</p>
                                            <p class="text-sm text-gray-600">{{ $test->subject }} &bull; {{ $test->topic }}</p>
                                            <span class="inline-block mt-1 px-2 py-0.5 text-[10px] font-bold tracking-wide uppercase rounded-full bg-gray-100 text-gray-600">
                                                {{ $test->difficulty }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $test->created_at->format('M d, Y') }}<br>
                                    <span class="text-xs text-gray-400">{{ $test->created_at->format('h:i A') }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($test->status === 'completed')
                                        @php
                                            $total = isset($test->questions_json) ? count(json_decode($test->questions_json, true)['questions'] ?? []) : 0;
                                            $percentage = $total > 0 ? round(($test->score / $total) * 100) : 0;
                                            $color = $percentage >= 70 ? 'text-green-600' : ($percentage >= 40 ? 'text-yellow-600' : 'text-red-600');
                                        @endphp
                                        <div class="font-bold {{ $color }} text-lg">{{ $test->score }} <span class="text-gray-400 text-xs font-normal">/ {{ $total }}</span></div>
                                        <div class="text-xs text-gray-500">{{ $percentage }}%</div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($test->status === 'completed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Completed
                                        </span>
                                    @elseif($test->status === 'pending' || $test->status === 'processing')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            {{ ucfirst($test->status) }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            {{ ucfirst($test->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('ai-test.show', $test->uuid) }}" class="inline-flex items-center px-3 py-1.5 border border-primary text-primary text-sm font-medium rounded-lg hover:bg-blue-50 transition">
                                        View Analysis
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($mockTests->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $mockTests->links() }}
                </div>
            @endif
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-xl border border-gray-200">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-3xl text-gray-400">quiz</span>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">No Tests Found</h3>
            <p class="text-gray-600 mb-6">You haven't attempted any mock tests yet.</p>
            <a href="{{ route('ai-test.landing') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg font-bold hover:bg-blue-700 transition">
                Start a Mock Test
            </a>
        </div>
    @endif
</div>
@endsection
