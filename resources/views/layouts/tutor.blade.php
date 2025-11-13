<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'Htc')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>
      tailwind.config = {
        darkMode: 'class',
        theme: {
          extend: {
            colors: { primary: '#006cab', secondary: '#FFA500' },
            fontFamily: { display: ['Manrope','sans-serif'] }
          }
        }
      }
    </script>
    @stack('styles')
</head>
<body class="bg-[#f6f7f8] dark:bg-gray-900 dark:text-gray-100 font-display text-[13px]">

<div class="hidden md:block">
    @include('components.sidebar', [
        'dashboardRoute' => route('tutor.dashboard'),
        'settingsRoute' => route('tutor.profile'),
        'menuItems' => [
            ['icon' => 'home', 'label' => 'Dashboard', 'route' => route('tutor.dashboard'), 'active' => request()->routeIs('tutor.dashboard')],
            ['icon' => 'calendar_month', 'label' => 'My Bookings', 'route' => route('tutor.bookings'), 'active' => request()->routeIs('tutor.bookings')],
            ['icon' => 'payments', 'label' => 'Earnings', 'route' => route('tutor.earnings'), 'active' => request()->routeIs('tutor.earnings')],
            ['icon' => 'schedule', 'label' => 'Availability', 'route' => route('tutor.availability'), 'active' => request()->routeIs('tutor.availability')],
            ['icon' => 'star', 'label' => 'Reviews', 'route' => route('tutor.reviews'), 'active' => request()->routeIs('tutor.reviews')],
            ['icon' => 'notifications', 'label' => 'Notifications', 'route' => route('tutor.notifications'), 'active' => request()->routeIs('tutor.notifications')]
        ]
    ])
</div>

<div class="md:ml-16 pb-20 md:pb-0">
    <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-4 md:px-6 py-3 sticky top-0 z-40">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4 flex-1">
                <div class="flex items-center gap-2">
                    
                    <span class="text-xl font-black">Htc</span>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <!-- Notification bell -->
                @php $unread = \App\Models\Notification::where('user_id', auth()->id())->where('is_read', false)->count(); @endphp
                <button type="button" onclick="openTutorNotify()" class="relative p-2 rounded hover:bg-gray-100" title="Notifications">
                    <span class="material-symbols-outlined text-[20px]">notifications</span>
                    @if($unread>0)
                        <span class="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-[10px] rounded-full w-4 h-4 flex items-center justify-center">{{ $unread }}</span>
                    @endif
                </button>
                <!-- Theme toggle -->
                <button type="button" onclick="toggleTheme()" class="p-2 rounded hover:bg-gray-100" title="Toggle theme">
                    <span id="themeIcon" class="material-symbols-outlined text-[20px]">dark_mode</span>
                </button>
                <!-- Avatar small -->
                @php $pp = auth()->user()->profile_picture; $ppUrl = $pp ? (\Illuminate\Support\Str::startsWith($pp, ['/storage','http']) ? asset(ltrim($pp,'/')) : asset('storage/'.$pp)) : null; @endphp
                @if($ppUrl)
                    <img src="{{ $ppUrl }}" class="w-8 h-8 rounded-full object-cover border" alt="Profile"/>
                @else
                    <div class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center border">
                        <span class="text-primary font-bold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>
                @endif
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</div>

@php
    // Define menu items for mobile nav (5 items max for good UX)
    // Shorter labels are better for mobile
    $mobileMenuItems = [
        ['icon' => 'home', 'label' => 'Home', 'route' => route('tutor.dashboard'), 'active' => request()->routeIs('tutor.dashboard')],
        ['icon' => 'calendar_month', 'label' => 'Bookings', 'route' => route('tutor.bookings'), 'active' => request()->routeIs('tutor.bookings')],
        ['icon' => 'schedule', 'label' => 'Hours', 'route' => route('tutor.availability'), 'active' => request()->routeIs('tutor.availability')],
        ['icon' => 'payments', 'label' => 'Earnings', 'route' => route('tutor.earnings'), 'active' => request()->routeIs('tutor.earnings')],
        ['icon' => 'notifications', 'label' => 'Alerts', 'route' => route('tutor.notifications'), 'active' => request()->routeIs('tutor.notifications')]
    ];
@endphp
<nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50 shadow-inner">
    <div class="flex justify-around items-center h-16 px-2">
        @foreach($mobileMenuItems as $item)
            <a href="{{ $item['route'] }}" class="flex flex-col items-center justify-center text-xs font-medium w-full {{ $item['active'] ? 'text-primary' : 'text-gray-600' }} hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-2xl">{{ $item['icon'] }}</span>
                <span class="mt-1">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>
</nav>


<!-- Notifications Drawer -->
<div id="tutor-notify-overlay" class="fixed inset-0 bg-black/40 z-50 hidden" onclick="closeTutorNotify()"></div>
<div id="tutor-notify-drawer" class="fixed inset-y-0 right-0 w-80 bg-white dark:bg-gray-800 z-50 shadow-xl translate-x-full transition-transform duration-300 flex flex-col">
    <div class="px-4 py-3 border-b flex items-center justify-between">
        <h3 class="font-bold text-sm">Notifications</h3>
        <button onclick="closeTutorNotify()" class="p-1 rounded hover:bg-gray-100"><span class="material-symbols-outlined text-[18px]">close</span></button>
    </div>
    <div id="tutor-notify-list" class="flex-1 overflow-y-auto p-2 text-[12px]"></div>
    <div class="p-3 border-t text-xs"><a class="text-primary font-semibold" href="{{ route('tutor.notifications') }}">View all</a></div>
</div>

@stack('scripts')
<script>
// Theme toggle persist
(function(){
  const key='htc_theme';
  const saved=localStorage.getItem(key);
  if(saved==='dark'){ document.documentElement.classList.add('dark'); }
  document.getElementById('themeIcon')?.classList.toggle('dark_mode', !document.documentElement.classList.contains('dark'));
})();
function toggleTheme(){
  const key='htc_theme';
  const root=document.documentElement; const isDark=root.classList.toggle('dark');
  localStorage.setItem(key, isDark?'dark':'light');
  const ic=document.getElementById('themeIcon'); if(ic){ ic.textContent=isDark?'light_mode':'dark_mode'; }
}
async function openTutorNotify(){
  document.getElementById('tutor-notify-overlay').classList.remove('hidden');
  const dr=document.getElementById('tutor-notify-drawer'); dr.classList.remove('translate-x-full');
  try{
    const res=await fetch('{{ route('tutor.notifications.json') }}');
    const data=await res.json();
    const list=document.getElementById('tutor-notify-list');
    if(!data.notifications || data.notifications.length===0){ list.innerHTML='<div class="p-4 text-gray-500">No notifications</div>'; return; }
    list.innerHTML=data.notifications.map(n=>`<div class=\"p-3 border-b ${n.is_read?'':'bg-blue-50'}\"><div class=\"font-semibold\">${escapeHtml(n.title||'Notification')}</div><div class=\"text-gray-600 mt-0.5\">${escapeHtml(n.message||'')}</div><div class=\"text-gray-400 text-[11px] mt-1\">${new Date(n.created_at).toLocaleString()}</div></div>`).join('');
  }catch(e){ document.getElementById('tutor-notify-list').innerHTML='<div class="p-4 text-red-600">Failed to load</div>'; }
}
function closeTutorNotify(){ document.getElementById('tutor-notify-overlay').classList.add('hidden'); document.getElementById('tutor-notify-drawer').classList.add('translate-x-full'); }
function escapeHtml(s){ return (s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }
</script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
