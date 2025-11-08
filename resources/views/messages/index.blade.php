<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Messages - Htc</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>tailwind.config={theme:{extend:{colors:{"primary":"#13a4ec"},fontFamily:{"display":["Manrope","sans-serif"]}}}}</script>
</head>
<body class="bg-gray-50 font-display">
<header class="bg-white border-b px-6 py-4">
<a href="{{ auth()->user()->isStudent() ? route('student.dashboard') : route('tutor.dashboard') }}" class="text-primary font-bold">← Back</a>
</header>
<main class="max-w-7xl mx-auto px-4 py-8">
<h1 class="text-3xl font-black mb-6">Messages</h1>
@if($conversations->isEmpty())
<p class="text-gray-500">No conversations yet.</p>
@else
<div class="space-y-4">
@foreach($conversations as $otherUser)
<a href="{{ route('messages.chat', $otherUser) }}" class="block bg-white p-4 rounded-lg border hover:border-primary transition">
<div class="flex items-center gap-4">
<div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
<span class="text-primary font-bold text-lg">{{ substr($otherUser->name, 0, 1) }}</span>
</div>
<div>
<p class="font-bold">{{ $otherUser->name }}</p>
<p class="text-sm text-gray-500">{{ $otherUser->email }}</p>
</div>
</div>
</a>
@endforeach
</div>
@endif
</main>
</body>
</html>
