@extends('layouts.admin')

@section('page-title', 'Site Settings')

@section('content')
<div class="grid md:grid-cols-2 gap-6">
<!-- Platform Settings -->
<div class="bg-white rounded-xl border border-gray-200 p-6">
<h2 class="text-xl font-bold mb-4">Platform Settings</h2>
<form method="POST" action="{{ route('admin.settings.update') }}">
@csrf
<div class="space-y-4">
<div>
<label class="block text-sm font-medium text-gray-700 mb-2">Platform Commission (%)</label>
<input type="number" name="platform_commission" step="0.01" min="0" max="100"
       value="{{ $settings['platform_commission'] ?? 20 }}"
       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary" />
<p class="text-xs text-gray-500 mt-1">Percentage taken from each booking</p>
</div>

<div>
<label class="block text-sm font-medium text-gray-700 mb-2">Min Withdrawal Amount (₹)</label>
<input type="number" name="min_withdrawal_amount" step="0.01" min="0"
       value="{{ $settings['min_withdrawal_amount'] ?? 500 }}"
       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary" />
</div>

<div>
<label class="block text-sm font-medium text-gray-700 mb-2">Site Name</label>
<input type="text" name="site_name"
       value="{{ $settings['site_name'] ?? 'Htc' }}"
       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary" />
</div>

<div>
<label class="block text-sm font-medium text-gray-700 mb-2">Support Email</label>
<input type="email" name="support_email"
       value="{{ $settings['support_email'] ?? 'support@Htc.com' }}"
       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary" />
</div>

<button type="submit" class="w-full px-6 py-3 bg-primary text-white rounded-lg font-bold hover:bg-primary/90">
Save Settings
</button>
</div>
</form>
</div>

<!-- Subjects Management -->
<div class="bg-white rounded-xl border border-gray-200 p-6">
<h2 class="text-xl font-bold mb-4">Available Subjects</h2>
<div class="space-y-2 mb-4 max-h-96 overflow-y-auto">
@foreach($subjects as $subject)
<div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
<span class="font-medium">{{ $subject->name }}</span>
<span class="text-xs text-gray-500">{{ $subject->slug }}</span>
</div>
@endforeach
</div>
<p class="text-sm text-gray-500">Subject management coming soon</p>
</div>
</div>
@endsection
