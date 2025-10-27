@extends('layouts.student')

@section('title', 'Page Title')

@section('content')
<body class="bg-gray-50 font-display">
<header class="bg-white border-b px-6 py-4">
<div class="flex items-center justify-between max-w-7xl mx-auto">
<a href="{{ route('student.dashboard') }}" class="flex items-center gap-2 text-primary">
<span class="material-symbols-outlined">arrow_back</span>
<span class="font-bold">Back</span>
</a>
</div>
</header>

<main class="max-w-4xl mx-auto px-4 py-8">
<h1 class="text-3xl font-black mb-6">Notifications</h1>

<div class="space-y-3">
@forelse($notifications as $notification)
<div class="bg-white rounded-lg border p-4 {{ $notification->is_read ? 'opacity-60' : '' }}">
<div class="flex items-start gap-3">
<span class="material-symbols-outlined text-primary text-2xl">notifications</span>
<div class="flex-1">
<h3 class="font-bold">{{ $notification->title }}</h3>
<p class="text-sm text-gray-600 mt-1">{{ $notification->message }}</p>
<p class="text-xs text-gray-400 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
</div>
@if(!$notification->is_read)
<span class="w-3 h-3 rounded-full bg-primary"></span>
@endif
</div>
</div>
@empty
<div class="text-center py-12">
<span class="material-symbols-outlined text-gray-300 text-6xl mb-4">notifications_off</span>
<p class="text-gray-500">No notifications yet</p>
</div>
@endforelse
</div>

<div class="mt-6">{{ $notifications->links() }}</div>
</main>
</body>
</html>
@endsection