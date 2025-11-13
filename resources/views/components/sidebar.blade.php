<!-- Mobile overlay -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden" onclick="toggleMobileSidebar()"></div>

<!-- Icon-only sidebar with tooltips -->
<aside id="sidebar" class="fixed left-0 top-0 h-screen w-16 lg:w-16 bg-white border-r border-gray-200 flex flex-col items-center py-6 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
    <!-- Logo -->
    <a href="{{ $dashboardRoute }}" class="mb-8">
        <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
            <span class="material-symbols-outlined text-white text-xl">school</span>
        </div>
    </a>

    <!-- Navigation Items -->
    <nav class="flex-1 flex flex-col gap-4 w-full">
        @foreach($menuItems as $item)
        <a href="{{ $item['route'] }}" 
           class="group relative flex items-center justify-center h-12 w-full {{ $item['active'] ? 'bg-primary/20 border-l-4 border-primary' : 'hover:bg-primary/10' }} transition-colors"
           title="{{ $item['label'] }}">
            <span class="material-symbols-outlined {{ $item['active'] ? 'text-primary' : 'text-gray-600 group-hover:text-primary' }}">{{ $item['icon'] }}</span>
            
            <!-- Tooltip (hidden on mobile) -->
            <div class="hidden lg:block absolute left-full ml-2 px-3 py-2 bg-gray-900 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 pointer-events-none whitespace-nowrap transition-opacity z-50">
                {{ $item['label'] }}
                <div class="absolute top-1/2 -left-1 -translate-y-1/2 w-2 h-2 bg-gray-900 rotate-45"></div>
            </div>
        </a>
        @endforeach
    </nav>

    <!-- Settings & Logout -->
    <div class="mt-auto mb-2 flex flex-col items-center w-full gap-2">
        <a href="{{ $settingsRoute }}" class="group relative flex items-center justify-center h-10 w-full hover:bg-primary/10 transition-colors" title="Settings">
            <span class="material-symbols-outlined text-gray-600 group-hover:text-primary">settings</span>
            <div class="hidden lg:block absolute left-full ml-2 px-3 py-2 bg-gray-900 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 pointer-events-none whitespace-nowrap transition-opacity z-50">
                Settings
                <div class="absolute top-1/2 -left-1 -translate-y-1/2 w-2 h-2 bg-gray-900 rotate-45"></div>
            </div>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit" class="group relative flex items-center justify-center h-10 w-full hover:bg-red-50 transition-colors" title="Logout">
                <span class="material-symbols-outlined text-red-600">logout</span>
                <div class="hidden lg:block absolute left-full ml-2 px-3 py-2 bg-gray-900 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 pointer-events-none whitespace-nowrap transition-opacity z-50">
                    Logout
                    <div class="absolute top-1/2 -left-1 -translate-y-1/2 w-2 h-2 bg-gray-900 rotate-45"></div>
                </div>
            </button>
        </form>
    </div>
</aside>

<script>
function toggleMobileSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
}
</script>
