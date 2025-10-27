@extends('layouts.tutor')

@section('title', 'Page Title')

@section('content')
<body class="bg-gray-50 font-display">
<header class="bg-white border-b px-6 py-4">
<a href="{{ route('tutor.dashboard') }}" class="text-primary font-bold">← Back</a>
</header>
<main class="max-w-7xl mx-auto px-4 py-8">
<h1 class="text-3xl font-black mb-6">Earnings</h1>
<p class="text-gray-500">View your earnings history and request withdrawals.</p>
</main>
</body>
</html>
@endsection
