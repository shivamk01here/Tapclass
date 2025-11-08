<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Analytics - Htc Admin</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>tailwind.config={theme:{extend:{colors:{"primary":"#13a4ec"},fontFamily:{"display":["Manrope","sans-serif"]}}}}</script>
</head>
<body class="bg-gray-50 font-display">
<header class="bg-white border-b px-6 py-4">
<a href="{{ route('admin.dashboard') }}" class="text-primary font-bold">← Back</a>
</header>
<main class="max-w-7xl mx-auto px-4 py-8">
<h1 class="text-3xl font-black mb-6">Analytics</h1>
<p class="text-gray-500">View platform statistics and performance metrics.</p>
</main>
</body>
</html>
